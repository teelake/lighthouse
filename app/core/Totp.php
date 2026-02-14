<?php
/**
 * RFC 6238 TOTP - Google Authenticator compatible
 * Pure PHP, no dependencies
 */
namespace App\Core;

class Totp
{
    private static $base32Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    /** Generate a random 16-char Base32 secret */
    public static function generateSecret(): string
    {
        $bytes = random_bytes(10);
        return self::base32Encode($bytes);
    }

    /** Verify a 6-digit code against the secret (30s window) */
    public static function verify(string $secret, string $code): bool
    {
        $code = preg_replace('/\D/', '', $code);
        if (strlen($code) !== 6) return false;
        $timeSlice = floor(time() / 30);
        for ($i = -1; $i <= 1; $i++) {
            if (self::getCode($secret, $timeSlice + $i) === $code) {
                return true;
            }
        }
        return false;
    }

    /** Get current code for the secret (for QR display) */
    public static function getCode(string $secret, ?int $timeSlice = null): string
    {
        $timeSlice = $timeSlice ?? floor(time() / 30);
        $secretKey = self::base32Decode($secret);
        $time = pack('N*', 0) . pack('N*', $timeSlice);
        $hash = hash_hmac('sha1', $time, $secretKey, true);
        $offset = ord(substr($hash, -1)) & 0x0f;
        $truncated = (
            ((ord($hash[$offset]) & 0x7f) << 24) |
            ((ord($hash[$offset + 1]) & 0xff) << 16) |
            ((ord($hash[$offset + 2]) & 0xff) << 8) |
            (ord($hash[$offset + 3]) & 0xff)
        );
        return str_pad((string)($truncated % 1000000), 6, '0', STR_PAD_LEFT);
    }

    /** Build otpauth URI for QR code */
    public static function getUri(string $secret, string $email, string $issuer = 'Lighthouse Admin'): string
    {
        $label = rawurlencode($issuer . ':' . $email);
        return "otpauth://totp/{$label}?secret={$secret}&issuer=" . rawurlencode($issuer);
    }

    private static function base32Decode(string $input): string
    {
        $input = strtoupper(str_replace(' ', '', $input));
        $output = '';
        $v = 0;
        $vBits = 0;
        for ($i = 0; $i < strlen($input); $i++) {
            $c = $input[$i];
            $pos = strpos(self::$base32Chars, $c);
            if ($pos === false) continue;
            $v = ($v << 5) | $pos;
            $vBits += 5;
            if ($vBits >= 8) {
                $vBits -= 8;
                $output .= chr(($v >> $vBits) & 0xff);
            }
        }
        return $output;
    }

    private static function base32Encode(string $input): string
    {
        $output = '';
        $v = 0;
        $vBits = 0;
        for ($i = 0; $i < strlen($input); $i++) {
            $v = ($v << 8) | ord($input[$i]);
            $vBits += 8;
            while ($vBits >= 5) {
                $vBits -= 5;
                $output .= self::$base32Chars[($v >> $vBits) & 0x1f];
            }
        }
        if ($vBits > 0) {
            $output .= self::$base32Chars[($v << (5 - $vBits)) & 0x1f];
        }
        return $output;
    }
}
