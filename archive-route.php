<?php
/*
Template Name: Routes and Schedules
*/
 get_header(); ?>

<div id="content">

				<div id="inner-content" class="wrap cf">
				
					
					
					

						<div id="generic-wide-container">
						<?php the_breadcrumb() ?>
						<h1 id="page-title" class="over-blue"><?php echo ucwords(str_replace('-',' ',get_query_var( 'service_area' ))); ?> Routes &amp; Schedules</h1>
							
							 	<div id="routes-page-blurb">
							 		Click a route in the list below or in the map to 
									get its schedule, detailed service maps, and connections.
							 	</div><!-- end #routes-page-blurb -->
							 	
							 <div id="route-archive-list">	<?php get_template_part( 'route-list');   ?></div><!-- end#route-archive-list -->
					<br style="clear: both;" />

				<?if(get_query_var( 'service_area' ) == 'rim') { ?>
					<div id="rim-page-map-container" class="mapWidth1151"> 
						<div id="map-background">
							<div id="map-hovers">
								<?php get_template_part( 'rim-mapAreaCoords'); ?> 
							</div><!-- end #map-hovers -->
						</div> <!-- end #map-background -->

					</div><!-- end #rim-page-map-container -->
				
		
					

			<?php }  else { // big bear 
			
			?>
					<div id="big-bear-page-map-container" class="mapWidth1151"> 
				
					
						
						<div id="map-background">
							<div id="map-hovers">
								<?php get_template_part( 'big-bear-mapAreaCoords'); ?> 
							</div><!-- end #map-hovers -->
						</div> <!-- end #map-background -->

					</div><!-- end #big-bear-page-map-container -->
				
		
						
					

			<?php
			
			} ?>
			</div><!-- end #generic-wide-container -->
<?php get_template_part( 'generic-page-bottom'); ?> 
			


<?php get_footer(); 




?>