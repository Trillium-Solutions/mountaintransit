<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">
				<div id="mobile-planner-container">
				
				
				</div><!-- end #mobile-planner-container -->
			
					<div id="home-desktop-map-container" class="mapWidth1151"> 
					
					<?php get_template_part( 'home-route-list'); ?> 
						
						<div id="map-background">
							<div id="map-hovers">
								<?php get_template_part( 'mapAreaCoords'); ?> 
							</div><!-- end #map-hovers -->
						</div> <!-- end #map-background -->
						
					<div id="planner-wrap">
						<div id="trip-planner-container" class="minimized">
							<?php get_template_part( 'home-planner'); ?> 
						
		
						</div> <!-- end #trip-planner-container -->
						<div id="planner-expand-contract-tab" class="minimized">expand</div>
						</div><!-- end #planner-wrap -->
						
						<div id="drop-down-info-text-wrap">
							&#9660; Click a route for details
						</div><!-- end #drop-down-info-text -->
						
						
						
						
						
					</div><!-- end #home-desktop-map-container -->

						<div id="home-secondary-container">
						
						<?php get_template_part( 'home-route-list-mobile'); ?> 
						
							<div id="secondard-links-row" >
								
								<div id="how-to-ride-links" class="secondary-col">
								<?php get_template_part( 'secondary-icon-links'); ?> 
								
								
								
								</div><!-- end #how-to-ride-links -->
							
						<div id="home-news-area" class="secondary-col" >
						<h2>News</h2>
						<?php
							
								
							$query = new WP_Query(array(
							'posts_per_page' => 3,
							"post_type"=>"news", 
								

							));

						
						
								if ( $query->have_posts() ) {
									?>
									<ul>
									<?php
									
										while ( $query->have_posts() ) {
											$query->the_post();
											
											?>
												<li class="home-news-outer" >
													 <a href="<?php the_permalink(); ?>" class="home-news-inner">
									   
														 <i></i> <?php the_title(); ?>
										 
													 </a>
												</li>	
											
										<?php
										}
										?>
										</ul>
										<?php
									}  
							wp_reset_postdata();
							?>
						
						<div id="home-more-news"><a href="./news">See More News >></a></div>
						
					</div> <!-- end #home-news-area -->
								<div id="right-secondary-links" class="secondary-col">

								<?php wp_nav_menu( array( 'theme_location' => 'secondary-link-right-menu' ) ); ?>
								<div id="social-links-holder">
									<a href="http://www.facebook.com/mountaintransit" class="facebook-link">
										<img src="<?php echo get_site_url(); ?>/wp-content/themes/mountain/library/images/fb-icons/png/FB-f-Logo__blue_50.png" width="25" />
									</a>
								</div><!-- end  id="social-links-holder" -->

						</div><!-- end #right-secondary-links -->
							
							</div> <!-- end #secondary-links-row -->
							<br style="clear: both;" />
														<div id="home-description-of-services">
														<?php $about_page = get_page_by_title( 'home_about' );
														
														$content = get_post_field('post_content', $about_page->ID); 
														echo $content;
														?>
							<a href="<?php echo get_permalink( 134); ?>" >More About <?php the_agency_name();?></a>
							</div> <!-- end #home-description-of-services -->
						
						
						</div><!-- end #home-secondary-container -->
					

				</div>

			</div>


<?php get_footer(); ?>
