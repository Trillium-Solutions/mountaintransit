<?php get_header(); ?>
			
	<div id="main" role="main">
		
		<?php the_breadcrumb(); ?>
		
		<article class="error-404">
		
		<h1 id="page-title">Oops! That page can't be found.</h1>
			
			<section class="entry-content clear" itemprop="articleBody">
				<p><?php esc_html_e( 'Sorry, but that page does not exist. Please search or use the links below', 'marta' ); ?></p>
				<?php get_search_form(); ?>
				<?php wp_list_pages(); ?>
			</section>
			
		</article>
		

</div> <!-- end #main -->
<?php get_template_part('page-footer'); ?>

<?php get_footer(); ?>
