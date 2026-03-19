<?php
namespace App\Services;

/**
 * Image upload with validation, compression, and optimization.
 * All uploads (backend + frontend) are compressed without visible quality loss.
 * - JPEG: quality 88, progressive encoding, EXIF stripped
 * - PNG: max compression (9), alpha preserved
 * - WebP/AVIF: optimized quality
 * - SVG: validated (scripts stripped)
 */
class ImageUpload
{
    private const ALLOWED_MIMES = [
        'image/jpeg',
        'image/png',
        'image/avif',
        'image/webp',
        'image/svg+xml',
    ];
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'avif', 'webp', 'svg'];
    private const MAX_DIMENSION = 2400;
    /** JPEG quality 85–90: visually lossless, ~30–50% smaller than 95+ */
    private const JPEG_QUALITY = 88;
    /** PNG compression 9: max lossless compression */
    private const PNG_COMPRESSION = 9;
    private const WEBP_QUALITY = 88;
    private const AVIF_QUALITY = 85;

    /** @var string|null */
    private $lastError;

    public function upload(string $formFieldName, string $subdir = 'general'): ?string
    {
        $this->lastError = null;
        $file = $_FILES[$formFieldName] ?? null;

        if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->lastError = $this->getUploadErrorMessage($file['error']);
            return null;
        }

        $maxSize = defined('MAX_UPLOAD_SIZE') ? MAX_UPLOAD_SIZE : (10 * 1024 * 1024);
        if ($file['size'] > $maxSize) {
            $this->lastError = 'File is too large. Maximum ' . round($maxSize / 1024 / 1024) . 'MB allowed.';
            return null;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mime = $file['type'] ?? '';

        if (!in_array($ext, self::ALLOWED_EXTENSIONS, true)) {
            $this->lastError = 'Invalid file type. Allowed: jpg, jpeg, png, avif, webp, svg';
            return null;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detectedMime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($detectedMime, self::ALLOWED_MIMES, true)) {
            $this->lastError = 'Invalid file type. Allowed: jpg, jpeg, png, avif, webp, svg';
            return null;
        }

        $baseDir = defined('UPLOAD_PATH') ? UPLOAD_PATH : (ROOT_PATH . '/public/uploads');
        $imageDir = $baseDir . '/images/' . $subdir . '/' . date('Y');
        if (!is_dir($imageDir)) {
            if (!@mkdir($imageDir, 0755, true)) {
                $this->lastError = 'Failed to create upload directory.';
                return null;
            }
        }

        $basename = bin2hex(random_bytes(8)) . '.' . $ext;
        $filepath = $imageDir . '/' . $basename;

        if ($ext === 'svg') {
            $content = file_get_contents($file['tmp_name']);
            if ($content === false) {
                $this->lastError = 'Failed to read SVG file.';
                return null;
            }
            if (preg_match('/<script|javascript:|on\w+=/i', $content)) {
                $this->lastError = 'SVG contains potentially unsafe content.';
                return null;
            }
            if (!move_uploaded_file($file['tmp_name'], $filepath)) {
                $this->lastError = 'Failed to save file.';
                return null;
            }
        } else {
            $result = $this->optimizeAndSave($file['tmp_name'], $filepath, $ext, $detectedMime);
            if (!$result) {
                return null;
            }
        }

        $webPath = '/uploads/images/' . $subdir . '/' . date('Y') . '/' . $basename;
        return rtrim(BASE_URL ?? '', '/') . $webPath;
    }

    /**
     * Optimize raster image: resize if oversized, compress, strip EXIF, progressive JPEG.
     */
    private function optimizeAndSave(string $tmpPath, string $destPath, string $ext, string $mime): bool
    {
        $img = $this->loadImage($tmpPath, $mime);
        if (!$img) {
            if (in_array($ext, ['avif'], true) && !function_exists('imagecreatefromavif')) {
                return @copy($tmpPath, $destPath);
            }
            $this->lastError = 'Could not process image. Try a different format.';
            return false;
        }

        $w = imagesx($img);
        $h = imagesy($img);
        if ($w <= 0 || $h <= 0) {
            imagedestroy($img);
            $this->lastError = 'Invalid image dimensions.';
            return false;
        }

        if (in_array($ext, ['png', 'webp'], true)) {
            imagealphablending($img, false);
            imagesavealpha($img, true);
        }

        if ($w > self::MAX_DIMENSION || $h > self::MAX_DIMENSION) {
            $ratio = min(self::MAX_DIMENSION / $w, self::MAX_DIMENSION / $h);
            $nw = (int) round($w * $ratio);
            $nh = (int) round($h * $ratio);
            $resized = imagescale($img, $nw, $nh);
            imagedestroy($img);
            if (!$resized) {
                $this->lastError = 'Failed to resize image.';
                return false;
            }
            $img = $resized;
            if (in_array($ext, ['png', 'webp'], true)) {
                imagealphablending($img, false);
                imagesavealpha($img, true);
            }
        }

        if ($ext === 'jpg' || $ext === 'jpeg') {
            imageinterlace($img, 1);
            $saved = imagejpeg($img, $destPath, self::JPEG_QUALITY);
        } elseif ($ext === 'png') {
            $saved = imagepng($img, $destPath, self::PNG_COMPRESSION);
        } elseif ($ext === 'avif' && function_exists('imageavif')) {
            $saved = imageavif($img, $destPath, self::AVIF_QUALITY);
        } elseif ($ext === 'webp' && function_exists('imagewebp')) {
            $saved = imagewebp($img, $destPath, self::WEBP_QUALITY);
        } else {
            $saved = imagejpeg($img, $destPath, self::JPEG_QUALITY);
        }

        imagedestroy($img);
        if (!$saved) {
            $this->lastError = 'Failed to save image.';
            return false;
        }
        return true;
    }

    private function loadImage(string $path, string $mime)
    {
        if ($mime === 'image/jpeg') {
            return @imagecreatefromjpeg($path);
        }
        if ($mime === 'image/png') {
            return @imagecreatefrompng($path);
        }
        if ($mime === 'image/webp' && function_exists('imagecreatefromwebp')) {
            return @imagecreatefromwebp($path);
        }
        if ($mime === 'image/avif' && function_exists('imagecreatefromavif')) {
            return @imagecreatefromavif($path);
        }
        if ($mime === 'image/gif') {
            return @imagecreatefromgif($path);
        }
        return null;
    }

    /**
     * Optimize an image file in-place. Use for uploads outside ImageUpload (e.g. email attachments).
     * Strips EXIF, compresses, and resizes if needed.
     */
    public static function optimizeFile(string $filepath): bool
    {
        if (!is_file($filepath)) {
            return false;
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $filepath);
        finfo_close($finfo);

        $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
        $rasterMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($mime, $rasterMimes, true)) {
            return true;
        }

        $uploader = new self();
        $img = $uploader->loadImage($filepath, $mime);
        if (!$img) {
            return true;
        }

        $w = imagesx($img);
        $h = imagesy($img);
        if ($w <= 0 || $h <= 0) {
            imagedestroy($img);
            return false;
        }

        if (in_array($ext, ['png', 'webp', 'gif'], true)) {
            imagealphablending($img, false);
            imagesavealpha($img, true);
        }

        $max = self::MAX_DIMENSION;
        if ($w > $max || $h > $max) {
            $ratio = min($max / $w, $max / $h);
            $nw = (int) round($w * $ratio);
            $nh = (int) round($h * $ratio);
            $resized = imagescale($img, $nw, $nh);
            imagedestroy($img);
            if (!$resized) {
                return false;
            }
            $img = $resized;
            if (in_array($ext, ['png', 'webp', 'gif'], true)) {
                imagealphablending($img, false);
                imagesavealpha($img, true);
            }
        }

        $saved = false;
        if ($ext === 'jpg' || $ext === 'jpeg') {
            imageinterlace($img, 1);
            $saved = imagejpeg($img, $filepath, self::JPEG_QUALITY);
        } elseif ($ext === 'png') {
            $saved = imagepng($img, $filepath, self::PNG_COMPRESSION);
        } elseif ($ext === 'webp' && function_exists('imagewebp')) {
            $saved = imagewebp($img, $filepath, self::WEBP_QUALITY);
        } elseif ($ext === 'gif') {
            $saved = imagegif($img, $filepath);
        }
        imagedestroy($img);
        return $saved;
    }

    private function getUploadErrorMessage(int $code): string
    {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds server limit.',
            UPLOAD_ERR_FORM_SIZE => 'File is too large.',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Server configuration error.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file.',
            UPLOAD_ERR_EXTENSION => 'Upload blocked by server extension.',
        ];
        return $errors[$code] ?? 'Unknown upload error.';
    }

    public function getLastError(): ?string
    {
        return $this->lastError;
    }

    public static function resolve(string $formFieldName, string $existingValue, string $subdir = 'general'): string
    {
        $uploader = new self();
        $url = $uploader->upload($formFieldName, $subdir);
        if ($url !== null) {
            return $url;
        }
        if ($uploader->getLastError()) {
            throw new \RuntimeException($uploader->getLastError());
        }
        return $existingValue;
    }
}
