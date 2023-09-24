				<div class="module_container">
					<div id="Indxr_br-top">
						<div id="Indxr_main">
							<div id="Indxr_header">
			      				<span class="window_id"><a href="http://cored.org/" id="indxr" title="Indxr"><i class="fi-folder"></i> Indxr</a></span>
							</div>
			        		<div id="Indxr_Directory">
								<?php
									$file_path = "/home/coreaqko/public_html/indxr.php";

									if (file_exists($file_path)) {
    									include($file_path);
    									// echo '<p class="success-message"><small><i class="fi-check"></i> Indxr executed</small></p>';
									} else {
    									echo '<p class="error-message"><small><i class="fi-alert"></i> Warning: indxr not loaded</small></p>';
									}
								?>
			        		</div>
						</div>
					</div>
					<div id="Indxr_footer">
			        	<span class="window_footer"><strong>Indxr</strong></span>
						<span class="window_footer_design text_small"> Indxr <?php echo '' . $indxrversion; ?> - <?php echo '' . $indxrdesigned; ?></span>
			  		</div>
				</div>