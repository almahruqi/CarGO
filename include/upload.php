<?php
require_once 'auth.php';

class FileUploader {
    private $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    private $maxFileSize = 5242880; // 5MB
    private $uploadPath = 'uploads/';
    private $errors = [];

    public function __construct() {
        // Create upload directory if it doesn't exist
        if (!file_exists($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
    }

    public function upload($file, $userId) {
        if (!$this->validateFile($file)) {
            return false;
        }

        $fileName = $this->generateUniqueFileName($file['name']);
        $targetPath = $this->uploadPath . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Log the upload
            logActivity($userId, 'file_upload', 'Uploaded file: ' . $fileName);
            return $fileName;
        }

        $this->errors[] = 'Failed to move uploaded file';
        return false;
    }

    private function validateFile($file) {
        // Check if file was uploaded
        if (!isset($file['error']) || is_array($file['error'])) {
            $this->errors[] = 'Invalid file upload';
            return false;
        }

        // Check for upload errors
        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $this->errors[] = 'File is too large';
                return false;
            case UPLOAD_ERR_NO_FILE:
                $this->errors[] = 'No file was uploaded';
                return false;
            default:
                $this->errors[] = 'Unknown upload error';
                return false;
        }

        // Check file size
        if ($file['size'] > $this->maxFileSize) {
            $this->errors[] = 'File is too large';
            return false;
        }

        // Check file type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!in_array($mimeType, $this->allowedTypes)) {
            $this->errors[] = 'Invalid file type';
            return false;
        }

        // Check for malicious content
        if (!$this->isImageSafe($file['tmp_name'])) {
            $this->errors[] = 'File contains malicious content';
            return false;
        }

        return true;
    }

    private function generateUniqueFileName($originalName) {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return uniqid() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
    }

    private function isImageSafe($filePath) {
        // Check if file is a valid image
        if (!getimagesize($filePath)) {
            return false;
        }

        // Check for PHP code injection
        $content = file_get_contents($filePath);
        if (strpos($content, '<?php') !== false) {
            return false;
        }

        return true;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function deleteFile($fileName) {
        $filePath = $this->uploadPath . $fileName;
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    public function getFileUrl($fileName) {
        return $this->uploadPath . $fileName;
    }
}

// Example usage:
/*
$uploader = new FileUploader();
if (isset($_FILES['image'])) {
    $fileName = $uploader->upload($_FILES['image'], $_SESSION['id']);
    if ($fileName) {
        // File uploaded successfully
        $fileUrl = $uploader->getFileUrl($fileName);
    } else {
        // Handle errors
        $errors = $uploader->getErrors();
    }
}
*/
?> 