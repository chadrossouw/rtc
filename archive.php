<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Reclaimthecity
 */

get_header();
$q = get_queried_object();
?>

<main id="primary" class="site-main">
	<h1 class="archive-title margins"><?php echo is_category() || is_tax() ? $q->name : $q->labels->name; ?></h1>
	<div class="margins archive_items"><?php
	// Check if there are any posts to display
	if ( have_posts() ) : 
	// The Loop
	while ( have_posts() ) : the_post(); ?>
	<?php $post_id = get_the_ID(); ?>
		<div class="rtc_archive_container margins">
		<?php if(get_post_type()!='podcast'): ?>	
			<a class="archive_item_title statement" href="<?php echo get_permalink($post_id); ?>">
			<?php echo get_the_title(); ?>
			</a>
			<div class = 'statement_archive_date'>
				Date: <?php echo get_field('date_of_statement', $post_id);?>
			</div>
			<?php if(get_field('press_statement_description', $post_id)):?>
				<div class = 'statement_archive_description'>
					<?php echo get_field('press_statement_description', $post_id);?>
				</div>
			<?php endif; ?>
			<a class ='download' href= "<?php echo (get_field('press_statement_file', $post_id));?>" download> Download <?php echo (get_the_title($post_id));?></a>
		
		<?php elseif(get_post_type()!='statement'): ?>
			<div class = 'podcast_archive_grid'>
				<div class="podcast_archive_title_group">
					<a class="archive_item_title podcast" href="<?php echo get_permalink($post_id); ?>">
						<?php echo get_the_title(); ?>
						</a>
						<div class = 'podcast_archive_date'>
							Date: <?php echo get_field('date_of_podcast', $post_id);?>
						</div>
				</div>
					<div class = 'podcast_archive_thumbnail'> 
						<?php echo wp_get_attachment_image(get_field('podcast_thumbnail',$post_id), 'medium');?> 
					</div>
					<?php if(get_field('podcast_description', $post_id)):?>
						<div class = 'podcast_archive_description'>
							<?php echo get_field('podcast_description', $post_id);?>
						</div>
					<?php endif; ?>
					<div class = 'podcast_archive_player'>
					<audio controls><source src= "<?php echo (get_field('podcast_file', $post_id));?>" type="audio/mpeg"></audio>
					</div>
			</div>

		<?php endif;?>
		</div>
	<?php
	endwhile; ?>

	<?php 
	$big = 999999999;
	global $wp_query;
	$paginate = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'total'        => $wp_query->max_num_pages,
            'current'      => max( 1, $paged),
            'format'       => '?paged=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 5,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => '<span class="screen-reader-text">Previous Page</span><',
            'next_text'    => '<span class="screen-reader-text">Next Page</span>>',
            'add_args'     => false,
            'add_fragment' => '',
        ) );
        echo '<div class="pagination">'.$paginate.'</div>'; ?>
</div>
<?php endif; ?>	

	</main><!-- #main -->

<?php
get_footer();
