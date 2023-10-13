<?php

// Configuration array for filtering
$filterConfig = [
    "hiddenExtensions" => [".tmp", ".bak"], // Add file extensions to hide
    "hiddenDirectories" => ["hidden_dir"], // Add directory names to hide
    "hiddenExtensionsWithWildcards" => ["*.log", "*.shtml", "*.md", "*.php"], // Add wildcard extensions to hide
];

// Function to get directory description
function getDirDescription($dirName)
{
    global $dirDescriptions; // Access the array of directory descriptions from the included file

    // Check if a description is available for this directory
    if (isset($dirDescriptions[$dirName])) {
        return $dirDescriptions[$dirName];
    }

    return ""; // Return an empty string if no description is found
}

// Function to get file description
function getFileDescription($fileName)
{
    global $fileDescriptions; // Access the array of file descriptions from the included file

    // Check if a description is available for this file
    if (isset($fileDescriptions[$fileName])) {
        return $fileDescriptions[$fileName];
    }

    return ""; // Return an empty string if no description is found
}

// Function to read directory descriptions from an external file
function readDirDescriptions($filePath)
{
    $dirDescriptions = [];

    // Check if the file exists
    if (file_exists($filePath)) {
        // Read the file line by line
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Loop through each line and extract directory descriptions
        foreach ($lines as $line) {
            // Split the line into directory name and description using a delimiter (e.g., tab)
            $parts = explode("\t", $line);

            if (count($parts) === 2) {
                $directoryName = trim($parts[0]);
                $description = trim($parts[1]);
                $dirDescriptions[$directoryName] = $description;
            }
        }
    }

    return $dirDescriptions;
}

// Function to read file descriptions from an external file
function readFileDescriptions($filePath)
{
    $fileDescriptions = [];

    // Check if the file exists
    if (file_exists($filePath)) {
        // Include the file to populate the $fileDescriptions array
        include $filePath;
    }

    return $fileDescriptions;
}

// Define an array of filenames, extensions, or wildcards to hide
$hiddenItems = [
    "hidden_file.txt", // Specific file to hide
    ".htaccess",
    "secret_*", // Hide files starting with 'secret_'
    "private-folder", // Hide a specific directory
    "backup*", // Hide directories starting with 'backup'
    "cgi-bin",
    "css",
    "js",
    ".well-known",
    "AUTHORS",
    "COPYING",
    "README.md",
    "TODO",
];

// Function to check if an item (file or directory) should be hidden
function shouldHideItem($itemName, $hiddenItems)
{
    foreach ($hiddenItems as $pattern) {
        if (fnmatch($pattern, $itemName)) {
            return true; // Item matches a pattern, should be hidden
        }
    }
    return false; // Item does not match any pattern, should not be hidden
}

// Usage examples for reading descriptions
$dirDescriptions = readDirDescriptions("indxr_dir_desc.php");
$fileDescriptions = readFileDescriptions("indxr_file_desc.php");

// Function to get MIME type and map to Foundations Icons
function getMIMEIcon($filename)
{
    // Create an array to map MIME types to Foundations Icons
    $mimeToIcon = [
        "image/jpeg" => "photo",
        "image/png" => "photo",
        "image/gif" => "photo",
        "image/webp" => "photo",
        "image/bmp" => "photo", // Add support for BMP
        "image/x-icon" => "photo", // Add support for ICO (Icon)
        "image/svg+xml" => "photo", // Added support for .svg image files
        "video/webm" => "video",
        "video/mp4" => "video",
        "video/ogg" => "video",
        "video/x-matroska" => "video", // Added support for .mkv video files
        "video/ogv" => "video", // Added support for .ogv video files
        "video/avi" => "video", // Added support for .avi video files
        "video/quicktime" => "video", // Added support for .mov video files
        "audio/mpeg" => "music",
        "audio/ogg" => "music",
        "audio/wav" => "music",
        "audio/flac" => "music", // Added support for .flac audio files
        "audio/opus" => "music", // Added support for .opus audio files
        "application/pdf" => "page-pdf",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document" =>
            "page-doc",
        "application/msword" => "page-doc", // Legacy Word Format
        "application/vnd.oasis.opendocument.text" => "page-doc", // OpenDocument Text format
        "application/vnd.ms-excel" => "page",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" => "page",
        "application/vnd.ms-powerpoint" => "page",
        "application/vnd.openxmlformats-officedocument.presentationml.presentation" => "page", 
        "application/x-gzip" => "archive", // Added support for .tar.gz and .tgz files
        "application/x-tar" => "archive", // Added support for .tar files
        "application/zip" => "archive", // Added support for .zip files
        "text/plain" => "page", // Added support for .txt text files
        "font/ttf" => "page", // Added support for .ttf font files
    ];


    // Check if the filename ends with ".tar.gz" or ".tgz"
    if (preg_match('/\.tar\.gz$|\.tgz$/', $filename)) {
        // If it does, set the MIME type to "application/x-gzip"
        $mime = "application/x-gzip";
    } else {
        // Use finfo to get the MIME type of the file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $filename);
        finfo_close($finfo);
    }

    // Determine the MIME type based on the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $extensionToMIME = [
        "tar.gz" => "application/tar+gzip", // Explicitly handle .tar.gz files
        "tgz" => "application/x-gzip",
        "tar" => "application/x-tar",
        "zip" => "application/zip",
    ];

    // Check if the file extension is mapped to a MIME type
    if (array_key_exists($extension, $extensionToMIME)) {
        $mime = $extensionToMIME[$extension];
    }

    // Check if the MIME type is mapped to an icon
    if (isset($mimeToIcon[$mime])) {
        return '<i class="fi-' . $mimeToIcon[$mime] . '"></i>';
    } else {
        return ""; // Return an empty string if no icon is found
    }
}

function testFunction()
{
    echo "Test function is working.";
}
?>
