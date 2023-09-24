<?php
    // Create an array to store breadcrumb links and titles
    $breadcrumb = array();
    $currentDir = getcwd();
    $scriptDir = dirname(__FILE__);
    $relativePath = '/' . ltrim(substr($currentDir, strlen($scriptDir)), '/');
    $dirComponents = explode('/', $relativePath);
    $link = '/';

    // Loop through each directory component and build the breadcrumb
    foreach ($dirComponents as $component) {
        if ($component !== "") {
            $link .= $component . '/';
            $breadcrumb[] = array(
            'link' => $link,
            'title' => htmlspecialchars($component)
            );
        }
    }

    // Make the "Home" link always point to the root of the domain
    $baseUrl = "http://cored.org/";

    // Filter out empty components before building the trail
    $breadcrumb = array_filter($breadcrumb, function ($component) {
        return !empty(trim($component['title']));
    });

    // Construct the hierarchical breadcrumb trail for the Home link
    echo '<strong>Navigate:</strong>&nbsp;<a href="' . htmlspecialchars($baseUrl) . '">&nbsp;<i class="fi-home"></i>&nbsp; Home</a>';

    // Construct the hierarchical breadcrumb trail
    // echo 'Navigate:&nbsp;<a href="' . htmlspecialchars($baseUrl) . '">Home</a>';
            
    // Iterate through directory components and display them with icons
    $breadcrumbCount = count($breadcrumb);
    foreach ($breadcrumb as $index => $component) {
        echo '<span class="separator">&nbsp;&raquo;&nbsp;</span>';
    
        // Check if this is the last breadcrumb item
        if ($index === $breadcrumbCount - 1) {
            echo '<a href="' . htmlspecialchars($component['link']) . '">&nbsp;<i class="fi-folder"></i>&nbsp;&nbsp;<strong>' . $component['title'] . '</strong></a>';
        } else {
            echo '<a href="' . htmlspecialchars($component['link']) . '">&nbsp;<i class="fi-folder"></i>&nbsp;&nbsp;' . $component['title'] . '</a>';
        }
    }
?>