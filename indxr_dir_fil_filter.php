<?php
    // Define the directory to be indexed
    // Specify the directory path to be indexed
    $requestedDir = isset($_GET['dir']) ? './' . urldecode($_GET['dir']) . '/' : '';
    $directory = './' . $requestedDir;

    // Get a list of all items (files and directories) in the specified directory
    $allItems = scandir($directory);

    // Separate directories and files based on filtering criteria
    $directories = [];
    $files = [];

    foreach ($allItems as $item) {
        $itemPath = $directory . $item;

        if (is_dir($itemPath)) {
            // Check if the directory should be hidden
            if (!in_array($item, $filterConfig['hiddenDirectories'])) {
                $directories[] = $item;
            }
        } elseif (is_file($itemPath)) {
            $extension = pathinfo($item, PATHINFO_EXTENSION);

            // Check if the file should be hidden based on extension or wildcard
            if (
                !in_array($extension, $filterConfig['hiddenExtensions']) &&
                !in_array('*.' . $extension, $filterConfig['hiddenExtensionsWithWildcards'])
            ) {
                $files[] = $item;
            }
        }
    }

    // Use the shouldHideItem function to filter directories and files
    $filteredDirectories = array_filter($directories, function ($dir) use ($hiddenItems) {
        return !shouldHideItem($dir, $hiddenItems);
    });

    $filteredFiles = array_filter($files, function ($file) use ($hiddenItems) {
        return !shouldHideItem($file, $hiddenItems);
    });

    // Sort directories and files separately based on the order in the filesystem
    natsort($directories);
    natsort($files);
?>