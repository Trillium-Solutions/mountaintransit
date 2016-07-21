<?php
/*
Template Name: Board meetings
*/

?> 

<?php get_header();


	$archive = false;
	if(isset($_GET['archive'])){
		if($_GET['archive'] == 'true'){
			$archive = true;
		}
	}
 ?>

			<?php get_template_part( 'generic-page-top'); ?> 
			
			<div id="sidebar1" class="sidebar m-all t-1of3 d-2of7 last-col cf" role="complementary">

						<?php get_template_part( 'generic-sidebar'); ?> 
				</div>
			

						<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">
						
						<?php the_breadcrumb() ?>
						
					<?php if(is_archive()) {
					
					?>
					
					<h1 id="page-title" class="over-blue"><?php post_type_archive_title(); ?></h1>
					
					<?php
					
					} else if(is_search()) { ?>
					
					<h1 id="page-title" class="over-blue"><span><?php _e( 'Search Results for:', 'bonestheme' ); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>
					
					
					<?php } else { 
					$archive_title = '';
					if($archive) $archive_title = ' (Archive)<a style="font-size: .4em; text-decoration: underline; float: right;" href="'.get_site_url().'/board-meetings" >	&larr;Back to current year only</a>';
					?>
					<h1 id="page-title" class="over-blue"><?php the_title(); echo $archive_title; ?></h1>
					
						<?php } 
						
						

						 if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						

								<section class="entry-content cf" itemprop="articleBody">
									<?php
										// the content (pretty self explanatory huh)
										if( has_post_thumbnail()) { ?>
										<div id="featured-image-container">
											<img class="featured-image" src="
											<?php
										
												$thumb_id = get_post_thumbnail_id();
												$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
												echo $thumb_url_array[0];
										
											?>
											">
										</div><!-- end featured image -->
										<div id="page-anchor-links"><ul></ul></div>
										<?php
										}

										
										
										$args = array(
												'numberposts' => -1,
												'post_type' => 'board-meeting',
												'meta_key' => 'board_meeting_date',
												'order' => 'ASC',
												'posts_per_page' => 100
												
											);
											if(!$archive){
												$args['year']=date('Y');// gets current year
											}
 
											// get results
											$the_query = new WP_Query( $args );
 
											// The Loop
											?>
											<?php if( $the_query->have_posts() ): ?>
												
												<h2>Meeting dates, agendas, and minutes</h2>
												<table id="board-meeting-table" style="text-align: center;">
												
												<tr>
													<th>Date</th>
													<th>Location</th>
													<th>Agenda</th>
													<th>Minutes</th>
												</tr>
												
												<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

												<tr>
													<td><?php
echo date_format(new DateTime(get_field('board_meeting_date')),"F j, Y");
?></td>
													<td><address style="font-size:.9em; text-align: left;" ><?php the_field('board_meeting_location'); ?></address></td>
													<td>
													<?php if(get_field('board_meeting_agenda') != "") {?>
														<a href="<?php echo get_field('board_meeting_agenda'); ?>">Agenda [PDF]</a>
													<?php }else {?>
													 -
													 <?php } ?>
													</td>
													<td>
													<?php if(get_field('board_meeting_minutes') != "") {?>
														<a href="<?php echo get_field('board_meeting_minutes'); ?>">Minutes [PDF]</a>
													<?php } else {?>
													 -
													 <?php } ?>
													</td>
												
												</tr>
												
												
											
													
												<?php endwhile; ?>
												</table>
											<?php endif; ?>
 
											<?php wp_reset_query();
											
											if(!$archive){
												echo '<a href="'.get_site_url().'/board-meetings/?archive=true">See Archive of all Meetings</a>';
											}
									 the_content(); 

										/*
										 * Link Pages is used in case you have posts that are set to break into
										 * multiple pages. You can remove this if you don't plan on doing that.
										 *
										 * Also, breaking content up into multiple pages is a horrible experience,
										 * so don't do it. While there are SOME edge cases where this is useful, it's
										 * mostly used for people to get more ad views. It's up to you but if you want
										 * to do it, you're wrong and I hate you. (Ok, I still love you but just not as much)
										 *
										 * http://gizmodo.com/5841121/google-wants-to-help-you-avoid-stupid-annoying-multiple-page-articles
										 *
										*/
									
									?>
								</section> <?php // end article section ?>

							



							</article>

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

						</div>

						

		<?php get_template_part( 'generic-page-bottom'); ?> 
			

<?php get_footer(); ?>
