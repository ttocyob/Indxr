Indxr 0.3.2

Indxr is a modular directory indexer system. It includes various PHP modules for handling different aspects of the directory listing, such as breadcrumbs, functions, directory and file filtering, and displaying summary information.

Here's a breakdown :

Breadcrumbs Module: This part includes a module for handling breadcrumbs. It checks if the "indxr_breadcrumbs.php" file exists and includes it. If the file doesn't exist, it displays an error message.

It is responsible for generating a hierarchical breadcrumb trail to navigate through directories. It constructs breadcrumb links with icons for each directory component in the current path. Here's a summary of its functionality:

Breadcrumb Initialization: The code initializes an empty array called $breadcrumb to store breadcrumb links and titles. It also retrieves the current directory path, script directory path, and calculates the relative path between them.

Building Breadcrumb Links: It loops through each directory component in the relative path and constructs breadcrumb links. For each component, it appends the component to the link, escapes any special characters in the title, and adds this as an array element in the $breadcrumb array.

Home Link: It creates a "Home" link that points to the root of the domain, represented by the $baseUrl variable.

Filtering Empty Components: It filters out any empty components from the $breadcrumb array to ensure that empty or invalid directory names are not included in the breadcrumb trail.

Displaying Breadcrumbs: The code iterates through the $breadcrumb array and displays each breadcrumb component. It uses an HTML separator (typically ">>") between components. The last component is displayed as a strong text to indicate the current directory.

Icons: The code includes icons (represented by the <i> element with the class "fi-folder") next to each breadcrumb component, giving a visual indication of directories.

Functions Module: This section includes the "indxr_functions.php" file if it exists. This file contains functions and code that are used elsewhere in the directory indexer. It also displays an error message if the file is not found. It provides the following functions:

Configuration Array for Filtering: The script begins by defining a configuration array $filterConfig. This array is used to specify filtering rules, such as hidden file extensions, hidden directory names, and hidden extensions with wildcards.

Functions for Getting Descriptions: The script defines functions getDirDescription($dirName) and getFileDescription($fileName) to retrieve descriptions for directories and files, respectively. These functions access global arrays of descriptions that are read from external files.

Functions for Reading Descriptions: The script contains functions readDirDescriptions($filePath) and readFileDescriptions($filePath) to read directory and file descriptions from external files. These functions populate global arrays ($dirDescriptions and $fileDescriptions) with the descriptions if the files exist.

Hidden Items: The script defines an array $hiddenItems that lists items (files, directories, or wildcards) that should be hidden from the directory listing. The shouldHideItem($itemName, $hiddenItems) function checks whether an item should be hidden based on the patterns in the $hiddenItems array.

Usage Examples: The script includes usage examples for reading directory and file descriptions using the readDirDescriptions and readFileDescriptions functions. It also includes a function getMIMEIcon($filename) that maps MIME types to Foundation Icons for various file types.


Directory and File Filtering Module: Similar to the previous sections, this part includes the "indxr_dir_fil_filter.php" file if it exists. This file is responsible for filtering and processing directories and files. It displays an error message if the file is not found.

Breakdown of its functions:

Directory Specification: The code first defines the directory to be indexed based on the "dir" query parameter received via the GET request. If the "dir" parameter is provided, it appends the specified directory to the base path; otherwise, it uses the base path.

Listing All Items: It uses the scandir function to retrieve a list of all items (both files and directories) within the specified directory and stores them in the $allItems array.

Separation of Directories and Files: The script then separates the items into two arrays: $directories for directories and $files for files. It uses a loop to iterate through the items and checks whether each item is a directory or a file. Directories are added to the $directories array, and files are added to the $files array.

Filtering Hidden Items: For both directories and files, it checks if they should be hidden based on the defined filtering rules in $filterConfig. Directories or files matching the criteria are excluded from the respective arrays.

Additional Filtering with shouldHideItem: The script uses the shouldHideItem function to perform additional filtering based on the rules defined in the $hiddenItems array. Items that should be hidden are removed from the filtered directories and files arrays.

Sorting: The script sorts both the filtered directories and files separately using the natsort function. This function sorts items naturally, considering numbers within filenames.

Randomization for Large Directories: The code checks if a directory contains more than a certain number of files (the threshold is typically set to 24 in this code). If the directory exceeds this threshold, the script shuffles the list of files, ensuring that they appear in a random order. This randomization is done to prevent a consistent file order in cases of large directories.

Main HTML Table: This section generates an HTML table to display directory and file information. It loops through directories and files and generates table rows with links to directories and files. It also includes logic for truncating long directory and file names and calculating file sizes. Additionally, it checks for the existence of external files "indxr_dir_desc.php" and "indxr_file_desc.php" to display directory and file descriptions, respectively. If these files don't exist, it displays error messages.

Summary Module: This part includes a summary module by checking if the "indxr_summary.php" file exists and including it. This file contains summary information about the directory listing. It displays an error message if the file is not found.

It is responsible for generating a summary of visible directories and files within a directory. It calculates and displays information such as the number of visible objects (directories and files), the number of directories, and the total size of visible files. Here's a summary of its functionality:

Function to Check Hidden Items: The code defines a function isHiddenItem($item, $hiddenItems) that checks whether an item (directory or file) should be hidden based on the patterns defined in the $hiddenItems array.

Counting Visible Directories and Files: The code uses array_filter to create arrays of visible directories and files by filtering out hidden items based on the isHiddenItem function.

Skipping "." and ".." Directories: The script removes the special directory entries "." and ".." from the list of visible directories.

Counting and Displaying Summary Information: It calculates the number of visible directories, visible files, and the total size of visible files (if any). It then displays this information along with a version string and miscellaneous information about the script.

Displaying Summary: The summary information is displayed in HTML format using echo. It includes the total number of objects found, the number of directories, the number of files, and the total size of files. It also includes version information and other descriptive text.

JavaScript: Indxr has code to manage a full-screen overlay for displaying and interacting with various types of content, including images, audio, video, and text. Here's a summary of its functionality:

getMIMEIcon Function: This function maps MIME types to Foundation Icons. It takes a MIME type as input and returns an HTML string with an icon element corresponding to the MIME type.

openOverlay Function: This function is used to open the full-screen overlay with content. It accepts two parameters: fileURL (the URL of the content to display) and fileType (the type of content). The function determines the type of content and displays it within the overlay. It also handles media controls (e.g., play/pause) for audio and video content.

closeOverlay Function: This function is used to close the full-screen overlay. It accepts the fileType as a parameter and hides the appropriate content container based on the content type (audio, video, image, or text).

Download Function: This code snippet handles the download functionality. When the download button is clicked, it creates an anchor element with the file's URL and triggers a click event to initiate the download.

Document Ready Function: This code block executes when the document is ready. It binds click events and keyup events for various interactions with the overlay:

Clicking links with data-fullscreen-overlay attribute opens the overlay for different content types (image, audio, text, or video).

Pressing the "Escape" key closes the overlay.

Prevents accidental closing when clicking on the download button, video player, or audio player.
Clicking anywhere in the overlay or the close button closes the overlay.