    <?php
    // Function to check if an item is hidden based on the $hiddenItems configuration
    function isHiddenItem($item, $hiddenItems)
    {
        foreach ($hiddenItems as $pattern) {
            if (fnmatch($pattern, $item)) {
                return true;
            }
        }
        return false;
    }

    // Count the number of visible directories and files
    $visibleDirectories = array_filter($directories, function ($dir) use (
        $hiddenItems
    ) {
        return !isHiddenItem($dir, $hiddenItems);
    });

    $visibleFiles = array_filter($files, function ($file) use ($hiddenItems) {
        return !isHiddenItem($file, $hiddenItems);
    });

    // Skip the . and .. directories
    $visibleDirectories = array_diff($visibleDirectories, [".", ".."]);

    $numberOfVisibleDirectories = count($visibleDirectories);
    $numberOfVisibleFiles = count($visibleFiles);
    $totalVisibleObjects = $numberOfVisibleDirectories + $numberOfVisibleFiles;

    if ($totalVisibleObjects === 0) {
        echo '<span class="indxr-summary-text">0 objects found</span>';
    } else {
        echo '<span class="indxr-summary-text">' .
            $totalVisibleObjects .
            " " .
            ($totalVisibleObjects === 1 ? "object" : "objects") .
            " found";

        if ($numberOfVisibleDirectories > 0) {
            echo ", " .
                $numberOfVisibleDirectories .
                " director" .
                ($numberOfVisibleDirectories === 1 ? "y" : "ies");
        }

        // Display number of files and total size only if there are visible files
        if (!empty($visibleFiles)) {
            $totalSizeInKB =
                array_sum(array_map("filesize", $visibleFiles)) / 1024;

            if ($totalSizeInKB > 100) {
                $totalSizeInMB = $totalSizeInKB / 1024;
                echo ", " .
                    $numberOfVisibleFiles .
                    " file" .
                    ($numberOfVisibleFiles === 1 ? "" : "s") .
                    ", " .
                    round($totalSizeInMB, 2) .
                    " MB total";
            } else {
                echo ", " .
                    $numberOfVisibleFiles .
                    " file" .
                    ($numberOfVisibleFiles === 1 ? "" : "s") .
                    ", " .
                    round($totalSizeInKB, 2) .
                    " KB total";
            }
        }

        // Display the version string & misc info
        $indxrversion = "v. 0.3.2"; // Update this version string as needed
        $indxrdesigned = "Designed for navigation and content organization";
        echo "</span>";
    }

?>
