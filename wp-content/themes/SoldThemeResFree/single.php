<?php
get_header();
?>
<div class="content">
	<div class="container">
		<div class="post_content">
			<?php while ( have_posts() ) : the_post(); ?>
			<article class="single-box" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
					<?php
					wp_link_pages(array(
						'before' => '<div class="link_pages">'.__('Pages', 'wpshop'),
						'after' => '</div>',
						'link_before' => '<span>',
						'link_after' => '</span>'
					)); 
				?>
				<?php the_tags( '<div class="post_tags">Tags: ', ', ', '</div>' ); ?> 
			</article>
			<div class="clear"></div>
			<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
						<div class="home_blog_box">
							<div class="comments_cont">
							<?php
								// If comments are open or we have at least one comment, load up the comment template
								comments_template( '', true );
							?>
							</div>
						</div>
			<?php endif;
			endwhile;
			?>
		</div>
	</div>
	</div>
<?php
get_footer();
?>