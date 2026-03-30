<?php
// upload_security.php 

function secureFileUpload($file, $allowedTypes = [], $maxSize = 5242880) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Ошибка загрузки файла'];
    }
    
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'error' => 'Файл слишком большой'];
    }
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mimeType, $allowedTypes)) {
        return ['success' => false, 'error' => 'Недопустимый тип файла'];
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $safeName = bin2hex(random_bytes(16)) . '.' . $extension;
    
    if (preg_match('/\.(php|phtml|php3|php4|php5|phar|pl|py|jsp|asp|aspx|cgi|sh|bash)$/i', $safeName)) {
        return ['success' => false, 'error' => 'Недопустимое расширение файла'];
    }
    
    return [
        'success' => true,
        'filename' => $safeName,
        'original_name' => $file['name']
    ];
}

function createUploadDirectory($path) {
    if (!file_exists($path)) {
        mkdir($path, 0755, true);
        
        $htaccess = "php_flag engine off\n";
        file_put_contents($path . '/.htaccess', $htaccess);
    }
    return $path;
}
?>
