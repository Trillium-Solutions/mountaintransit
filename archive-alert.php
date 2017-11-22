<?php get_header(); ?>
			
	<div id="main" role="main">
		
		<?php the_breadcrumb(); ?>
		
		<h1 id="page-title">Road Conditions and Alerts</h1>
		
		<?php
		$conditions = get_page_by_path( 'road-conditions', OBJECT );
		if ( isset($conditions) ) :
		?>
			<article class="clear road-conditions">
				<h3>Current Road Conditions</h3>
				<section class="entry-content">
					<?php
					$content = $conditions->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					echo $content;
					?>
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
								'</span>',
								$conditions->ID
							);
						?>
					</footer><!-- .entry-footer -->
				<?php endif; ?>
			</article>
		<?php endif; ?>
		
		
		<?php while (have_posts()) : the_post(); ?>
			
		<article class="clear">
			<h2 class="entry-title"><?php the_title(); ?></h2>
			
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
	'prev_text'	=> '&laquo; Older alerts',
	'next_text'	=> 'Newer alerts &raquo;',
	)); ?>

	</div> <!-- end #main -->
	<?php get_template_part('page-footer'); ?>

<?php get_footer(); ?>
