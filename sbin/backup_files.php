<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$zip = new ZipArchive();
$file_time = date("Y-m-d_H.i.s");
$zipFileName = $_SERVER['DOCUMENT_ROOT'] . '/backup_fs_'.$_SERVER['SERVER_NAME'].'_'.$file_time.'.zip';
if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
    exit("Cannot open <$zipFileName>\n");
}

$directoriesToZip = [$_SERVER['DOCUMENT_ROOT'].'/pub/img', $_SERVER['DOCUMENT_ROOT'].'/pub/upload', $_SERVER['DOCUMENT_ROOT'].'/fs']; // Array of directories to add

    foreach ($directoriesToZip as $sourcePath) {
        // Ensure the path exists and is a directory
        if (!is_dir($sourcePath)) {
            continue;
        }

        // Get the base name of the directory to use as the root in the zip
        $baseDirName = basename($sourcePath);

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourcePath),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($files as $file) {
            // Skip '.' and '..' entries
            if ($file->getFilename() === '.' || $file->getFilename() === '..'  ||  $file->getFilename() === ".htaccess") {
                continue;
            }

            $filePath = $file->getRealPath();
            $relativePath = $baseDirName . '/' . substr($filePath, strlen($sourcePath) + 1); // Relative path inside the zip

            if ($file->isDir()) {
                $zip->addEmptyDir($relativePath);
            } else if ($file->isFile()) {
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    $zip->close();

    if (file_exists($zipFileName)) {
        // Set headers for file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream'); // Generic binary file type
        header('Content-Disposition: attachment; filename="' . basename($zipFileName) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($zipFileName));

        // Clear output buffer and flush
        ob_clean();
        flush();

        // Read the file and output its content
        readfile($zipFileName);
        exit;
    } else {
        echo "File not found.";
    }

?>