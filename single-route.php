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
					<a href="<?php the_field('schedule_pdf') ?>">
						Route Guide PDF (1.5mb) &darr;
					</a>
				</div>
				<div id="route-fares-link">
					<a href="#fares">Fares Table &raquo;</a>
				</div>
			</div>
			
			<div id="alerts-wrap">
				
				<?php tcp_do_alerts( array('collapse' => 'false' ) ); ?>
				
			</div>
			
			<div id="interactive-map">
				
				<div id="map-header">
					<h3>Interactive Route Map <div class="map-helper tooltip">How to read (?)<span class="tooltiptext">Whenever this route is in service, the map will display icons that track the actual positions of buses in realtime. You can click on any stop to see the next estimated arrival times.</span></div></h3>
					<button id="map-expand" class="hidden">
						Expand map &hArr;
					</button>
				</div>
				
				<div id="map-holder">
					
					<?php get_route_map( get_the_ID() ) ?>
					
				</div>
				
			</div> <!-- end #interactive-map -->
			
			<div id="timetables">
				
				<div id="timetable-buttons">
					<div>
						<div class="caption">Direction</div>
						<div class="button-group dir" aria-label="timetable direction">
							<!-- Autofilled by Javascript -->
						</div>
					</div>
					
					<div>
						<div class="caption">Days</div>
						<div class="button-group days" aria-label="timetable day">
							<!-- Autofilled by Javascript -->
						</div>
					</div>
					
					<div class="text-arrivals">
						<div>Text Stop ID # to <a href="tel:9099630076">(909) 963-0076</a> for real-time bus arrivals on your phone</div>
					</div>
					
				</div>
				
				<?php the_timetables(); ?>
				
			</div>
			
			<!-- insert fares tables into routes? -->
			<div id="fare-table">
				<h3 id="fares">Fares</h3>
				<?php the_field('associated_fare_table'); ?>
				<a href="fares-and-tickets/#passes">See day pass and punch-pass prices &raquo;</a>
			</div>
		</div> <!-- end #main -->
					
	<?php endwhile; ?>
	
	<?php get_template_part('page-footer'); ?>
					
<?php get_footer(); ?>