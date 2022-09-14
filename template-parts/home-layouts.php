<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Booklounge
 */

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('home no-max'); ?>>
		<?php
		//var_dump(get_field('layouts'));
		if( have_rows('layouts') ): ?>
			<div class="layouts">
				<?php while( have_rows('layouts') ): the_row(); ?>
				<?php
					if ( get_row_layout()=='hero_image'): ?>
					<div class = "hero_image_container">
						<?php if(get_sub_field('hero_image_title')): ?>
							<h2 class = "hero_title title"><?php echo get_sub_field('hero_image_title'); ?></h2>
						<?php endif; ?>
						<div class = "hero_image_carousel swiper">
							<div class = "swiper-wrapper">
								<?php foreach( get_sub_field('hero_image_carousel') as $item) { ?>
											<div class = "hero_carousel_item swiper-slide">
												<div class = "hero_carousel_thumbnail">
													<?php echo wp_get_attachment_image($item, 'large'); ?>
												</div>
												<p class = "hero_carousel_title"><?php echo get_the_title($item); ?></p>
											</div>
								<?php } ?> 
							</div>
							<div class="swiper-button-prev"></div>
							<div class="swiper-button-next"></div>
						</div>
					</div>

					<?php elseif ( get_row_layout()=='text_block'): ?>
						<?php if(get_sub_field('text_block_column_count') == 'one'){ 
							$column = 'one_column';
						} else $column = 'two_column';?>
						<div class = "text_block_container margins <?php echo $column; ?>">
							<?php if(get_sub_field('text_block_title')): ?>
								<h2 class = "text_block_title title"><?php echo get_sub_field('text_block_title'); ?></h2>
							<?php endif; ?>
							<div class = "text_block_wysiwyg">
								<?php apply_filters('the_content',the_sub_field('text_block_wysiwyg')); ?> 
							</div>
						</div>

					<?php elseif ( get_row_layout()=='donate_block'): ?>
							<div class = "donate_block_container margins">
								<?php if(get_sub_field('donate_block_heading_text')): ?>
									<h3 class = "donate_heading title black"><?php echo get_sub_field('donate_block_heading_text'); ?></h3>
								<?php endif; ?>
								<div class = "donate_button button">
									<a href = "<?php echo get_sub_field('donate_block_button_url');?>">
										<?php echo get_sub_field('donate_block_button_text');?>
									</a>
								</div>
								<div class = 'donate_block_follow'>
									<h3 class = 'donate_block_follow_heading title red'>
										<?php echo get_sub_field('donate_block_follow_heading');?>
									</h3>
									<div class = 'social_media_block'>
										<?php get_social_buttons(); ?>
									</div>
								</div>
							</div>

					<?php elseif ( get_row_layout()=='social_media_block'): ?>
						<?php $feed = (get_sub_field('social_media_feed'));?>
							<div class = "social_media_feed margins <?php echo $feed;?>">
								<?php if(get_sub_field('social_media_title')): ?>
									<h2 class = "social_media_title title"><?php echo get_sub_field('social_media_title'); ?></h2>
								<?php endif; ?>
							<div class="embed-container">
								<?php if ($feed =='twitter'):?>
									<div class="rtc_container--twitter margins" id="twitter">
									<?php
										rtc_twitter();
									?>
									</div>

								<?php elseif ($feed =='instagram'):?>
									<div class="rtc_container--instagram margins" id="instagram">
												<?php echo do_shortcode('[instagram-feed feed=1]'); ?>
									</div>
								<?php endif;?>
							</div>
						</div>

					<?php elseif ( get_row_layout()=='partners_block'): ?>
						<div class = "partners_block margins">
							<?php if(get_sub_field('partners_title')): ?>
								<h2 class = "partners_title title"><?php echo get_sub_field('partners_title'); ?></h2>
							<?php endif; ?>
							<?php if(get_sub_field('partners_wysiwyg')): ?>
								<?php apply_filters('the_content',the_sub_field('partners_wysiwyg')); ?> 
							<?php endif; ?>
							<div class = 'partners_logos'>
								<?php if( have_rows('partner_logo_repeater')):?>
									<?php while( have_rows('partner_logo_repeater')): the_row();?>
										<a href="<?php echo get_sub_field('partner_url'); ?>" target="_blank">
											<span class="screen-reader-text"><?php echo get_sub_field('partner_name'); ?></span>
											<?php echo wp_get_attachment_image(get_sub_field('partner_logo'),'medium'); ?>
										</a>
									<?php endwhile;
								endif; ?>	
							</div>
						</div>
					

				<?php endif;?>
		<?php endwhile; ?>
		</div>
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->