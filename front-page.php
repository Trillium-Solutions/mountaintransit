<?php get_header(); ?>
					
<div id="home-desktop-map-container"> 
						
	<div id="planner-wrap">
		<div id="planner">
		
			<?php get_template_part( 'home-planner'); ?> 
		
		</div> <!-- end #trip-planner-container -->
	</div><!-- end #planner-wrap -->
	
	<div id="map-wrap" class="mobile-hide">
		<!-- <iframe src="https://marta.doublemap.com/map/embed?key=s3283xKQfwfunfcNPM2KJPNBwo0X17Zt&inactive=true"></iframe> -->
	</div>
	
		<a href="interactive-system-map/" class="mobile-only home-map-link">Interactive System Map &rarr;</a>
	
	<div id="alerts-wrap">
		<?php tcp_do_alerts( array('collapse' => 'false' ) ); ?>
	</div>

</div><!-- end #home-desktop-map-container -->

<div id="home-secondary-container" class="clear">
						
	<div id="home-news-area">
		<h2>News<a href="./news">See all news &raquo;</a></h2>
		<?php
		$news_query = new WP_Query( array(
			'posts_per_page'	=> 2,
		) );
		if ( $news_query->have_posts() ) :
		?>
		<div id="news-container">
				<?php
				while ( $news_query->have_posts() ) : $news_query->the_post();
					$background = '';
					if ( has_post_thumbnail() ) { 
						$background = 'style="background-image: url(' . get_the_post_thumbnail_url(null,'medium') . ')" ';
					} ?>
					<a class="news-card" href="<?php the_permalink(); ?>" <?php echo $background; ?> >
						<h3><?php the_title(); ?><span class="date"><?php the_time('F j, Y')?></span></h3>
					</a>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<div id="home-more-news"></div>
		<?php else : ?>
			<p>No news at this time.</p>
		<?php endif; ?>	
	</div> <!-- end home-news-area -->
	
	<div id="newsletter-subscribe">
		<h3>Sign up to receive news and alert updates</h3>
		<form>
			<div class="form-row">
				<input type="email" id="email_addr" placeholder="Your e-mail address">
				<button type="submit">Subscribe</button>
			</div>
		</form>
	</div>
	
</div> <!-- end home-secondary-container -->
					
<?php get_footer(); ?>
