Indxr 0.3.2

Indxr is a modular directory indexer. It includes various PHP modules for handling different aspects of the directory listing, such as breadcrumbs, functions, directory and file filtering, and displaying summary information.

Here's a breakdown :

Breadcrumbs Module:
Responsible for generating a hierarchical breadcrumb trail to navigate through directories.
Constructs breadcrumb links with icons for each directory component in the current path.
Handles cases where the "indxr_breadcrumbs.php" file is missing.

Functions Module:
Contains functions and code used throughout the directory indexer.
Defines a configuration array for specifying filtering rules (hidden file extensions, directory names, etc.).
Provides functions for retrieving descriptions for directories and files.
Reads directory and file descriptions from external files.
Filters hidden items based on the rules defined in the configuration array.

Directory and File Filtering Module:
Handles directory and file filtering and processing.
Separates items into directories and files.
Filters hidden items based on rules defined in the configuration.
Sorts directories and files naturally.
Randomizes file order for large directories.
Generates an HTML table to display directory and file information.

Summary Module:
Generates a summary of visible directories and files within a directory.
Calculates and displays information such as the number of visible objects, directories, and total file size.
Handles cases where the "indxr_summary.php" file is missing.

JavaScript for Full-Screen Overlay:
Provides functionality for a full-screen overlay to display and interact with various types of content (images, audio, video, text).
Includes a function to map MIME types to Foundation Icons.
Functions to open and close the full-screen overlay based on the content type.
Handles media controls (e.g., play/pause) for audio and video content.
Manages the download functionality for files.
Binds click and keyup events for interactions with the overlay, such as opening and closing it.

Indxr allows you to create directory listings with features like breadcrumbs, filtering, descriptions, and a full-screen overlay for viewing various content types. It's designed to make directory navigation and file access user-friendly.

Licensed under the GNU GPL v3