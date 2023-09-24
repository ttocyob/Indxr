// Function to map MIME types to Foundation Icons
function getMIMEIcon(mimeType) {
    var mimeToIcon = {
        'image/jpeg': 'photo',
        'image/png': 'photo',
        'image/gif': 'photo',
        'image/webp': 'photo',
        'image/svg+xml': 'photo', // Added support for .svg image files
        'video/webm': 'video',
        'video/mp4': 'video',
        'video/ogg': 'video',
        'video/x-matroska': 'video', // Added support for .mkv video files
        'video/ogv': 'video', // Added support for .ogv video files
        'video/avi': 'video', // Added support for .avi video files
        'video/quicktime': 'video', // Added support for .mov video files
        'audio/mpeg': 'music',
        'audio/ogg': 'music',
        'audio/wav': 'music',
        'audio/flac': 'music', // Added support for .flac audio files
        'audio/opus': 'music', // Added support for .opus audio files
        'application/pdf': 'page-pdf',
        'text/plain': 'page',
        'font/ttf': 'page', // Added support for .ttf font files
        'application/x-gzip': 'archive', // Added support for .tar.gz and .tgz files
        'application/x-tar': 'archive', // Added support for .tar files
        'application/zip': 'archive', // Added support for .zip files
    };

    if (mimeToIcon.hasOwnProperty(mimeType)) {
        return '<i class="fi-' + mimeToIcon[mimeType] + '"></i>';
    } else {
        return '';
    }
}

// Function to open the overlay with an image, audio, video, or text
function openOverlay(fileURL, fileType) {
    // Hide all overlay containers initially
    $('#fullscreen-overlay-image-container').hide();
    $('#fullscreen-overlay-audio').hide();
    $('#fullscreen-overlay-video').hide();
    $('#fullscreen-overlay-text').hide();

    // Get the video element
    var videoElement = $('#fullscreen-overlay-video video')[0];
    
    if (fileType === 'image') {
        $('#fullscreen-overlay-image').attr('src', fileURL);
        $('#fullscreen-overlay-image-container').show();
        $('#fullscreen-overlay-download').attr('href', fileURL);
    } else if (fileType === 'audio') {
        $('#fullscreen-overlay-audio audio source').attr('src', fileURL);
        $('#fullscreen-overlay-audio audio')[0].load();
        $('#fullscreen-overlay-audio').show();
        $('#fullscreen-overlay-download').attr('href', fileURL);
    } else if (fileType === 'video') {
        videoElement.controls = true; // Show native controls

        // Add a random query parameter to the video URL to bypass caching
        var randomParam = Math.random();
        var updatedURL = fileURL + '?cache=' + randomParam;

        $('#fullscreen-overlay-video video source').attr('src', updatedURL);
        videoElement.load(); // Reload the video
        $('#fullscreen-overlay-video').show();
        $('#fullscreen-overlay-download').attr('href', updatedURL);
    } else if (fileType === 'text') {
        $('#fullscreen-overlay-text').load(fileURL, function () {
            $('#fullscreen-overlay-text').show();
        });
        $('#fullscreen-overlay-download').attr('href', fileURL);
    }

    $('#fullscreen-overlay').css('display', 'block');
    $('body').css('overflow', 'hidden');
    console.log('Fullscreen overlay launched for', fileType);
}

// Function to close the overlay
function closeOverlay(fileType) {
    $('#fullscreen-overlay').css('display', 'none');
    $('body').css('overflow', 'auto');

    if (fileType === 'audio') {
        // Check if the audio player is visible before pausing and hiding
        if ($('#fullscreen-overlay-audio').is(':visible')) {
            $('#fullscreen-overlay-audio audio')[0].pause();
            $('#fullscreen-overlay-audio audio')[0].currentTime = 0;
            $('#fullscreen-overlay-audio').hide();
        }
    } else if (fileType === 'image') {
        $('#fullscreen-overlay-image-container').hide();
    } else if (fileType === 'video') {
        // Check if the video player is visible before pausing and hiding
        if ($('#fullscreen-overlay-video').is(':visible')) {
            $('#fullscreen-overlay-video video')[0].pause();
            $('#fullscreen-overlay-video video')[0].currentTime = 0;
            $('#fullscreen-overlay-video').hide();
        }
    } else if (fileType === 'text') {
        // Check if the text container is visible before hiding
        if ($('#fullscreen-overlay-text').is(':visible')) {
            $('#fullscreen-overlay-text').hide();
        }
    }

    console.log('Fullscreen overlay closed for', fileType);
}

