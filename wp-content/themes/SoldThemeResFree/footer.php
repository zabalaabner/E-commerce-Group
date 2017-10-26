		<footer id="foot">
			<div class="main-foot">
				<div class="container">
					<div class="foot-col">
						<?php dynamic_sidebar('footer-1'); ?>
					</div>
					<div class="foot-col">
						<?php dynamic_sidebar('footer-2'); ?>
					</div>
					<div class="foot-col">
						<?php dynamic_sidebar('footer-3'); ?>
					</div>
					<div class="foot-col">
						<?php dynamic_sidebar('footer-4'); ?>
					</div>
					
				</div>
			</div>
			<div class="bottom-foot">
				<div class="container">
					<div class="foot-socials">
					<ul>
						<?php
							$socials = array('twitter','facebook','google-plus','instagram','pinterest','vimeo','youtube','linkedin');
							for($i=0;$i<count($socials);$i++){
								$url = '';
								$s = $socials[$i];
								$url = dess_setting('dess_'.$s);
								echo ($url != '' ? '<li><a target="_blank" href="'.$url.'"><img src="'.esc_url( get_stylesheet_directory_uri() ).'/images/'.$s.'-icon.png" alt="'.$s.'" /></a></li>':'');
							}
						?>
					</ul>
				</div>
					<p > © 2016 All Rights Reserved. Developed by <a href="https://dessign.net">Dessign</a> </p>
					
					
				</div>
			</div>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>