<div class="Indxr-component_bg">
    <div class="breadcrumb-container">
        <div class="breadcrumb">
            <?php
            // Breadcrumbs module
            $file_path = "/home/coreaqko/public_html/indxr_breadcrumbs.php";

            if (file_exists($file_path)) {
                include($file_path);
                // echo '<p class="success-message"><small><i class="fi-check"></i> Breadcrumbs module executed</small></p>';
            } else {
                echo '<p class="error-message"><small><i class="fi-alert"></i> Warning: breadcrumbs module not loaded</small></p>';
            }
            ?>
        </div>
    </div>
    <?php
        // Include Indxr functions
        $indxr_functions_path = "/home/coreaqko/public_html/indxr_functions.php";

        if (file_exists($indxr_functions_path)) {
            include($indxr_functions_path);
            // echo '<p class="success-message"><small><i class="fi-check"></i> Functions module executed</small></p>';
        } else {
            echo '<p class="error-message"><small><i class="fi-alert"></i> Warning: functions module not loaded</small></p>';
        }

        // Include Directory and File Indexing and Filters
        $dir_fil_filter_path = "/home/coreaqko/public_html/indxr_dir_fil_filter.php";

        if (file_exists($dir_fil_filter_path)) {
            include($dir_fil_filter_path);
            // echo '<p class="success-message"><small><i class="fi-check"></i> Directory and file filtering module executed</small></p>';
        } else {
            echo '<p class="error-message"><small><i class="fi-alert"></i> Warning: Directory and file filtering module not loaded</small></p>';
        }
    ?>
    <!-- Main HTML table -->
    <table>
        <tr>
            <th></th> <!-- Add column for icons -->
            <th>Name</th> <!-- Add column for names -->
            <th><center>Last Modified</center></th>
            <th><center>Size</center></th>
        </tr>

        <?php
            // Loop through both directories and files in a single loop
            foreach ($filteredDirectories as $dirItem) {
                // Skip the . and .. directories
                if ($dirItem === '.' || $dirItem === '..') {
                    continue;
                }

            $dirPath = $directory . $dirItem;
        ?>

        <tr>
            <td>
            <!-- Add an icon for directories and make it clickable to open the directory -->
            <a href="<?= $dirPath ?>"><i class="fi-folder"></i></a>
        </td>
            <td>
                <!-- Truncate long directory names (adjust the maximum length as needed) -->
                <?php
                $displayDirName = strlen($dirItem) > 20 ? substr($dirItem, 0, 17) . '...' : $dirItem;
                ?>

                <!-- Link to open the directory -->
                <a href="<?= $dirPath ?>"><?= $displayDirName ?></a>
            </td>
            <td><center>-</center></td> <!-- Placeholder for Last Modified -->
            <td><center>-</center</td> <!-- Placeholder for size -->
        </tr>

        <?php
            // Read directory descriptions from the external "indxr_dir_desc.php" file
            // Define the file path for directory descriptions
            $dirDescriptionsPath = '/home/coreaqko/public_html/indxr_dir_desc.php';

            if (file_exists($dirDescriptionsPath)) {
                $dirDescriptions = include $dirDescriptionsPath;
            } else {
                // Handle the case where the file does not exist
                echo '<p class="error-message"><small><i class="fi-alert"></i> Warning: Directory descriptions file not found</small></p>';
                $dirDescriptions = array(); // Initialize an empty array or handle it as needed
            }

            // Display directory description if available
            $dirDescription = isset($dirDescriptions[$dirItem]) ? $dirDescriptions[$dirItem] : '';
            if ($dirDescription) {
                echo '<tr><td></td><td colspan="3" class="dir_description"><small>' . $dirDescription . '</small></td></tr>';
            }
        }

        // Check if there are more than 24 files in the directory
        if (count($filteredFiles) > 24) {
            // Shuffle the list of files
            shuffle($filteredFiles);
        }
        // For each regular file...
        foreach ($filteredFiles as $fileItem) {
            $filePath = $directory . $fileItem; // Define the file path here
            $fileSizeInKB = filesize($filePath) / 1024; // Calculate file size in KB

            // Calculate file size and format it
            if ($fileSizeInKB > 100) {
                $fileSizeInMB = round($fileSizeInKB / 1024, 2);
                $fileSizeText = $fileSizeInMB . ' MB';
            } else {
                $fileSizeText = round($fileSizeInKB, 2) . ' KB';
            }
        ?>

        <tr>
            <td>
                <!-- Add an icon for files based on MIME type and make it clickable to open the file -->
                <?php
                    $extension = pathinfo($fileItem, PATHINFO_EXTENSION); // Get the file extension

                    if (in_array($extension, ['png', 'jpeg', 'jpg', 'webp', 'gif'])) {
                    // Image file - set the attribute to "image"
                        echo '<a href="' . $filePath . '" data-fullscreen-overlay="image">';
                    } else if (in_array($extension, ['mpeg', 'mp3', 'ogg', 'wav'])) {
                    // Audio file - set the attribute to "audio"
                        echo '<a href="' . $filePath . '" data-fullscreen-overlay="audio">';
                    } else if (in_array($extension, ['webm', 'mp4', 'ogg'])) {
                    // Video file - set the attribute to "video"
                        echo '<a href="' . $filePath . '" data-fullscreen-overlay="video">';
                    } else if (in_array($extension, ['txt', 'log'])) {
                    // Text file - set the attribute to "text"
                        echo '<a href="' . $filePath . '" data-fullscreen-overlay="text">';
                    } else {
                    // File types that should not open in fullscreen overlay
                    // echo '<a href="' . $filePath . '" data-fullscreen-overlay="unsupported">';
                    echo '<a href="' . $filePath . '" target="_self">'; // Open in the browser
       
                    }
                ?>
                <?= getMIMEIcon($fileItem) ?>
            </td>
            <td>
                <?php
                    // Truncate long file names (adjust the maximum length as needed)
                    $extension = pathinfo($fileItem, PATHINFO_EXTENSION); // Get the file extension
                    $displayFileName = strlen($fileItem) > 24 ? substr($fileItem, 0, 21) . '...' . $extension : $fileItem;
                ?>

                <!-- Open the file in fullscreen overlay if supported -->
<?php
if (in_array($extension, ['png', 'jpeg', 'jpg', 'webp', 'gif'])) {
    echo '<a href="' . $filePath . '" data-fullscreen-overlay="image">';
} else if (in_array($extension, ['mpeg', 'mp3', 'ogg', 'wav'])) {
    echo '<a href="' . $filePath . '" data-fullscreen-overlay="audio">';
} else if (in_array($extension, ['webm', 'mp4', 'ogg'])) {
    echo '<a href="' . $filePath . '" data-fullscreen-overlay="video">';
} else if (in_array($extension, ['txt'])) {
    echo '<a href="' . $filePath . '" data-fullscreen-overlay="text">';
} else {
    // File types that should not open in fullscreen overlay
    echo '<a href="' . $filePath . '" target="_self">'; // Open in the browser
}
?>
                <?= $displayFileName ?>
                </a>
            </td>
                <td><center><?= date("d-m-y H:i", filemtime($filePath)) ?></center></td>
                <td class="size"><center><?= $fileSizeText ?></center></td>
            </tr>

        <?php
        // Read file descriptions from the external "indxr_file_desc.php" file
        // Define the file path for file descriptions
        $fileDescriptionsPath = '/home/coreaqko/public_html/indxr_file_desc.php';

        if (file_exists($fileDescriptionsPath)) {
            $fileDescriptions = include $fileDescriptionsPath;
        } else {
        // Handle the case where the file does not exist
            echo '<p class="error-message"><small><i class="fi-alert"></i> Warning: File descriptions file not found</small></p>';
        }

        // Display file description if available
        $fileDescription = isset($fileDescriptions[$fileItem]) ? $fileDescriptions[$fileItem] : '';
        if ($fileDescription) {
            echo '<tr><td></td><td colspan="3" class="file_description"><small>' . $fileDescription . '</small></td></tr>';
                }
            }
        ?>
    </table>
</div>

<div id="indxr-summary">
	<?php
		$file_path = "/home/coreaqko/public_html/indxr_summary.php";

		if (file_exists($file_path)) {
    		include($file_path);
    		// echo '<p class="success-message"><small><i class="fi-check"></i> Summary module executed</small></p>';
		} else {
        	echo '<p class="error-message"><small><i class="fi-alert"></i> Warning: summary module not loaded</small></p>';
		}
	?>
</div>