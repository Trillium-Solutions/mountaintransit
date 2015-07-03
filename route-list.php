<div id="generic-route-list">
	<?php
	
	

	
	$alert_route_names = array();
		// Get all current alerts
		$terms = get_terms( 'alert-zone' ); 
// convert array of term objects to array of term IDs
$term_ids = wp_list_pluck( $terms, 'term_id' );
	$query = new WP_Query(array(
							'posts_per_page' => -1,
							"post_type"=>array("alert","news"),
							'tax_query' => array(
								array(
								'taxonomy' => 'alert-zone',
								'field' => 'term_id',
								'terms' => $term_ids)
						
								
							)));

						
						
								if ( $query->have_posts() ) {
									?>
									
									<?php
									
										while ( $query->have_posts() ) {
											$query->the_post();
											
											?>
												

														<?php 
														
														
														$posttags = get_the_terms($post->ID, 'alert-zone');
														
														
														
														
														foreach($posttags as $tag) {
															
															
															  $alert_route_names[] = $tag->slug;
															
														  }
														
														 ?>
													 </a>
												
											
										<?php
										}
										?>
										
										<?php
									}  
							wp_reset_postdata(); 
							?>
							
						
							
		<ul>
	<?php
	 if (have_posts()) : while (have_posts()) : the_post(); ?>

						
						
							
								
									<?php
									
											$clean_name = str_replace('big-bear-weekend','weekend','_'.strtolower(str_replace(' ','-',get_field('route_medium_name' )  )  ) );
											
											?>
												<li class="generic-route-item bg-<?php echo get_field('route_short_name'); echo ' '.$clean_name; ?> " >
												<div class="generic-route-top">
												<?php $term_list = wp_get_post_terms($post->ID, 'service_area', array("fields" => "all"));?>
												<?php $alert_icon = ''; ?>
												<?php foreach($alert_route_names as &$alert_zone) {
													
													$lowerCase = strtolower(str_replace(' ','_',get_field('route_medium_name' ) ) );
													
													
													
													if(strcmp($alert_zone, $lowerCase ) == 0) {
													
														$alert_icon= '<i class="generic-alert-icon"></i>';
								
													}
													
												} ?>
													 <a href="<?php echo get_site_url().'/'.$term_list[0]->slug.'-routes-and-schedules/'.$post->post_name; ?>" ><span class="hover-dot"></span><?php echo $alert_icon; the_field('route_medium_name');?></a>
												</div>
												<div class="generic-route-bottom">
													<?php the_field('days_of_service'); ?>
												</div>
												
												</li>	
											
										<?php
											
										endwhile;
										endif;
										?>
										
										</ul>
										<?php
									
							 
							?>
						
						
</div><!-- end #generic-route-list -->