<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();

?>

<div id="tribe-events-content" class="tribe-events-single event_grid">
		<!-- Notices -->
		<?php tribe_the_notices() ?>

<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php if (get_the_term_list( $post_id, 'writer' )){ ?>
			<div class="bl_writer">
				<h4 class="bl_book_author"><?php echo get_the_term_list( $post_id, 'writer',' ',', ' ); ?></h4><?php  ?>
			</div>
		<?php } ?>
		<div class="tribe-events-schedule tribe-clearfix">
		<?php echo tribe_events_event_schedule_details( $event_id, '<h4 class="bl_book_author">', '</h4>' ); ?>
		<?php if ( tribe_get_cost() ) : ?>
			<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
		<?php endif; ?>
	</div>
	</header><!-- .entry-header -->
 <div class="bl_content_left">

 
		<div class="bl_events_link">
				<h3><a href="<?php echo esc_url( tribe_get_events_link() ); ?>">See the Full Calendar</a></h3>
			</div>
		</div>
	<div class="entry-content">
		<?php while ( have_posts() ) :  the_post(); ?>
		<img src="<?php the_field('invite_image'); ?>" class="bl_image_invite"> 
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<!-- Event featured image, but exclude link -->
				<!-- Event content -->
				<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
				<div class="tribe-events-single-event-description tribe-events-content">
					<?php the_content(); ?>
				</div>
				<!-- .tribe-events-single-event-description -->
			
		</div>
	</div>
			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ;?>
			<div class="bl_content_right">
			<?php
			
			if ( tribe_get_venue_id() ) {
			// If we have no map to embed and no need to keep the venue separate...
			if ( ! $set_venue_apart && ! tribe_embed_google_map() ) {
				tribe_get_template_part( 'modules/meta/venue' );
				} elseif ( ! $set_venue_apart && ! tribe_has_organizer() && tribe_embed_google_map() ) {
				// If we have no organizer, no need to separate the venue but we have a map to embed...
				tribe_get_template_part( 'modules/meta/venue' );
				echo '<div class="tribe-events-meta-group tribe-events-meta-group-gmap">';
				tribe_get_template_part( 'modules/meta/map' );
				echo '</div>';
			} else {
			// If the venue meta has not already been displayed then it will be printed separately by default
			$set_venue_apart = true;
				}
			}

			// Include organizer meta if appropriate
			if ( tribe_has_organizer() ) {
				tribe_get_template_part( 'modules/meta/organizer' );
			} 
			if ( get_field('rsvp_required_for_event') == 1 ) {
				?>
				<div class="bl_rsvp">
					<p>
						If you'd like to attend, please <button type="button" class="rsvp"><a href="/rsvp">RSVP for this event</a></button></p>
				</div>
				<?php }
			 do_action( 'tribe_events_single_event_after_the_meta' ) ?>
			<div class="related_content"><?php if (get_field("get_related_content")){
			$bl_link_id=get_field("get_related_content")[0];
			?><div class="bl_tiny_text">From our shop</div><a href="<?php echo get_the_permalink($bl_link_id); ?>"><?php echo get_the_post_thumbnail( $bl_link_id,'custom-thumb-2'); ?></a><h4><a href="<?php echo get_the_permalink($bl_link_id); ?>"><?php
			echo get_the_title($bl_link_id); ?></a></h4><?php
			}  if (get_field("get_related_events")){
			$bl_link_id=get_field("get_related_events")[0];
			?><div class="bl_tiny_text">Upcoming Events</div><a href="<?php echo get_the_permalink($bl_link_id); ?>"><?php echo get_the_post_thumbnail( $bl_link_id,'custom-thumb-2'); ?></a><h4><a href="<?php echo get_the_permalink($bl_link_id); ?>"><?php
			echo get_the_title($bl_link_id); ?></a></h4><?php
			} ?></div>
			<?php do_action( 'tribe_events_single_event_after_the_content' ); ?>
			</div>
		</div>
		</div> <!-- #post-x -->
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

</div><!-- #tribe-events-content -->