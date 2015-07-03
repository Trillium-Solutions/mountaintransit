


<?php

		 	 wp_reset_query(); 
							 	
					$service_areas = get_terms("service_area");

					//You can use print_r to see the values in the array
					echo "<pre>";
					//print_r($service_areas);
					echo "</pre>";

					//Loop through each service_area
					

							//Search posts with the service_area name
							?> 
							<div class="area-box " id="">



<ul>

<?php
						 if (have_posts()) : while (have_posts()) : the_post(); ?>
										<li> 
										<i class="route-icon-med" style="background-color: #<?php the_field('route_color');?>;"></i>
										<div class="route-name" alt="<?php echo the_field('shared_class', $post->ID); ?>"><a href="/routes-and-schedules/<?php $exploded = explode('_',get_field('shared_class', $post->ID)); echo $exploded[1] ?> "><?php echo get_the_title($post->ID); ?></a></div>
										<div class="route-days-of-week"><?php echo the_field('days_of_week', $post->ID); ?></div>
										</li>
										<?php
								endwhile;
								
								?>
							</ul>
							
							
							
							<?php endif; ?>
							
							
							</ul>
</div><!-- end #id -->
<?php

					
					
					?>

