	</div>
</div> <!-- end #content -->
			
<footer class="footer" role="contentinfo">
	<div id="inner-footer" class="wrap cf">
		
		<div id="footer-about">
			
			<?php 
		
				$about = get_page_by_path( 'about-mountain-transit', OBJECT );
				
				if ( isset($about) ) {
					$excerpt = get_extended( $about->post_content )['main'];
					echo $excerpt . ' '; 
					printf( '<a href="%s">Read more about Mountain Transit &raquo;</a>', get_permalink($about->ID) );
					edit_post_link( 'Edit this text', '<br />', '', $about->ID );
				}
			?>
			
		</div>

		<div id="footer-left-menu">
	
				<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'depth' => 1 ) ); ?>
		
		</div>
		
		<div id="footer-right-menu" class="clear">
			
			<?php wp_nav_menu( array( 'theme_location' => 'footer-secondary', 'depth' => 1 ) ); ?>
			
		</div>
		
		<br style="clear:both" />
		
		<div id="footer-copyright" class="source-org">
			
			&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>
			
		</div>
		
		<div id="footer-attributions">
			
			<a href="<?php echo get_site_url(); ?>/site-credits">Site Credits</a>
			
		</div>
			
	</div>

</footer>

</div> <!-- end #container -->
<?php wp_footer(); ?>
</body>
</html>
