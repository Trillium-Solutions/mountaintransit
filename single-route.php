<?php
/*
Template Name: route_individual_page
*/
 get_header(); ?>
 
 <style>
 img.large {
 width:100%;
 
 }
 
 </style>

<?php get_template_part( 'generic-page-top'); ?> 
			
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
					
					
					
						

		
											
							<div id="sidebar1" class="sidebar m-all t-1of3 d-2of7 last-col cf" role="complementary">

						<?php get_template_part( 'generic-sidebar'); ?> 
				</div>					
	
						<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">
						<?php
						
							$foundRoutes = false;

$savedRoute = get_field('route_short_name',$post->ID);
$args = array(
    'post_type' => 'attachment', 
    'post_mime_type' =>'image', 
    'post_status' => 'inherit', 
    'posts_per_page' => -1, 
    'meta_key' => 'route_short_names',
	//'meta_value' => get_field('route_number')
);
 
// get results
$the_query = new WP_Query( $args );
 
// The Loop
?>
<?php if( $the_query->have_posts() ): ?>
								
			
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		
		<?php
		if (strpos(get_field('route_short_names'),$savedRoute) !== false) {

    
$foundRoutes = true;
			
			}?>
		
	<?php endwhile; ?>

<?php endif; 
wp_reset_query(); ?>


						
						
								<?php the_breadcrumb( $post->ID) ?>
								
								
								<h1 id="page-title" class="route-page over-blue">
								<i id="route-icon" style="background-color:#<?php the_field('route_color') ?>;"></i>
								<i id="icon-lrg-<?php the_field('shared_class'); ?>" class="route-icon"></i><?php the_field('route_medium_name') ?>
								
								
								<div id="route-select-container">
		<?php
							wp_reset_query(); 
								
							$query = new WP_Query(array(
							'posts_per_page' => -1,
							"post_type"=>"route", 
							'meta_key'		=> 'display_order',
							'orderby'		=> 'meta_value',
							'order'			=> 'ASC'
								

							));

						
						
								if ( $query->have_posts() ) {
									?>
									<select id="routes-dropdown" onchange="location = this.options[this.selectedIndex].value;">
									<option value="#">View a different route</option>
									<?php
										while ( $query->have_posts() ) {
											$query->the_post();
											
										
											?>
											
												
												<option value="<?php echo get_site_url().'/'.get_field('pdf_service_area').'-routes-and-schedules/'.$post->post_name; ?>"><?php the_field('route_medium_name'); ?></option>
													
											
										<?php
										}
										?>
										</select>
										<?php
									}  
							wp_reset_postdata();
							?>
							
								</div><!-- end #route-select-container --></h1>
							
								<div id="route-locations-served">
									<?php  
									
									
									the_field('service_description');
									
																			
									 ?>
									 
									 
								</div><!-- end #route-locations-served -->
								<?php if( has_post_thumbnail()) { ?>
																			<hr />
										<div id="featured-image-container">
											<img class="featured-image"  src="
											<?php
										
												$thumb_id = get_post_thumbnail_id();
												$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'transit-page-600', true);
												echo $thumb_url_array[0];
										
											?>
											">
										</div><!-- end featured image -->
										<hr />
										<?php
										}
										?>
								
								<?php
								
								$route_post_id = $post->ID;
								wp_reset_query(); 
								
								$alertCount = 0;
								$alert_query = new WP_Query(array(

							"post_type"=>array("alert", 'news'), 
							'tax_query' => 
								array(
									array(
										'taxonomy' => 'alert-zone',
										'field' => 'slug',
										'terms' => array(strtolower(str_replace(' ','_',get_field('route_medium_name'))), 'all', 'all-routes')
										
									)
								),
								

							));

						
						
								if ( $alert_query->have_posts() ) { ?>
								<div id="route-alerts"> <?php
										echo '<ul>';
										while ( $alert_query->have_posts() ) {
											$alert_query->the_post();
											?>
												<li  class="minimized">
												<h3 class="route-alert-header <?php if($alertCount > 0) echo 'not-first'; ?>"><i id="alert-icon-black"></i>Service Alert: <?php the_title(); ?><span id="alert-click-message">Click to Expand</span></h3>  
												<div id="alert-content" style="display:none;">
												<?php
													the_content();	
												
												?>
												<div id="route-alert-link">
													<a href="<?php the_permalink(); ?>">Go to Alert Page >></a>
												</div><!-- end #route-alert-link -->
												
												</div><!-- end #alert-content -->
												</li>
												<?php
												$alertCount ++;
										}
										echo '</ul></div><!-- end #route-alerts -->';
									}  
							wp_reset_postdata();
							
							?>
								
							
										
										
										<div id="pdf-link">
											
											
											<?php
												// add different links here.
												
												$pdfDic = array(
															'rim' => 'MARTA_Rim_Guide_14_Layout_2.pdf',
															'big-bear' => 'MARTA_Big_Bear_Guide 11_Layout_2.pdf',
															'trolley' => 'Weekend_Trolley_Printable_Guide.pdf',);
												
											?>
											
												<a href="<?php echo get_site_url()."/wp-content/transit-data/guides/".$pdfDic[get_field('pdf_service_area')]; ?>"><i></i>Download the <?php echo ucwords(str_replace('-',' ', get_field('pdf_service_area') ) ); ?> route guide [PDF, 1.5mb]</a>
											</div><!-- end #pdf-link -->
										<div id="route-fares-link">
											<a href="<?php echo get_site_url();?>/fares-and-tickets/#<?php the_field('route_short_name'); ?>">See fares table for this route >></a>
											
											
											</div>
											<br style="clear:both;" />
											<hr />
											<ul id="route-anchors">
												<li><a href="#schedules">Schedules</a></li>
												<?php if($foundRoutes) { ?><li><a href="#maps">Detail Maps</a></li><?php } ?>
												<!--<li><a href="#connections"><?php the_agency_name(); ?> Connections</a></li>-->
												<!--<li><a href="#external-connections">External Connections</a></li>-->
												<br style="clear: both;" />
											</ul>
										<div class="route-info-box timetables">
											<h2 style=""> 
											<a name="schedules"></a>
											<div id="h2-inner">Schedules</div>
											
												<div id="route_days_of_week">
														<?php  the_field('days_of_service'); ?>
													
												</div> 
												<div id="fullscreen-table-link">
													<a href="javascript:void(0)"><i></i><span>Open timetables in full window</span></a> 
												</div><!-- end #fullscreen-table-link --> 
												<br style="clear:both; margin: 0px;" />
											</h2>
											<div id="timetable-holder">
											
											<?php
											
											$args = array(
												'numberposts' => -1,
												'post_type' => 'timetable',
												'meta_key' => 'route_short_name',
												'meta_value' => get_field( 'route_short_name')
											);
 
											// get results
											$the_query = new WP_Query( $args );
 
											// The Loop
											?>
											<?php if( $the_query->have_posts() ): ?>
												
												<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
												
												
												<?php the_content(); ?>
												
											
													
												<?php endwhile; ?>
												
											<?php endif; ?>
 
											<?php wp_reset_query();
											
											?>

										</div><!-- end #route-info-box -->
										

									<!--	<div class="route-info-box">
										
										<h2 style="border-left: 13px solid #<?php the_field('route_color'); ?>">Connections</h2>
										
										<?php  
										
										$explodedConnections = explode(',', get_field('connections'));
										foreach($explodedConnections as &$one_connection) {
								//	echo $one_connection;
	/*									
										$args = array(
	'numberposts' => -1,
	'post_type' => 'route',
	'meta_key' => 'route_number',
	'meta_value' => $one_connection
);
 
// get results
$the_query = new WP_Query( $args );
 
// The Loop
?>
<?php if( $the_query->have_posts() ): ?>
	<ul>
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<li>
				<li>
									
		</li>
	<?php endwhile; ?>
	</ul>
<?php endif; ?>
 
<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
				*/						
										
										}
										
									
										
										?>
																					<br style="clear: both;" />
										</div> --><!-- end #route-info-box --> 
					
										<br style="clear: both;" />
								

