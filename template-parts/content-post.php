<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Reclaimthecity
 */
$post_id = get_the_ID();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class("margins"); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="bl_writer"><?php if( get_the_term_list( $post_id, 'writer' ) ){ ?>
			<h4 class="bl_book_author"><?php echo get_the_term_list( $post_id, 'writer',' ',', ' ); ?></h4><?php } ?>
		</div>
	</header><!-- .entry-header -->
	<div class="bl_content_left">
		<div class="bl_featured_image">
			<?php 
			$thumbnail=get_the_post_thumbnail();
			if($thumbnail){
				the_post_thumbnail( 'custom-thumb-3');
			}
			if(in_category('podcasts')){
				if(!$thumbnail){ ?><img width='300' src='/wp-content/uploads/dynamik-gen/theme/images/Podcastdefault.jpg'> <?php } ?>
					<div class="bl_follow_podcasts">
						<div class="bl_follow_link"><a href="https://open.spotify.com/show/6GV73W6pdPUFj7ETr7Pm0K?si=eE1qvlCMT0a0-m3ReA9o2w"><img src="/wp-content/uploads/dynamik-gen/theme/images/spotify.svg"><p>Follow us on Spotify</p></a></div>
						<div class="bl_follow_link"><a href="https://podcasts.apple.com/za/podcast/a-readers-community-by-the-book-lounge/id1517595046"><img src="/wp-content/uploads/dynamik-gen/theme/images/applepodcasts.svg"><p>Follow us on Apple Podcasts</p></a></div>
					</div>	
			<?php } ?>
		</div>
		<div class="bl_meta_cat">
			<?php  
			$list=get_the_term_list( $post_id, 'writer','',',' );
			$names=strip_tags($list);
			$name=explode(',',$names);
			foreach($name as $n){
				$terms=get_term_by( 'name', $n, 'writer' );
				if ($terms->count>1){ ?>
					<div class="bl_tiny_text">See more by</div>
					<h4 class="bl_book_author"><a href="/writer/<?php echo $terms->slug; ?>"><?php echo $terms->name; ?></a></h4><?php
				}
			} ?>
		</div>
	</div>

	<div class="entry-content">
		<?php
		the_content(); 
		if(in_category('podcasts')){ ?>
			<div class="bl_audio_player">
				<audio id="music" controls="controls">
					<source src="<?php echo get_field('add_podcast_audio') ?>" type="audio/mpeg"  preload="metadata"/>
				</audio>
				<h4>Listen Now: <?php echo get_the_title(); ?></h4>
				<div id="audioplayer">
					<button id="pButton" class="play" ></button>
					<div id="timeline">
						<div id="playhead"></div>
					</div>
				</div>
				<p class="small" id="podcast_duration"></p>
			</div>
		<?php } ?>
	</div><!-- .entry-content -->
	<div class="bl_content_right">
		<div class="bl_meta_cat">
			<div class="bl_tiny_text">Related content</div>
				<?php if (get_the_category($post_id)){ ?>
					<h4 class="bl_page_category">
						<?php the_category(' & '); ?>
					</h4> 
				<?php } ?>
		</div>
		<div class="bl_meta_tag">
			<?php if (get_the_tags($post_id )){ 
				the_tags( '<h4>', '</h4><h4>', '</h4>' );
			} ?>
		</div>
		<?php $staffmember=get_the_term_list($post_id,'staff-member','',' & ' );
		if ($staffmember){ ?>
			<div class="bl_meta_tag">
				<div class="bl_tiny_text">Recommended by</div>
					<h4 class="bl_page_category"><?php echo $staffmember; ?></h4>
				</div>
			</div>
		<?php } ?>
			<div class="related_content">
				<?php if (get_field("get_related_content")){ ?>
					<div class="bl_tiny_text">From our shop</div>
						<?php $bl_link_ids=get_field("get_related_content");
						foreach ($bl_link_ids as $bl_link_id){ ?>
							<a href="<?php echo get_the_permalink($bl_link_id); ?>">
								<?php echo get_the_post_thumbnail( $bl_link_id,'custom-thumb-2'); ?>
							</a>
							<h4>
								<a href="<?php echo get_the_permalink($bl_link_id); ?>">
									<?php echo get_the_title($bl_link_id); ?>
								</a>
							</h4><?php
						}
				}  
				if (get_field("get_related_events")){
					$bl_link_id=get_field("get_related_events")[0]; ?>
					<div class="bl_tiny_text">Upcoming Events</div>
					<a href="<?php echo get_the_permalink($bl_link_id); ?>">
						<?php echo get_the_post_thumbnail( $bl_link_id,'custom-thumb-2'); ?>
					</a>
					<h4>
						<a href="<?php echo get_the_permalink($bl_link_id); ?>">
							<?php echo get_the_title($bl_link_id); ?>
						</a>
					</h4>
				<?php } ?>
			</div>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
