<?php
/*
Template Name: Fares Page
*/

$base_site_data_url = '/nas/wp/www/cluster-30005/mountainmarta';

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

						

								<section class="entry-content cf" itemprop="articleBody">
									<?php
										// the content (pretty self explanatory huh)
										if( has_post_thumbnail()) { ?>
										<div id="featured-image-container">
											<img class="featured-image" src="
											<?php
										
												$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
												echo $feat_image;	
										
											?>
											">
										</div><!-- end featured image -->
										<div id="page-anchor-links"><ul></ul></div>
										<?php
										}
										
									 the_content(); 
									 
									 
									 ?>
									 
									<!-- <h4 class="subtitle">FARE CALCULATOR</h4> 
									 <div id="fare-form-holder">
										<form id="fare_zones" method="GET" action="http://trilliumtransit.com/applications/fare_calculator/calculate_fare_result.php">
										<input type="hidden" name="agency_id" value="194">
										<div id="fare-calculator-details">
										<div id="fare-start" >Start zone: <select class="from" name="origin_id" id="start_zone" onchange="clear_fare_result();"><option>Select start zone</option></select></div>
										<div id="fare-end" >Destination zone: <select class="to" name="destination_id" id="end_zone" onchange="clear_fare_result();"><option>(Select start first)</option></select></div>
										<input type="submit" value="Get Regular Cash Fare:" id="get-fares"/>
										<div id="get-fares-results">
										<div class="info">
										<div id="regular_fare">$ --</div>
										
										</div>
										</div>
											<br style="clear: both;" />
										</div>

										</form>
									</div> --><!-- end #fare-form-holder -->
									 
									
									 <script src="<?php echo get_template_directory_uri(); ?>/library/js/fare_calculator.js" type="text/javascript"></script>
									<hr /><h2>Route Fares Quicklinks</h2>
									 <?php
									 
									 // Organize by area
									 
									 $index_out = "";
									
									
									
									
									$args = array(
												'posts_per_page' => -1	,
												'post_type' => 'route',
												'orderby' => 'meta_value_num', 
												'meta_key' => 'display_order',
												
 												'order' => 'ASC'
												
											);
 
											// get results
											$the_query = new WP_Query( $args );
 
											// The Loop
											$icon_out = "";
											?>
											<?php if( $the_query->have_posts() ):  ?>
												<ul>
													<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
															
															echo '<li><a href="#'.get_field('route_short_name',$post->ID).'">'.get_field( 'route_medium_name', $post->ID ).'</a></li>';
														
												 endwhile; ?>
												</ul>
											<?php endif; ?>
 
									<?php wp_reset_query();  
									 
									for ($i = 0; $i<19; $i ++) { 
										 $faresHTML = file_get_contents(get_site_url()."/wp-content/transit-data/fares/".$timetable);
									 }
									
									 
									$files = array();
									$fares_loc = $base_site_data_url.'/wp-content/transit-data/fares/';
									if(strpos($_SERVER[HTTP_HOST],'localhost') !== false) {
									
										$fares_loc = '/Applications/MAMP/htdocs/mountain/wp-content/transit-data/fares/';
									
									}
								 if ($handle = opendir($fares_loc)) {
							
									while (false !== ($entry = readdir($handle))) {

										if ($entry != "." && $entry != "..") {

											$files[] = $entry;
										}
									}

									closedir($handle);
								}
									
									$fares_out = '<ul id="fares-list">';
									$links_out = "";
									
									function cmp($a, $b)
									{
										$matchesA = array();
									
										preg_match_all('!\d+!', $a, $matchesA);
										//echo $matchesA[0][0];
										$matchesB = array();
										preg_match_all('!\d+!', $b, $matchesB);
										
										if(sizeof($matchesA) <= 0 ||  sizeof($matchesB) <= 0) {
											return 0;
										}
										
										return ( intval($matchesA[0][0]) > intval($matchesB[0][0])) ? 1 : -1;
									}
									
									sort($files);
									
									
									
									foreach($files as &$file) {
										// get the route number
										
										
										
									 	$route_names = explode(',',explode('*',explode('.',$file)[0])[1]);
										$matches = array();
										preg_match_all('!\d+!', $file, $matches);
										
										foreach($route_names as &$route_name) {
										
										//go through routes
											$args = array(
												'numberposts' => -1,
												'post_type' => 'route',
												'meta_key' => 'route_short_name',
												'meta_value' => $route_name,
											);
 
 
											// get results
											$the_query = new WP_Query( $args );
 
											// The Loop
											$icon_out = "";
											?>
											<?php if( $the_query->have_posts() ): ?>
												
												<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
														
														$icon_out .= '<a name="'.get_field('route_short_name',$post->ID).'"></a>'; 
														//$icon_out .= '<a href="'.get_the_permalink().'"><i id="icon-sml-'.get_field( 'shared_class', $post->ID ).'" class="route-icon" style="float: left; margin-right: 10px"></i></a>'; 
													
												 endwhile; ?>
												
											<?php endif; ?>
 
											<?php wp_reset_query(); 
										
										
										}
										//$fares_out .= $icon_out;
										foreach($route_names as &$route_name) {
											$fares_out  .= '<a name="'.$route_name.'"></a>';	
										}
										 
										$fares_out .= file_get_contents(get_site_url().'/wp-content/transit-data/fares/'.$file);
										//$fares_out .= '<caption>';

										
										//$index_out .= explode(explode('<caption>',file_get_contents(get_site_url().'/wp-content/transit-data/kern-transit-fares/'.$file))[1], "</capti
										//$fares_out .= explode('<caption>',file_get_contents(get_site_url().'/wp-content/transit-data/fares/'.$file))[1];
										
										
										
									}
										
										?> <?php
										echo $index_out;
										?><hr /> <?php
										$fares_out .= '</ul>';
										echo $fares_out;

										/*
										 * Link Pages is used in case you have posts that are set to break into
										 * multiple pages. You can remove this if you don't plan on doing that.
										 *
										 * Also, breaking content up into multiple pages is a horrible experience,
										 * so don't do it. While there are SOME edge cases where this is useful, it's
										 * mostly used for people to get more ad views. It's up to you but if you want
										 * to do it, you're wrong and I hate you. (Ok, I still love you but just not as much)
										 *
										 * http://gizmodo.com/5841121/google-wants-to-help-you-avoid-stupid-annoying-multiple-page-articles
										 *
										*/
									
									?>
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
