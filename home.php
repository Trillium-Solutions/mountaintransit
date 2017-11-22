<?php get_header(); ?>
			
	<div id="main" role="main">
		
		<?php the_breadcrumb(); ?>
		
		<h1 id="page-title">News</h1>
		
		<?php while (have_posts()) : the_post(); ?>
			
		<article>
			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>">
				
					<?php the_title() ?>
					
				</a>
			</h2>
			
			<div class="entry-meta">
				
				Posted on: <?php the_time('F j, Y') ?>
				
			</div><!-- .entry-meta -->
			<section class="entry-content clear" itemprop="articleBody">
				
				<?php if( has_post_thumbnail()) : ?>
					<div id="featured-image-container">
						<img class="featured-image" src="
							<?php
									
							$thumb_id = get_post_thumbnail_id();
							$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
							echo $thumb_url_array[0];
									
							?>
						">
					</div><!-- end featured image -->
				<?php endif; ?>
									
				<?php the_content(); ?>

			</section>
			
			<?php if ( get_edit_post_link() ) : ?>
				<footer class="entry-footer">
					<?php
						edit_post_link(
							sprintf(
								/* translators: %s: Name of current post */
								esc_html__( 'Edit %s', 'marta' ),
								the_title( '<span class="screen-reader-text">"', '"</span>', false )
							),
							'<span class="edit-link">',
							'</span>'
						);
					?>
				</footer><!-- .entry-footer -->
			<?php endif; ?> 
			
		</article>

	<?php endwhile;  ?>
	
	<?php the_posts_navigation( array(
	'prev_text'	=> '&laquo; Older posts',
	'next_text'	=> 'Newer posts &raquo;',
	)); ?>

</div> <!-- end #main -->

<?php get_template_part('page-footer'); ?>

<?php get_footer(); ?>
