<?php get_header(); ?>
			
	<div id="main" role="main">
		
		<?php while (have_posts()) : the_post(); ?>
						
			<?php the_breadcrumb(); ?>
			
		<article class="clear">
			<h1 id="page-title" class="entry-title">
				Alert: <?php the_title(); ?>
			</h1>
			
			<?php
			$dates = tcp_get_alert_dates();
			$affected = tcp_get_affected( get_the_ID(), ' ');
			?>
			
			<div class="entry-meta">
				
				<?php echo $dates; ?>
				
			</div>
			
			<?php if (!empty($affected) ) : ?>
				
				<div class="affected_routes">
				
					Affected routes: <?php echo $affected; ?>
				
				</div>
				
			<?php endif; ?>
			
			<section class="entry-content cf" itemprop="articleBody">
				
				<?php if( has_post_thumbnail()) : ?>
					<div id="featured-image-container">
						<img class="featured-image" src="
							<?php
									
							$thumb_id = get_post_thumbnail_id();
							$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
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
	
	<?php
	the_post_navigation( array(
		'prev_text'		=> __('&laquo; previous: %title'),
		'next_text'		=> __("next: %title &raquo;"),
	));
	?>

	</div> <!-- end #main -->
	
	<?php get_template_part('page-footer'); ?>

<?php get_footer(); ?>
