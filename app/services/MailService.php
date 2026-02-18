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
        $sslOpts = [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ];
        $ctx = stream_context_create(['ssl' => $sslOpts]);
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
            $this->logError($this->lastError . " [{$host}:{$port}]");
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
        $expect = function ($code) use ($read, $self) {
            $line = $read();
            if ($line && (int) substr($line, 0, 3) === $code) return true;
            if ($line && $self->lastError === '') {
                $self->lastError = 'SMTP: ' . trim($line);
            }
            return false;
        };
        $consumeMultiLine = function () use ($read) {
            while ($line = $read()) {
                if (strlen($line) >= 4 && substr($line, 3, 1) === ' ') return;
            }
        };

        try {
        $read(); // greeting
        $write("EHLO " . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
        $consumeMultiLine();
        if ($useTls && !$useSsl) {
            $write("STARTTLS");
            if (!$expect(220)) {
                fclose($sock);
                if ($this->lastError === '') $this->lastError = 'STARTTLS failed';
                return false;
            }
            if (!stream_socket_enable_crypto($sock, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                fclose($sock);
                $this->lastError = 'TLS handshake failed';
                return false;
            }
            $write("EHLO " . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
            $consumeMultiLine();
        }
        $write("AUTH LOGIN");
        if (!$expect(334)) {
            fclose($sock);
            if ($this->lastError === '') $this->lastError = 'SMTP AUTH not supported';
            $this->logError('MailService: ' . $this->lastError);
            return false;
        }
        $write(base64_encode($user));
        if (!$expect(334)) {
            fclose($sock);
            if ($this->lastError === '') $this->lastError = 'SMTP username rejected';
            $this->logError('MailService: ' . $this->lastError);
            return false;
        }
        $write(base64_encode($pass));
        $authLine = $read();
        $authCode = $authLine ? (int) substr($authLine, 0, 3) : 0;
        if (in_array($authCode, [235, 250], true)) {
            $consumeMultiLine();
        } else {
            fclose($sock);
            if ($authLine && $this->lastError === '') $this->lastError = 'SMTP: ' . trim($authLine);
            if ($this->lastError === '') $this->lastError = 'SMTP authentication failed';
            $this->logError('MailService auth failed: ' . $this->lastError);
            return false;
        }
        $write("MAIL FROM:<" . $fromEmail . ">");
        if (!$expect(250)) {
            fclose($sock);
            if ($this->lastError === '') $this->lastError = 'MAIL FROM rejected';
            return false;
        }
        $write("RCPT TO:<" . $to . ">");
        if (!$expect(250)) {
            fclose($sock);
            if ($this->lastError === '') $this->lastError = 'RCPT TO rejected';
            return false;
        }
        $write("DATA");
        if (!$expect(354)) {
            fclose($sock);
            if ($this->lastError === '') $this->lastError = 'DATA rejected';
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
            if ($this->lastError === '') $this->lastError = 'Message rejected';
            return false;
        }
        $write("QUIT");
        } catch (\RuntimeException $e) {
            if (isset($sock) && is_resource($sock)) {
                @fclose($sock);
            }
            $this->logError('MailService: ' . $this->lastError . " [to: $to]");
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

    private function logError(string $msg): void
    {
        $log = (defined('ROOT_PATH') ? ROOT_PATH . '/' : '') . 'php-error.log';
        @file_put_contents($log, '[' . date('Y-m-d H:i:s') . "] $msg\n", FILE_APPEND | LOCK_EX);
    }
}
