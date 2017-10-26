<?php
get_header();
?>
<div class="content">
	<div class="container">
		<div class="post_content">
			<div class="archive_title">
				<h2>Search Results: <?php echo get_search_query(); ?></h2>
			</div><!--//archive_title-->
			
				<?php
					$args = array_merge( $wp_query->query, array( 'posts_per_page' => 12, 'post_type' => 'post' ) );					
					$query = new WP_Query($args);

					if ( $query->have_posts() ) : ?>

					<div class="blog">
						<div class="blog-posts">
							<?php
								while ( $query->have_posts() ) : $query->the_post();
								?>
									<div class="blog-post-box <?php echo (is_sticky() ? 'sticky-post': ''); ?>">
										<div class="blog-post-feature">
										<?php
											$type = get_post_meta($post->ID,'page_featured_type',true);
									 			switch ($type) {
									 				case 'youtube':
									 					echo '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.get_post_meta( get_the_ID(), 'page_video_id', true ).'?wmode=transparent" frameborder="0" allowfullscreen></iframe>';
									 					break;
									 				case 'vimeo':
									 					echo '<iframe src="http://player.vimeo.com/video/'.get_post_meta( get_the_ID(), 'page_video_id', true ).'?title=0&amp;byline=0&amp;portrait=0&amp;color=03b3fc" width="500" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
									 					break;
									 				default:
									 					$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array(600,600) ); 
														echo '<div class="blog-post-image">
																	<a href="'.get_permalink().'" style="background-image: url('.$thumbnail[0].')"></a>
																</div>';
														break;
												}
										?>
										</div>
										<div class="blog-post-info">
											<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<div class="blog-post-excerpt">
												<?php echo dess_get_excerpt(190); ?>
											</div>
										</div>
									</div>
								<?php
									endwhile;
								?>
						</div><!-- blog-posts -->
						<div class="blog-pagination">
							<?php
								$big = 999999999; // need an unlikely integer

								echo paginate_links( array(
									'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
									'format' => '?paged=%#%',
									'current' => max( 1, get_query_var('paged') ),
									'total' => $query->max_num_pages,
									'prev_text' => '&#8592;',
									'next_text' => '&#8594;'
								) );
							?>
						</div>
					</div><!-- blog -->

		<?php
			else :
		?>

				<h2>No results found</h2>
				<p>Try to search again.</p>
				<?php get_search_form(); ?>
				
		<?php
			endif;
		?>
		
		</div>
	</div>
	</div>

<?php
get_footer();
?>