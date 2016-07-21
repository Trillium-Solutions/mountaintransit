<?php get_header(); ?>

<?php get_template_part( 'generic-page-top'); ?> 
			<div id="content">

				<div id="inner-content" class="wrap cf">

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
						
						
						
						<?php if(is_post_type_archive('alert')) {   
							?>
							
							 <?php
							$conditions_post = get_post(479);
							$road_content = $conditions_post->post_content;
							$containsLettersOrNumbers = (preg_match('~[0-9a-z]~i', $road_content) > 0);
							if ($containsLettersOrNumbers) {
							?><div id="road-conditions">
							<h3 style="margin-top: 0; border-bottom: 1px solid yellow;">Current Road Conditions</h3>
							<?php
							echo $road_content;
						  if(is_user_logged_in()) edit_post_link('edit this info', '<p>', '</p>', 479);
							?> </div><!-- end #road-conditions -->
							
							<?php
						} else {
							 if(is_user_logged_in()) edit_post_link('Add a general road conditions message here.', '<p style="margin-left: 10px;">', '</p>', 479);
						}
						}
						
						
						
						
						
						 if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

								<header class="article-header">

									<h3 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
									<p class="article-date"> <?php the_date() ;?> </p>

								</header>
								

								<section class="entry-content cf">

									<?php the_post_thumbnail( 'bones-thumb-300' ); ?>

									<?php the_content(); ?>

								</section>

							
							</article>

							<?php endwhile; ?>

									<?php bones_page_navi(); ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h2>No alerts at this time</h2>
										</header>
										
									</article>

							<?php endif; ?>

						</div>

						

				</div>

			</div>
			<?php get_template_part( 'generic-page-bottom'); ?> 

<?php get_footer(); ?>
