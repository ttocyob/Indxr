<?php flush(); ?>
<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Indxr</title>
		<meta name="Description" content="Directory and Files Indexer">
		<link rel="icon" type="image/svg+xml" href="/favicon.svg">
		<link rel="icon" type="image/png" href="/favicon.png">
		<!-- stylesheets -->
		<link rel="stylesheet" href="/css/foundation-icons.css">
		<link rel="stylesheet" href="/css/default.css">
		<!-- <base href=""> -->
		<script src="/js/jquery.js"></script>
		<script src="/js/indxr_foverlay.js"></script>
	</head>
	<body id="Top">
		<div id="container" class="">
			<main class="" id="left_column">
				<?php
					$file_path = "indxr_module.php";

					if (file_exists($file_path)) {
    					include($file_path);
    					// echo '<p class="success-message"><small><i class="fi-check"></i> Indxr module executed</small></p>';
					} else {
    					echo '<p class="error-message"><small><i class="fi-alert"></i> Warning: indxr module not loaded</small></p>';
					}
				?>
			</main>
			<?php
				$file_path = "indxr_fmodule.php";

				if (file_exists($file_path)) {
    				include($file_path);
    				// echo '<p class="success-message"><small><i class="fi-check"></i> Overlay module executed</small></p>';
				} else {
        			echo '<p class="error-message"><small><i class="fi-alert"></i> Warning: overlay module not loaded</small></p>';
				}
			?>
		</div><!-- close container -->
	</body>
</html>