</div><!-- #timetable-holder -->

<?php


$args = array(
    'post_type' => 'attachment', 
    'post_mime_type' =>'image', 
    'post_status' => 'inherit', 
    'posts_per_page' => -1, 
    'meta_key' => 'route_short_names',
	//'meta_value' => get_field('route_number')
);
 
// get results
$the_query = new WP_Query( $args );
 
// The Loop
?>
<?php if( $the_query->have_posts() && $foundRoutes): ?>
								
								<div id="timetable-detail-maps">
								
								<h2 style=""> 
											<span class"span-title">Route Detail Maps</span> <span class="span-small-title">(Click a map to expand)</span>
											<a name="maps"></a>
											<br style="clear: both;" />
									</h2>
									
									
							

	<ul>
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		
		<?php
		if (strpos(get_field('route_short_names'),$savedRoute) !== false) {
   ?>
    
<li class="route-detail-holder">
			<span class="min"></span><a class="minimized" href="<?php echo wp_get_attachment_image_src( $attachment_id, 'large' )[0]; ?>"><img class="sml" src="<?php echo wp_get_attachment_thumb_url( $post->ID ); ?>" /></a>
			<div class="detail-name"><?php 
				$attachment_meta = wp_prepare_attachment_for_js($post->ID);
				echo $attachment_meta['title'];
				?>
			</div>
			</li>
			<?php
			}?>
		
	<?php endwhile; ?>
	</ul>
	<br style="clear: both;" />
	</div><!- end #timetable-detail-maps -->
<?php endif; ?>
 
<?php wp_reset_query(); 
?>

			<div class="route-info-box">
<!--							
<h2 style=""><?php the_agency_name();?> Connections<a name="connections"></a>	</h2>

<ul id="internal-connections">
<?php


$connections = get_field('connections'); 
$connectionsSplit = explode(';', $connections);

foreach($connectionsSplit as &$connection) {

	echo '<li>';

	echo '<i id="icon-sml-'.$connection.'" class="route-icon"></i>';
	

		
		$args = array(
			'numberposts' => -1,
			'post_type' => 'route',
			'meta_key' => 'shared_class',
			'meta_value' => $connection
		);

		// get results
		$the_query = new WP_Query( $args );

		// The Loop
		?>
		<?php if( $the_query->have_posts() ): ?>
			
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				
			<?php endwhile; ?>
			
		<?php endif; ?>

		<?php wp_reset_query();

			echo '</li>';

}




?> -->
<br stlye="clear: both;" />
</ul><!-- end #internal-connections -->
<br stlye="clear: both;" />
</div> <!-- end .route-info-box -->


					
					<br style="clear: both;">

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
							
						</div><!-- end #generic-wide-container -->
					
	
			
<?php get_template_part( 'generic-page-bottom'); ?> 
			


<?php get_footer(); 




?>