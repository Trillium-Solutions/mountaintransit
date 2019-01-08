<?php
/*
Template Name: Board meetings
*/

?>

<?php get_header(); ?>

	<div id="main" role="main">

		<?php while (have_posts()) : the_post(); ?>

			<?php the_breadcrumb(); ?>

		<article class="clear">
			<h1 id="page-title"><?php the_title() ?></h1>
			<section class="entry-content cf" itemprop="articleBody">

				<?php if( has_post_thumbnail()) : ?>
					<div id="featured-image-container">
						<img class="featured-image" src="
							<?php

							$thumb_id = get_post_thumbnail_id();
							$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
							echo $thumb_url_array[0];

							?>
						">
					</div><!-- end featured image -->
				<?php endif; ?>

				<?php
				$archive_year = date("Y");
				if(isset($_GET['archiveyear'])) {
					$archive_year = sanitize_text_field($_GET['archiveyear']);
				}
				?>
				<form method="get" action="">
					<label for="archiveyear">Show different year: </label>
					<select name="archiveyear" id="archiveyear">
						<?php
						$cur = date("Y");
						$first = 2015;
						$range = range($cur, $first);
						foreach($range as $r) {
							echo '<option value="'.$r.'">'.$r.'</option>';
						}
						?>
					</select>
					<input type="submit" value="Get Meetings" />
				</form>
				<?php
				$start = $archive_year . '0101';
				$end = $archive_year . '1231';
				$args = array(
					'post_type' => 'board-meeting',
					'meta_key' => 'board_meeting_date',
					'orderby' => 'meta_value_num',
					'order' => 'ASC',
					'posts_per_page' => -1,
					'meta_query'	=> array(
						'relation' => 'AND',
						array(
							'key' => 'board_meeting_date',
							'value' => $start,
							'compare' => '>=',
							'type' => 'NUMERIC',
						),
						array(
							'key' => 'board_meeting_date',
							'value' => $end,
							'compare' => '<=',
							'type' => 'NUMERIC',
						),
					)
				);
				$q = new WP_Query($args);
				if ( $q->have_posts() ) :
				?>

				<h2><?php echo $archive_year; ?> Meeting dates, agendas, and minutes</h2>
				<table id="board-meeting-table" style="text-align: center;">

				<tr>
					<th>Date</th>
					<th>Location</th>
					<th>Agenda</th>
					<th>Minutes</th>
				</tr>

				<?php while ( $q->have_posts() ) : $q->the_post(); ?>

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

				<?php endwhile; wp_reset_postdata(); ?>
			</table>
			<?php endif; ?>

			<?php the_content(); ?>

			</section>

			<?php if ( get_edit_post_link() ) : ?>
				<footer class="entry-footer">
					<?php
						edit_post_link(
							sprintf(
								/* translators: %s: Name of current post */
								esc_html__( 'Edit %s', 'marta' ),
								the_title( '<span class="screen-reader-text">"', '"</span>', false )
							),
							'<span class="edit-link">',
							'</span>'
						);
					?>
				</footer><!-- .entry-footer -->
			<?php endif; ?>

		</article>

	<?php endwhile;  ?>

	</div> <!-- end #main -->

	<?php get_template_part('page-footer'); ?>

<?php get_footer(); ?>
