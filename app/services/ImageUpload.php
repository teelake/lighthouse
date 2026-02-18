<?php
namespace App\Services;

/**
 * Image upload with validation and optimization.
 * Accepted types: jpg, jpeg, png, avif, svg
 */
class ImageUpload
{
    private const ALLOWED_MIMES = [
        'image/jpeg',
        'image/png',
        'image/avif',
        'image/svg+xml',
    ];
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'avif', 'svg'];
    private const MAX_DIMENSION = 2400;
    private const JPEG_QUALITY = 92;
    private const PNG_COMPRESSION = 6;

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
            $this->lastError = 'Invalid file type. Allowed: jpg, jpeg, png, avif, svg';
            return null;
        }

        // Verify MIME (finfo is more reliable)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detectedMime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedMimes = self::ALLOWED_MIMES;
        if (!in_array($detectedMime, $allowedMimes, true)) {
            $this->lastError = 'Invalid file type. Allowed: jpg, jpeg, png, avif, svg';
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
            // SVG: validate (strip scripts), then move
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
            // Raster: optimize and save
            $result = $this->optimizeAndSave($file['tmp_name'], $filepath, $ext, $detectedMime);
            if (!$result) {
                return null;
            }
        }

        $webPath = '/uploads/images/' . $subdir . '/' . date('Y') . '/' . $basename;
        $fullUrl = rtrim(BASE_URL, '/') . $webPath;
        return $fullUrl;
    }

    private function optimizeAndSave(string $tmpPath, string $destPath, string $ext, string $mime): bool
    {
        $img = null;
        if (in_array($mime, ['image/jpeg', 'image/png'], true)) {
            $img = $mime === 'image/jpeg' ? @imagecreatefromjpeg($tmpPath) : @imagecreatefrompng($tmpPath);
        } elseif ($mime === 'image/avif' && function_exists('imagecreatefromavif')) {
            $img = @imagecreatefromavif($tmpPath);
        } elseif ($mime === 'image/webp' && function_exists('imagecreatefromwebp')) {
            $img = @imagecreatefromwebp($tmpPath);
        }

        if (!$img) {
            // Fallback: copy as-is if GD can't read (e.g. AVIF on older PHP)
            if (in_array($ext, ['avif'], true) && !function_exists('imagecreatefromavif')) {
                if (move_uploaded_file($tmpPath, $destPath)) {
                    return true;
                }
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

        $max = self::MAX_DIMENSION;
        if ($w > $max || $h > $max) {
            $ratio = min($max / $w, $max / $h);
            $nw = (int) round($w * $ratio);
            $nh = (int) round($h * $ratio);
            $resized = imagescale($img, $nw, $nh);
            imagedestroy($img);
            if (!$resized) {
                $this->lastError = 'Failed to resize image.';
                return false;
            }
            $img = $resized;
            $w = $nw;
            $h = $nh;
        }

        $saved = false;
        if ($ext === 'jpg' || $ext === 'jpeg') {
            $saved = imagejpeg($img, $destPath, self::JPEG_QUALITY);
        } elseif ($ext === 'png') {
            $saved = imagepng($img, $destPath, self::PNG_COMPRESSION);
        } elseif ($ext === 'avif' && function_exists('imageavif')) {
            $saved = imageavif($img, $destPath, 85);
        } elseif ($ext === 'webp' && function_exists('imagewebp')) {
            $saved = imagewebp($img, $destPath, 90);
        }

        imagedestroy($img);

        if (!$saved) {
            $this->lastError = 'Failed to save image.';
            return false;
        }
        return true;
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

    /**
     * Resolve image value: use new upload if present, else keep existing (for edits).
     */
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
