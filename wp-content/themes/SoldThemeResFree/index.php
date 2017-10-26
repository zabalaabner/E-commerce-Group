<?php
get_header();
$slider = array(
				'post_type' => array('post','product'),
				'meta_key' => 'show_in_slider',
				'meta_value' => 'yes',
				'posts_per_page' => -1,
				'ignore_sticky_posts' => true
				);
$the_query = new WP_Query( $slider );
	 if ( $the_query->have_posts() ) :
?>
<div class="home-slider">
	<div id="slider" class="sl-slider-wrapper">
		<div class="sl-slider">
			<?php while ( $the_query->have_posts() ) : $the_query->the_post();
			 		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			 		$trans = array(
			 			array('horizontal','-25','-25','2','2'),
			 			array('vertical','10','-15','1.5','1.5'),
			 			array('horizontal','3','3','2','1'),
			 			array('vertical','-25','-25','2','2'),
			 			array('horizontal','-5','10','2','1')
			 			);
			 		$random_key = array_rand($trans,2);
			 		$arr = $trans[$random_key[0]];
			 ?>
			<div class="sl-slide" data-orientation="<?php echo $arr[0]; ?>" data-slice1-rotation="<?php echo $arr[1]; ?>" data-slice2-rotation="<?php echo $arr[2]; ?>" data-slice1-scale="<?php echo $arr[3]; ?>" data-slice2-scale="<?php echo $arr[4]; ?>">
				<div class="sl-slide-inner">
					<div class="bg-img" style="background-image: url(<?php echo $thumbnail[0]; ?>); "><a href="<?php the_permalink(); ?>"></a>
						<div class="sl-desc">
							
							
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		</div><!-- /sl-slider -->
		<nav id="nav-arrows" class="nav-arrows">
			<span class="nav-arrow-prev">Previous</span>
			<span class="nav-arrow-next">Next</span>
		</nav>
	</div><!-- /slider-wrapper -->
</div><!-- home-slider -->
<?php endif; ?>

<?php
get_footer();
?>