// Function to Download 
$('#fullscreen-overlay-download').on('click', function () {
    // Get the source URL of the image being displayed
    var imageURL = $('#fullscreen-overlay-image').attr('src');

    // Create an anchor element to trigger the download
    var downloadLink = document.createElement('a');
    downloadLink.href = imageURL;
    document.body.appendChild(downloadLink);

    // Trigger the click event on the anchor element
    downloadLink.click();

    // Clean up the anchor element
    document.body.removeChild(downloadLink);

    // Prevent the default link behavior
    return false;
});

$(document).ready(function() {
    // Bind click event to open overlay for images, audio, text, or video
    $('table').on('click', 'a[data-fullscreen-overlay]', function () {
        var fileURL = $(this).attr('href');
        var fileType = $(this).data('fullscreen-overlay');

        if (fileType === 'image' || fileType === 'text' || fileType === 'audio' || fileType === 'video') {
            openOverlay(fileURL, fileType);
            console.log('Opening fileType:', fileType);

            // Load text content when fileType is 'text'
            if (fileType === 'text') {
                $('#fullscreen-overlay-text').load(fileURL, function (responseText, textStatus, jqXHR) {
                    if (textStatus === 'success') {
                        console.log('Text content loaded successfully:', responseText);
                        $('#fullscreen-overlay-text').show();
                    } else {
                        console.log('Failed to load text content:', textStatus);
                    }
                });
            }
        } else {
            console.log('Unsupported file type:', fileType);
            // Prevent the default behavior (fullscreen overlay)
            return false;
        }

        return false;
    });

    // Bind click event to close overlay when the "Esc" key is pressed
    $(document).on('keyup', function (event) {
        if (event.key === 'Escape') {
            var fileType = $('#fullscreen-overlay-audio').is(':visible') ? 'audio' : $('#fullscreen-overlay-video').is(':visible') ? 'video' : 'image';
            closeOverlay(fileType);
        }
    });

    // Bind click event to prevent accidental closing when clicking the download button
    $('#fullscreen-overlay-download').on('click', function (e) {
        e.stopPropagation();
    });

    // Bind click event to prevent accidental closing when clicking on the video player
    $('#fullscreen-overlay-video video').on('click', function (e) {
        e.stopPropagation();
    });

    // Bind click event to prevent accidental closing when clicking on the audio player
    $('#fullscreen-overlay-audio audio').on('click', function (e) {
        e.stopPropagation();
    });

    // Bind click event to prevent accidental closing when clicking on the text
    $('#fullscreen-overlay-text').on('click', function (e) {
        e.stopPropagation();
    });

    // Bind click event to close the overlay when clicking anywhere in the overlay
    $('#fullscreen-overlay').on('click', function () {
        var fileType = $('#fullscreen-overlay-audio').is(':visible') ? 'audio' : $('#fullscreen-overlay-video').is(':visible') ? 'video' : 'image';
        closeOverlay(fileType);
    });

    // Bind click event to close overlay by clicking the close button
    $('#fullscreen-overlay-close').on('click', function () {
        var fileType;
        if ($('#fullscreen-overlay-audio').is(':visible')) {
            fileType = 'audio';
        
            // Pause and reset the audio playback
            $('#fullscreen-overlay-audio audio')[0].pause();
            $('#fullscreen-overlay-audio audio')[0].currentTime = 0;
        } else if ($('#fullscreen-overlay-video').is(':visible')) {
            fileType = 'video';
        
            // Pause and reset the video playback
            $('#fullscreen-overlay-video video')[0].pause();
            $('#fullscreen-overlay-video video')[0].currentTime = 0;
        } else if ($('#fullscreen-overlay-text').is(':visible')) {
            fileType = 'text'; // Set fileType to 'text' for text overlays
        } else {
            fileType = 'image';
        }
        closeOverlay(fileType);
    });
});
