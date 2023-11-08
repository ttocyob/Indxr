<div class="Indxr-component_bg">
    <div class="breadcrumb-container">
        <div class="breadcrumb">
            <?php
            // Use require() instead of include() for the Breadcrumbs module
            $indxr_breadcrumbs_path = "indxr_breadcrumbs.php";

            require($indxr_breadcrumbs_path); // Ensure the module is required
            ?>
        </div>
    </div>

    <?php
        // Use require() instead of include() for the Functions module
        $indxr_functions_path = "indxr_functions.php";

        require($indxr_functions_path); // Ensure the module is required
    ?>

    <?php
        // Use require() instead of include() for the Directory and File Indexing and Filters module
        $dir_fil_filter_path = "indxr_dir_fil_filter.php";

        require($dir_fil_filter_path); // Ensure the module is required
    ?>

    <!-- Main HTML table -->
    <table class="indxr">
        <tr>
            <th></th> <!-- Add column for icons -->
            <th>Name</th> <!-- Add column for names -->
            <th><center>Last Modified</center></th>
            <th><center>Size</center></th>
        </tr>

        <?php
        // Function to display a description for a directory if available
        function displayDirectoryDescription($dirDescriptions, $dirItem) {
            if (isset($dirDescriptions[$dirItem])) {
                echo '<tr><td></td><td colspan="3" class="dir_description"><small>' . $dirDescriptions[$dirItem] . '</small></td></tr>';
            }
        }

        // Function to display a description for a file if available
        function displayFileDescription($fileDescriptions, $fileItem) {
            if (isset($fileDescriptions[$fileItem])) {
                echo '<tr><td></td><td colspan="3" class="file_description"><small>' . $fileDescriptions[$fileItem] . '</small></td></tr>';
            }
        }

        // Loop through both directories and files in a single loop
        foreach ($filteredDirectories as $dirItem) {
            // Skip the . and .. directories
            if ($dirItem === '.' || $dirItem === '..') {
                continue;
            }

            $dirPath = $directory . $dirItem;
        ?>

        <tr>
            <td class="icon-cell">
                <!-- Add an icon for directories and make it clickable to open the directory -->
                <a href="<?= $dirPath ?>"><i class="fi-folder"></i></a>
            </td>
            <td class="name-cell">
                <!-- Truncate long directory names (adjust the maximum length as needed) -->
                <?php
                $displayDirName = strlen($dirItem) > 30 ? substr($dirItem, 0, 26) . '...' : $dirItem;
                ?>
                <!-- Link to open the directory -->
                <a href="<?= $dirPath ?>"><?= $displayDirName ?></a>
            </td>
            <td class="modified-cell"><center>-</center></td> <!-- Placeholder for Last Modified -->
            <td class="size-cell"><center>-</center</td> <!-- Placeholder for size -->
        </tr>

        <?php
        // Use a ternary operator to check if the directory descriptions file exists
        $dirDescriptionsPath = 'indxr_dir_desc.php';
        $dirDescriptions = (file_exists($dirDescriptionsPath)) ? include $dirDescriptionsPath : array();

        // Display directory description if available
        displayDirectoryDescription($dirDescriptions, $dirItem);
        }

        // Function to calculate file size and format it
        function formatFileSize($filePath) {
            $fileSizeInBytes = filesize($filePath);
            $fileSizeInKB = $fileSizeInBytes / 1024; // Calculate file size in KB

            if ($fileSizeInKB > 100) {
                $fileSizeInMB = round($fileSizeInKB / 1024, 2);
                return $fileSizeInMB . ' MB';
            } else {
                return round($fileSizeInKB, 2) . ' KB';
            }
        }

        // Check if there are more than 16 files in the directory
        if (count($filteredFiles) > 16) {
            // Shuffle the list of files
            shuffle($filteredFiles);
        }
        // For each regular file...
        foreach ($filteredFiles as $fileItem) {
            $filePath = $directory . $fileItem; // Define the file path here
            $fileSizeText = formatFileSize($filePath); // Use the function to calculate file size

        ?>

        <tr>
            <td class="icon-cell">
                <!-- Add an icon for files based on MIME type and make it clickable to open the file -->
                <?php
                $extension = pathinfo($fileItem, PATHINFO_EXTENSION); // Get the file extension

                if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'bmp', 'ico'])) {
                    // Image file - set the attribute to "image"
                    echo '<a href="' . $filePath . '" data-fullscreen-overlay="image">';
                } elseif (in_array(strtolower($extension), ['mpeg', 'mp3', 'ogg', 'wav'])) {
                    // Audio file - set the attribute to "audio"
                    echo '<a href="' . $filePath . '" data-fullscreen-overlay="audio">';
                } elseif (in_array(strtolower($extension), ['webm', 'mp4', 'ogg'])) {
                    // Video file - set the attribute to "video"
                    echo '<a href="' . $filePath . '" data-fullscreen-overlay="video">';
                } elseif (in_array(strtolower($extension), ['txt', 'log'])) {
                    // Text file - set the attribute to "text"
                    echo '<a href="' . $filePath . '" data-fullscreen-overlay="text">';
                } else {
                    // File types that should not open in fullscreen overlay
                    echo '<a href="' . $filePath . '" target="_self">'; // Open in the browser
                }
                ?>
                <?= getMIMEIcon($fileItem) ?>
            </td>
            <td class="name-cell">
                <?php
                // Truncate long file names (adjust the maximum length as needed)
                $extension = pathinfo($fileItem, PATHINFO_EXTENSION); // Get the file extension
                $displayFileName = strlen($fileItem) > 30 ? substr($fileItem, 0, 26) . '...' . $extension : $fileItem;
                ?>
                <!-- Open the file in fullscreen overlay if supported -->
                <?php
                if (in_array($extension, ['png', 'jpeg', 'jpg', 'webp', 'gif', 'svg', 'bmp', 'ico'])) {
                    echo '<a href="' . $filePath . '" data-fullscreen-overlay="image">';
                } elseif (in_array($extension, ['mpeg', 'mp3', 'ogg', 'wav'])) {
                    echo '<a href="' . $filePath . '" data-fullscreen-overlay="audio">';
                } elseif (in_array($extension, ['webm', 'mp4', 'ogg'])) {
                    echo '<a href="' . $filePath . '" data-fullscreen-overlay="video">';
                } elseif (in_array($extension, ['txt'])) {
                    echo '<a href="' . $filePath . '" data-fullscreen-overlay="text">';
                } else {
                    // File types that should not open in fullscreen overlay
                    echo '<a href="' . $filePath . '" target="_self">'; // Open in the browser
                }
                ?>
                <?= $displayFileName ?>
                </a>
            </td>
            <td class="modified-cell"><center><?= date("d-m-y H:i", filemtime($filePath)) ?></center></td>
            <td class="size-cell"><center><?= $fileSizeText ?></center></td>
        </tr>

        <?php
        // Use a ternary operator to check if the file descriptions file exists
        $fileDescriptionsPath = 'indxr_file_desc.php';
        $fileDescriptions = (file_exists($fileDescriptionsPath)) ? include $fileDescriptionsPath : array();

        // Display file description if available
        displayFileDescription($fileDescriptions, $fileItem);
        }
        ?>
    </table>
</div>

<div id="indxr-summary">
    <?php
    // Use require() instead of include() for the Summary module
    $file_path = "indxr_summary.php";
    require($file_path); // Ensure the module is required
    ?>
</div>
