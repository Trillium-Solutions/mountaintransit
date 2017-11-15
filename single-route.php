<?php
/*
Template Name: route_individual_page
*/
 get_header(); ?>
 
	<?php while (have_posts()) : the_post(); ?> 
		
		<div id='main' role='main'>
			
			<div id="page-top">
			
				<?php the_breadcrumb(); ?>
			
				<?php marta_route_select(); ?>
			
			</div>
			
			<?php marta_custom_route_title(); ?>
			
			<div class="top-links">
				<div id="pdf-link">
					<a>Route Guide PDF (1.5mb) &darr;</a>
				</div>
				<div id="route-fares-link">
					<a>Fares Table &raquo;</a>
				</div>
			</div>
			
			<div id="alerts-wrap">
				
				<?php tcp_do_alerts( array('collapse' => 'false' ) ); ?>
				
			</div>
			
			<div id="interactive-map">
				
				<div id="map-header">
					<h3>Interactive Route Map <div class="map-helper tooltip">How to read (?)<span class="tooltiptext">Whenever this route is in service, the map will display icons that track the actual positions of buses in realtime. You can click on any stop to see the next estimated arrival times.</span></div></h3>
					<button id="map-expand">
						Expand map &hArr;
					</button>
				</div>
				
				<div id="map-holder">
					
					<?php get_route_map( get_post_meta(get_the_ID(), 'route_long_name', true) ) ?>
					
				</div>
				
			</div> <!-- end #interactive-map -->
			
			<div id="timetables">
				
				<?php the_timetables(); ?>
				
			</div>
			
			<!-- insert fares tables into routes? -->
		</div> <!-- end #main -->
					
	<?php endwhile; ?>
					
<?php get_footer(); ?>