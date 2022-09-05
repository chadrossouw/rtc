<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Reclaimthecity
 */

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('home no-max'); ?>>
		<?php
		//var_dump(get_field('layouts'));
		if( have_rows('layouts') ): ?>
		<div class="layouts">
		<?php while( have_rows('layouts') ): the_row(); ?>
		<?php
		if ( get_row_layout()=='banner' ){
			$banner_id = strtolower(str_replace('%','',str_replace('+','_',urlencode(trim(get_sub_field('banner_title'))))));
			$image_mobile = wp_get_attachment_url(get_sub_field('banner_background_image_mobile'));
			$image_desktop = wp_get_attachment_url(get_sub_field('banner_background_image'));
			if ($image_mobile && $image_desktop) {
				$bg_m_style = 'background-image: url('. $image_mobile .')';
				$bg_d_style = 'background-image: url('. $image_desktop .')';
				?>
				<style>
					<?php echo '#'.$banner_id; ?>{
						<?php echo $bg_m_style; ?>
					}
					@media screen and (min-width:700px) {
						<?php echo '#'.$banner_id; ?>{
						<?php echo $bg_d_style; ?>
						}
					}
				</style>
				<?php 
			} 
			elseif($image_mobile||$image_desktop){
				$image = $image_mobile?$image_mobile:$image_desktop;
				$bg_d_style = 'background-image: url('. $image .')';
				?>
				<style>
					<?php echo '#'.$banner_id; ?>{
						<?php echo $bg_d_style; ?>
					}
				</style>
				<?php 
			}
			if( get_sub_field('background_color') == 'none' ) {
				$bg_color = 'bg_image';
			}
			else{
				$bg_color = get_sub_field('background_color');
			}
				?>
			<?php if (get_sub_field('banner_internal_link')){
			$url = get_permalink(get_sub_field('banner_internal_link')[0]);
			
			}
			else{
			$url = get_sub_field('banner_external_link');
			}
			?>
			<a id="<?php echo $banner_id; ?>" class="container banner_container home_section padding <?php echo $bg_color ?>" href="<?php echo $url ?>" target="_blank">
				<?php $title = get_sub_field('banner_title');
				$wysiwyg = get_sub_field('banner_wysiwyg');
				$button = get_sub_field('banner_button_text');
				if ($title){ ?>
					<h2 class = "banner_title">
						<?php the_sub_field('banner_title'); ?>
					</h2>
				<?php }?>
				<?php if ($wysiwyg) {?>
					<div class = "banner_wysiwyg">
						<?php apply_filters('the_content',the_sub_field('banner_wysiwyg')); ?>
					</div>
				<?php } ?>
				<?php if ($button){ ?>
					<div class = "button banner_button">
						<?php the_sub_field('banner_button_text'); ?>
					</div>
				<?php } ?>
			</a>
		<?php }
		elseif( get_row_layout() == 'carousel' ) { ?> 
		<?php 
			if( get_sub_field('carousel_background_color') == 'none' ) {
				$bg_color = '';
			}
			else{
				$bg_color = get_sub_field('carousel_background_color');
			}
				?>
			<?php if (get_sub_field('carousel_button_link')){
			$url = get_sub_field('carousel_button_link');
			}?>
			<div class = "container carousel_container home_section padding <?php echo $bg_color ?>">
				<h2 class = "carousel_title"><?php the_sub_field('carousel_title'); ?>
				</h2>
				<div class = "carousel_carousel swiper">
					<div class = "swiper-wrapper">
					<?php foreach( get_sub_field('carousel_carousel') as $item) { ?>
								<div class = "carousel_item swiper-slide">
									<a href= "<?php echo get_permalink($item) ?>" class = "carousel_thumbnail">
										<?php echo get_the_post_thumbnail($item, 'medium'); ?>
									</a>
									<a href= "<?php echo get_permalink($item) ?>">
										<?php echo get_the_title($item); ?>
									</a>
									<h4 class = "carousel_writer bl_book_author">
										<?php echo get_the_term_list($item,'writer', '', ', ', ''); ?>
									</h4>
									<?php if (get_post_type($item)=='product') { ?>
										<div class= "carousel_price">
											<?php
											// $post_id = get_the_ID();
											$product = wc_get_product($item);
											echo $product->get_price_html();
											if ( ! $product->is_in_stock() ){
												echo '<p class="stock out-of-stock">Out of Stock</p>';
											}
											else {
												$checkout_url = wc_get_checkout_url(); ?>
												<a href="<?php echo $checkout_url; ?>" value="<?php echo $item; ?>" class="ajax_add_to_cart add_to_cart_button" data-product_id="<?php echo $item; ?>"> Add to Cart </a>
											<?php } ?>
										</div>
									<?php } ?>
								</div>
					<?php } ?> 
					</div>
					<div class="swiper-button-prev"></div>
  					<div class="swiper-button-next"></div>
				</div>
				<?php $button = get_sub_field('carousel_button_text'); ?>
				<?php if ($button) { ?>
					<a class = "button button_carousel <?php echo $bg_color ?>" href= "<?php echo $url ?>" >
						<?php the_sub_field('carousel_button_text'); ?>
						</a>
				<?php } else { ?>
					<div class= 'no_carousel_button'></div>
				<?php } ?>
			</div>
		<?php }
		elseif ( get_row_layout() == 'podcasts' ){ ?>
			<div class = "container podcasts_container home_section margins">
				<div class = "podcasts_relationship bl_podcast_container">
					<?php
					foreach( get_sub_field('podcasts_relationship') as $item) { ?>
									<div class = "podcasts_image_follow bl_podcast_image">
										<div class = "podcasts_thumbnail">
											<?php echo get_the_post_thumbnail($item, 'medium'); ?>
										</div>
										<div class = "podcasts_follow bl_follow_podcasts" >
											<div class = "bl_follow_link">
												<a href= "https://open.spotify.com/show/6GV73W6pdPUFj7ETr7Pm0K?si=eE1qvlCMT0a0-m3ReA9o2w" target="_blank">
													<img src="/wp-content/uploads/dynamik-gen/theme/images/spotify.svg">
													<p>Follow us on Spotify</p>
												</a>
											</div>
											<div class = "bl_follow_link">
												<a href= "https://podcasts.apple.com/za/podcast/a-readers-community-by-the-book-lounge/id1517595046" target="_blank">
													<img src="/wp-content/uploads/dynamik-gen/theme/images/applepodcasts.svg">
													<p>Follow us on Apple Podcasts</p>
												</a>
											</div>
										</div>
									</div>
									<div class = "podcasts_title_container bl_podcast_content">
											<h2 class = "podcasts_title">
												<a href='<?php echo site_url().'/podcasts/';?>'><?php echo the_sub_field('podcasts_title');?></a>
											</h2>
											<a class = "podcasts_episode_name" href= <?php echo get_permalink($item); ?>>
												<h3><?php echo get_the_title($item); ?>
												</h3>
											</a>
											<div class = "podcasts_description">
											<?php echo get_the_content(null,false,$item); ?>
										</div>
										<div class="bl_audio_player">
											<audio id="music" controls="controls">
												<source src="<?php echo get_field('add_podcast_audio',$item) ?>" type="audio/mpeg"  preload="metadata"/>
											</audio>
											<h4>Listen Now: <?php echo get_the_title($item); ?></h4>
											<div id="audioplayer">
												<button id="pButton" class="play" ></button>
												<div id="timeline">
													<div id="playhead"></div>
												</div>
											</div>
											<p class="small" id="podcast_duration"></p>
										</div>
									</div>
							<?php } ?> 
				</div>
				
			</div>
		 <?php }
		 elseif ( get_row_layout() == 'events' ){ ?>
			<div class = "container events_container home_section margins">
				<div class = "events_relationship">
					<?php
					foreach( get_sub_field('events_relationship') as $item) { ?>
								<div class = "featured_event bl_podcast_container">
									<div class = "events_thumbnail bl_podcast_image">
											<?php echo get_the_post_thumbnail($item, 'medium'); ?>
									</div>
									<div class = "event_content bl_podcast_content">
										<h2 class = "events_title"><?php echo the_sub_field('events_title');?>
										</h2>
										<a href= <?php echo get_permalink($item); ?>>
												<h3><?php echo get_the_title($item); ?>
												</h3>
										</a>
										<h4>
											<?php echo tribe_get_start_date($item,false,"F j, Y"); ?>
										</h4>
										<h5>
											<?php echo tribe_get_start_time($item); ?>
										</h5>
										<div class = "events_description">
												<?php echo get_the_content(null,false,$item); ?>
										</div>
									</div>
								</div> 
				<?php	} ?>
				</div>
			</div>
			<?php }
				 elseif ( get_row_layout() == 'generic_post' ){ ?>
					<div class = "container generic_post_container home_section margins">
					<?php $title = get_sub_field('generic_post_title'); ?>
						<div class = "generic_post_relationship">
							<?php
							foreach( get_sub_field('generic_post_relationship') as $item) { ?>
										<div class = "featured_generic_post bl_podcast_container">
											<div class = "generic_post_thumbnail bl_podcast_image">
													<?php echo get_the_post_thumbnail($item, 'medium'); ?>
											</div>
											<div class = "generic_post_content bl_podcast_content">
											<?php if ($title) { ?>
												<h2 class = "generic_post_title"><?php echo $title; ?>
												</h2>
												<?php } ?>
												<a href= <?php echo get_permalink($item); ?>>
														<h3><?php echo get_the_title($item); ?>
														</h3>
												</a>
												<div class = "generic_post_description">
														<?php echo get_the_content(null,false,$item); ?>
												</div>
											</div>
										</div> 
						<?php	} ?>
						</div>
					</div>
			<?php }
					elseif ( get_row_layout() == 'image_text_block' ){ ?>
						<div class = "container image_text_block_container home_section margins">
							<h2 class= "image_text_title"> <?php echo (get_sub_field('image_text_block_title'));?></h2>
							<?php $gallery = get_sub_field('image_text_block_gallery'); ?>
							<?php $count = count($gallery); ?>
								<div class = "image_gallery image_gallery_<?php echo $count?>">
									<?php foreach( $gallery as $item) { ?>
										<div class = "image_thumbnail">
											<?php echo wp_get_attachment_image($item, 'large'); ?>
										</div>
									<?php } ?>
								</div>
								<div class = "image_text_wysiwyg">
									<?php apply_filters('the_content',the_sub_field('image_text_block_wysiwyg')); ?>
								</div>
						</div>
					<?php }

		endwhile; ?>
		</div>
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->