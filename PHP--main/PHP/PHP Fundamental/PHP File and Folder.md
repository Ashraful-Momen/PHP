# Complete PHP File and Folder Handling Guide

## Table of Contents
1. [File Operations](#file-operations)
2. [Directory Operations](#directory-operations)
3. [File Uploading](#file-uploading)
4. [File Permissions](#file-permissions)
5. [File Information](#file-information)
6. [CSV and Excel Handling](#csv-excel)
7. [ZIP Operations](#zip-operations)
8. [Best Practices](#best-practices)

## 1. File Operations {#file-operations}

### Reading Files
```php
// Method 1: Read entire file into string
$content = file_get_contents('example.txt');
// file_get_contents: Reads entire file into a string
// Returns false on failure, string on success

// Method 2: Read file line by line
$lines = file('example.txt');
// file: Reads entire file into an array
// Each element is one line of the file

// Method 3: Read file using fopen (more control)
$handle = fopen('example.txt', 'r');
// 'r': Read only mode
// Returns file handle resource

if ($handle) {
    while (!feof($handle)) {
        // feof: Checks if end-of-file reached
        $line = fgets($handle);
        // fgets: Gets line from file pointer
        echo $line;
    }
    fclose($handle);
    // fclose: Closes file handle
}

// Method 4: Read specific number of bytes
$handle = fopen('example.txt', 'r');
$chunk = fread($handle, 1024);
// fread: Reads up to 1024 bytes
fclose($handle);

// Method 5: Reading with stream filters
$handle = fopen('php://filter/read=string.toupper/resource=example.txt', 'r');
// Uses PHP stream filter to convert content to uppercase while reading
```

### Writing Files
```php
// Method 1: Write string to file
$success = file_put_contents('output.txt', $content);
// file_put_contents: Writes data to file
// Returns number of bytes written or false on failure

// Method 2: Append to file
$success = file_put_contents('output.txt', $content, FILE_APPEND);
// FILE_APPEND: Append content instead of overwriting

// Method 3: Write using fopen
$handle = fopen('output.txt', 'w');
// 'w': Write only mode (creates new file/truncates existing)
// 'a': Append mode
// 'w+': Write and read mode
fwrite($handle, $content);
// fwrite: Writes string to file
fclose($handle);

// Method 4: Write with exclusive lock
$handle = fopen('output.txt', 'w');
if (flock($handle, LOCK_EX)) {
    // LOCK_EX: Exclusive lock
    fwrite($handle, $content);
    flock($handle, LOCK_UN);
    // LOCK_UN: Release lock
}
fclose($handle);

// Method 5: Write with error handling
try {
    $handle = fopen('output.txt', 'w');
    if ($handle === false) {
        throw new Exception('Failed to open file');
    }
    
    if (fwrite($handle, $content) === false) {
        throw new Exception('Failed to write to file');
    }
} catch (Exception $e) {
    error_log($e->getMessage());
} finally {
    if (isset($handle) && $handle !== false) {
        fclose($handle);
    }
}
```

## 2. Directory Operations {#directory-operations}

### Directory Creation and Listing
```php
// Create directory
if (!is_dir('new_folder')) {
    mkdir('new_folder', 0755, true);
    // 0755: Directory permissions
    // true: Create nested directories
}

// List directory contents
$files = scandir('directory_path');
// scandir: Gets array of files and directories

// Recursive directory iterator
$iterator = new RecursiveDirectoryIterator('directory_path');
$files = new RecursiveIteratorIterator($iterator);
foreach ($files as $file) {
    if ($file->isFile()) {
        echo $file->getPathname();
        // Get full path of file
    }
}

// Filter specific files
$files = glob('directory/*.txt');
// glob: Find pathnames matching pattern

// Custom directory scanning
function scanDirectory($dir) {
    $result = [];
    $files = array_diff(scandir($dir), ['.', '..']);
    // array_diff: Remove . and .. entries
    
    foreach ($files as $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            $result[$file] = scanDirectory($path);
        } else {
            $result[] = $file;
        }
    }
    return $result;
}
```

### Directory Management
```php
// Copy directory recursively
function copyDir($src, $dst) {
    // Create destination if it doesn't exist
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }
    
    // Open source directory
    $dir = opendir($src);
    while ($file = readdir($dir)) {
        if ($file != '.' && $file != '..') {
            $srcFile = $src . '/' . $file;
            $dstFile = $dst . '/' . $file;
            
            if (is_dir($srcFile)) {
                copyDir($srcFile, $dstFile);
            } else {
                copy($srcFile, $dstFile);
            }
        }
    }
    closedir($dir);
}

// Delete directory recursively
function deleteDir($dir) {
    if (!is_dir($dir)) {
        return;
    }
    
    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            deleteDir($path);
        } else {
            unlink($path);
            // unlink: Delete file
        }
    }
    rmdir($dir);
    // rmdir: Remove directory
}
```

## 3. File Uploading {#file-uploading}

### Basic File Upload
```php
// HTML Form
<form enctype="multipart/form-data" method="post">
    <input type="file" name="uploadedFile">
    <input type="submit" value="Upload">
</form>

// PHP Upload Handler
if ($_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
    // Check file size
    if ($_FILES['uploadedFile']['size'] > 5000000) {
        die('File too large');
    }
    
    // Check file type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $_FILES['uploadedFile']['tmp_name']);
    finfo_close($finfo);
    
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    if (!in_array($mimeType, $allowedTypes)) {
        die('Invalid file type');
    }
    
    // Generate safe filename
    $filename = basename($_FILES['uploadedFile']['name']);
    $filename = preg_replace('/[^a-zA-Z0-9_.-]/', '', $filename);
    
    // Move uploaded file
    $uploadPath = 'uploads/' . $filename;
    if (!move_uploaded_file(
        $_FILES['uploadedFile']['tmp_name'],
        $uploadPath
    )) {
        die('Failed to move uploaded file');
    }
}
```

### Multiple File Upload
```php
// HTML Form
<form enctype="multipart/form-data" method="post">
    <input type="file" name="files[]" multiple>
    <input type="submit" value="Upload Files">
</form>

// PHP Handler
foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
    if ($_FILES['files']['error'][$key] === UPLOAD_ERR_OK) {
        $filename = $_FILES['files']['name'][$key];
        $uploadPath = 'uploads/' . basename($filename);
        
        if (move_uploaded_file($tmpName, $uploadPath)) {
            echo "File $filename uploaded successfully";
        }
    }
}
```

## 4. File Permissions {#file-permissions}

### Permission Management
```php
// Check permissions
$perms = fileperms('example.txt');
// Returns permissions in decimal format

// Convert to octal
$octal = substr(sprintf('%o', $perms), -4);
// sprintf: Format number as octal
// substr: Get last 4 characters

// Change permissions
chmod('example.txt', 0644);
// 0644: Owner rw, Group r, Others r

// Change owner
chown('example.txt', 'username');
// Changes file owner

// Change group
chgrp('example.txt', 'groupname');
// Changes file group

// Check access
is_readable('example.txt');  // Check if readable
is_writable('example.txt'); // Check if writable
is_executable('example.txt'); // Check if executable
```

## 5. File Information {#file-information}

### File Statistics
```php
// Get file info
$info = stat('example.txt');
// Returns array of file statistics

// Get file size
$size = filesize('example.txt');
// Returns file size in bytes

// Get file modification time
$mtime = filemtime('example.txt');
// Returns Unix timestamp

// Get file type
$type = filetype('example.txt');
// Returns file type (file, dir, etc.)

// Check if file exists
if (file_exists('example.txt')) {
    // File or directory exists
}

// Get file extension
$ext = pathinfo('example.txt', PATHINFO_EXTENSION);
// Returns file extension

// Get mime type
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, 'example.txt');
finfo_close($finfo);
```

## 6. CSV and Excel Handling {#csv-excel}

### CSV Operations
```php
// Read CSV
$handle = fopen('data.csv', 'r');
while (($data = fgetcsv($handle)) !== false) {
    // $data is array of fields
    print_r($data);
}
fclose($handle);

// Write CSV
$handle = fopen('output.csv', 'w');
foreach ($data as $row) {
    fputcsv($handle, $row);
    // Writes array as CSV line
}
fclose($handle);

// Using built-in functions
$csv = array_map('str_getcsv', file('data.csv'));
// Converts CSV file to array
```

### Excel Operations (using PHPSpreadsheet)
```php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Read Excel
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('file.xlsx');
$worksheet = $spreadsheet->getActiveSheet();
$data = $worksheet->toArray();

// Write Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World');

$writer = new Xlsx($spreadsheet);
$writer->save('output.xlsx');
```

## 7. ZIP Operations {#zip-operations}

### ZIP File Handling
```php
// Create ZIP archive
$zip = new ZipArchive();
if ($zip->open('archive.zip', ZipArchive::CREATE) === TRUE) {
    // Add files to archive
    $zip->addFile('example.txt', 'example.txt');
    
    // Add directory
    $zip->addEmptyDir('directory');
    
    // Add file with new name
    $zip->addFile('source.txt', 'directory/newname.txt');
    
    $zip->close();
}

// Extract ZIP archive
$zip = new ZipArchive();
if ($zip->open('archive.zip') === TRUE) {
    $zip->extractTo('extract_path/');
    $zip->close();
}

// Read ZIP contents
$zip = new ZipArchive();
if ($zip->open('archive.zip') === TRUE) {
    for ($i = 0; $i < $zip->numFiles; $i++) {
        echo $zip->getNameIndex($i) . "\n";
    }
    $zip->close();
}
```

## 8. Best Practices {#best-practices}

### Error Handling and Security
```php
// Secure file operations
class FileHandler {
    private $allowedTypes = ['jpg', 'png', 'pdf'];
    private $maxSize = 5000000; // 5MB
    
    public function validateFile($file) {
        // Check file size
        if ($file['size'] > $this->maxSize) {
            throw new Exception('File too large');
        }
        
        // Check file type
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowedTypes)) {
            throw new Exception('Invalid file type');
        }
        
        return true;
    }
    
    public function secureFilename($filename) {
        // Remove dangerous characters
        $filename = preg_replace('/[^a-zA-Z0-9_.-]/', '', $filename);
        
        // Add unique identifier
        $info = pathinfo($filename);
        return uniqid() . '_' . $info['filename'] . '.' . $info['extension'];
    }
}

// Safe file reading
function safeReadFile($filepath) {
    try {
        if (!is_readable($filepath)) {
            throw new Exception('File not readable');
        }
        
        $content = file_get_contents($filepath);
        if ($content === false) {
            throw new Exception('Failed to read file');
        }
        
        return $content;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}
```

Remember:
1. Always validate file uploads
2. Use appropriate error handling
3. Implement proper file permissions
4. Consider security implications
5. Use resource cleanup
6. Handle large files appropriately
7. Implement logging for file operations
8. Use appropriate character encoding
9. Consider concurrent access issues
10. Document file handling procedures

This guide covers comprehensive aspects of file and folder handling in PHP with detailed explanations for each operation.
