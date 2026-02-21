<?php
namespace App\Services;

/**
 * Resume/CV upload - PDF, DOC, DOCX with validation
 */
class ResumeUpload
{
    private const ALLOWED_MIMES = [
        'application/pdf',
        'application/msword',                                                     // .doc
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
    ];
    private const ALLOWED_EXTENSIONS = ['pdf', 'doc', 'docx'];
    private const MAX_SIZE_MB = 5;

    private ?string $lastError = null;

    public function upload(string $formFieldName): ?string
    {
        $this->lastError = null;
        $file = $_FILES[$formFieldName] ?? null;

        if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
            $this->lastError = 'Resume is required. Please upload a PDF or Word document.';
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->lastError = $this->getUploadErrorMessage($file['error']);
            return null;
        }

        $maxSize = self::MAX_SIZE_MB * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            $this->lastError = 'Resume must be under ' . self::MAX_SIZE_MB . 'MB.';
            return null;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::ALLOWED_EXTENSIONS, true)) {
            $this->lastError = 'Invalid file type. Allowed: PDF, DOC, DOCX.';
            return null;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detectedMime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($detectedMime, self::ALLOWED_MIMES, true)) {
            $this->lastError = 'Invalid file type. Allowed: PDF, DOC, DOCX.';
            return null;
        }

        $baseDir = defined('UPLOAD_PATH') ? UPLOAD_PATH : (ROOT_PATH . '/public/uploads');
        $resumeDir = $baseDir . '/resumes/' . date('Y');
        if (!is_dir($resumeDir)) {
            if (!@mkdir($resumeDir, 0755, true)) {
                $this->lastError = 'Failed to create upload directory.';
                return null;
            }
        }

        $safeName = substr(preg_replace('/[^a-zA-Z0-9._-]/', '', $file['name']), 0, 80);
        $basename = bin2hex(random_bytes(8)) . '_' . $safeName;
        $filepath = $resumeDir . '/' . $basename;

        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            $this->lastError = 'Failed to save file.';
            return null;
        }

        return '/uploads/resumes/' . date('Y') . '/' . $basename;
    }

    private function getUploadErrorMessage(int $code): string
    {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds server limit.',
            UPLOAD_ERR_FORM_SIZE => 'File is too large. Maximum ' . self::MAX_SIZE_MB . 'MB.',
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
}
