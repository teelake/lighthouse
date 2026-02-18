<?php
namespace App\Services;

use App\Models\Setting;

class MailService
{
    private $setting;
    private $lastError = '';

    public function __construct()
    {
        $this->setting = new Setting();
    }

    /**
     * Send an email. Uses SMTP if configured, otherwise PHP mail().
     */
    public function send(string $to, string $toName, string $subject, string $bodyHtml, string $bodyText = ''): bool
    {
        $smtpHost = trim($this->setting->get('smtp_host', ''));
        $smtpPort = (int) $this->setting->get('smtp_port', 587);
        $smtpUser = $this->setting->get('smtp_user', '');
        $smtpPass = $this->setting->get('smtp_pass', '');
        $smtpEnc = strtolower($this->setting->get('smtp_encryption', 'tls'));
        $fromEmail = $this->setting->get('mail_from_email', $this->setting->get('site_email', 'noreply@example.com'));
        $fromName = $this->setting->get('mail_from_name', 'Lighthouse Global Church');

        if (!empty($smtpHost) && !empty($smtpUser)) {
            return $this->sendSmtp($to, $toName, $subject, $bodyHtml, $bodyText, $smtpHost, $smtpPort, $smtpUser, $smtpPass, $smtpEnc, $fromEmail, $fromName);
        }
        return $this->sendMail($to, $subject, $bodyHtml, $fromEmail, $fromName);
    }

    private function sendSmtp(string $to, string $toName, string $subject, string $bodyHtml, string $bodyText,
        string $host, int $port, string $user, string $pass, string $enc, string $fromEmail, string $fromName): bool
    {
        $this->lastError = '';
        $useTls = ($enc === 'tls');
        $useSsl = ($enc === 'ssl');
        $hostPart = $useSsl ? 'ssl://' . $host : $host;
        $errNo = 0;
        $errStr = '';
        $ctx = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
        $sock = @stream_socket_client(
            $hostPart . ':' . $port,
            $errNo,
            $errStr,
            15,
            STREAM_CLIENT_CONNECT,
            $ctx
        );
        if (!$sock) {
            $this->lastError = "Could not connect: $errStr ($errNo)";
            return false;
        }
        stream_set_timeout($sock, 15);
        $self = $this;
        $read = function () use ($sock) { return @fgets($sock, 512); };
        $write = function ($s) use ($sock, $self) {
            $data = $s . "\r\n";
            $n = @fwrite($sock, $data);
            if ($n === false || $n !== strlen($data)) {
                $self->lastError = 'Connection lost (broken pipe)';
                throw new \RuntimeException('SMTP write failed');
            }
        };
        $expect = function ($code) use ($read) {
            $line = $read();
            return $line && (int) substr($line, 0, 3) === $code;
        };

        try {
        $read(); // greeting
        $write("EHLO " . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
        while ($line = $read()) {
            if (substr($line, 3, 1) === ' ') break;
        }
        if ($useTls && !$useSsl) {
            $write("STARTTLS");
            if (!$expect(220)) {
                fclose($sock);
                $this->lastError = 'STARTTLS failed';
                return false;
            }
            $ctx = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
            if (!stream_socket_enable_crypto($sock, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                fclose($sock);
                $this->lastError = 'TLS handshake failed';
                return false;
            }
            $write("EHLO " . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
            while ($line = $read()) {
                if (substr($line, 3, 1) === ' ') break;
            }
        }
        $write("AUTH LOGIN");
        $expect(334);
        $write(base64_encode($user));
        $expect(334);
        $write(base64_encode($pass));
        if (!$expect(235)) {
            fclose($sock);
            $this->lastError = 'SMTP authentication failed';
            return false;
        }
        $write("MAIL FROM:<" . $fromEmail . ">");
        if (!$expect(250)) {
            fclose($sock);
            $this->lastError = 'MAIL FROM rejected';
            return false;
        }
        $write("RCPT TO:<" . $to . ">");
        if (!$expect(250)) {
            fclose($sock);
            $this->lastError = 'RCPT TO rejected';
            return false;
        }
        $write("DATA");
        if (!$expect(354)) {
            fclose($sock);
            $this->lastError = 'DATA rejected';
            return false;
        }
        $headers = "From: " . $this->encodeHeader($fromName, $fromEmail) . "\r\n";
        $headers .= "To: " . ($toName ? $this->encodeHeader($toName, $to) : $to) . "\r\n";
        $headers .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
        $headers .= "MIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n";
        $write($headers . $bodyHtml);
        $write(".");
        if (!$expect(250)) {
            fclose($sock);
            $this->lastError = 'Message rejected';
            return false;
        }
        $write("QUIT");
        } catch (\RuntimeException $e) {
            if (isset($sock) && is_resource($sock)) {
                @fclose($sock);
            }
            return false;
        }
        fclose($sock);
        return true;
    }

    private function encodeHeader(string $name, string $email): string
    {
        if ($name) {
            return "=?UTF-8?B?" . base64_encode($name) . "?= <$email>";
        }
        return $email;
    }

    private function sendMail(string $to, string $subject, string $bodyHtml, string $fromEmail, string $fromName): bool
    {
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: ' . $fromName . ' <' . $fromEmail . '>',
        ];
        return @mail($to, $subject, $bodyHtml, implode("\r\n", $headers));
    }

    public function getLastError(): string
    {
        return $this->lastError;
    }

    public function isSmtpConfigured(): bool
    {
        $host = trim($this->setting->get('smtp_host', ''));
        $user = trim($this->setting->get('smtp_user', ''));
        return $host !== '' && $user !== '';
    }
}
