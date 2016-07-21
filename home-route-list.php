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
							
							
						
							
	
	
	$query = new WP_Query(array(
							'posts_per_page' => -1,
							"post_type"=>"route",
							'orderby' => 'meta_value',
							'meta_key' => 'display_order',
							'order' => 'ASC'
								

							));

						
						
								if ( $query->have_posts() ) {
									?>
									<ul>
									<?php
									
										while ( $query->have_posts() ) {
											$query->the_post();
											
										
											$clean_name = str_replace('big-bear-weekend','weekend','_'.strtolower(str_replace(' ','-',get_field('route_medium_name' )  )  ) );
											
											?>
												<li class="generic-route-item bg-<?php echo get_field('route_short_name').' '.$clean_name; ?>" >
												<?php $term_list = wp_get_post_terms($post->ID, 'service_area', array("fields" => "all"));?>
												
												
													 <a href="<?php echo get_site_url().'/'.$term_list[0]->slug.'-routes-and-schedules/'.$post->post_name; ?>" ><?php the_field('route_medium_name');?></a>
												<span class="home-list-hover"></span>
												</li>	
											
										<?php
											foreach($alert_route_names as &$alert_zone) {
													echo '<!-- alert zone: '.$alert_zone.' route name: '.strtolower(str_replace(' ','_',get_field('route_medium_name' ) ) ).'-->';
													if($alert_zone == strtolower(str_replace(' ','_',get_field('route_medium_name' ) ) )) {
													
														echo '<i class="generic-alert-icon"></i>';
													}
								
												}
										}
										?>
										</ul>
										<?php
									}  
							wp_reset_postdata(); 
							?>
						
						
</div><!-- end #generic-route-list -->