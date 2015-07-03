<?php
/*
Template Name: Dial-A-Ride page
*/


get_header(); ?>

			<?php get_template_part( 'generic-page-top'); ?> 
			
			<div id="sidebar1" class="sidebar m-all t-1of3 d-2of7 last-col cf" role="complementary">

						<?php get_template_part( 'generic-sidebar'); ?> 
				</div>
			

						<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">
						
						<?php the_breadcrumb() ?>
						
					<?php if(is_archive()) {
					
					?>
					
					<h1 id="page-title" class="over-blue"><?php post_type_archive_title(); ?></h1>
					
					<?php
					
					} else if(is_search()) { ?>
					
					<h1 id="page-title" class="over-blue"><span><?php _e( 'Search Results for:', 'bonestheme' ); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>
					
					
					<?php } else { ?>
					<h1 id="page-title" class="over-blue"><?php the_title() ?></h1>
					
						<?php }  ?>

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						

								<section>
									<?php
										// the content (pretty self explanatory huh)
										if( has_post_thumbnail()) { ?>
										<div id="featured-image-container">
											<img class="featured-image" src="
											<?php
										
												$thumb_id = get_post_thumbnail_id();
												$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
												echo $thumb_url_array[0];
										
											?>
											">
										</div><!-- end featured image -->
										<div id="page-anchor-links"><ul></ul></div> 
										<?php
										}
										
									 
									 
									 ?>
									 
									  <div id="dar-phone" class="entry-content cf">
									  To request a ride call  <a href="tel:<?php the_field('phone');?>">
									 <?php
									 the_field('phone');
									 ?>
									 </a>
									 </div><!-- end #dar-phone-->
									
									 <div id="dar-service-description" class="entry-content cf">

									 <?php
									 the_field('service_description');
									 ?>
									 </div><!-- end #dar-service-description-->
									 
									 

 <h2>Hours of Operation</h2>
 <div id="dar-hours-of-operation" class="entry-content cf">
									 <?php
									 the_field('hours_of_operation');
									 ?>
									 </div><!-- end #dar-hours-of-operation-->

<h2>Fares</h2>
 <div id="dar-fares" class="entry-content cf">
									 <?php
									 the_field('dar_fares');
									 ?>
									 </div><!-- end #dar-fares -->


								</section> <?php // end article section ?>

							



							</article>

							<?php endwhile; else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the page.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

						

		<?php get_template_part( 'generic-page-bottom'); ?> 
			

<?php get_footer(); ?>
