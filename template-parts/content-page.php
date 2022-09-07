<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Reclaimthecity
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('margins'); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<?php if(has_post_thumbnail()){ ?>
		<div class="bl_content_left">
			<div class="bl_featured_image">
				<?php echo the_post_thumbnail( 'medium'); ?>
			</div>
		</div>
	<?php } ?>

	<div class="entry-content">
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
								<?php var_dump(get_sub_field('social_media_feed_test'));?>
    							<?php get_sub_field('social_media_feed_test'); ?>
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

					<?php if ( get_row_layout()=='image_carousel'): ?>
						<div class = "carousel_container">
							<?php if(get_sub_field('carousel_title')): ?>
								<h2 class = "carousel_title title"><?php echo get_sub_field('carousel_title'); ?></h2>
							<?php endif; ?>
							<div class = "general_carousel swiper">
								<div class = "swiper-wrapper">
									<?php foreach( get_sub_field('carousel_gallery') as $item) { ?>
												<div class = "carousel_item swiper-slide">
													<div class = "carousel_thumbnail">
														<?php echo wp_get_attachment_image($item, 'large'); ?>
													</div>
													<p class = "carousel_item_title"><?php echo get_the_title($item); ?></p>
												</div>
									<?php } ?> 
								</div>
								<div class="swiper-button-prev"></div>
								<div class="swiper-button-next"></div>
							</div>
						</div>
					<?php endif; ?>

				<?php if ( get_row_layout()=='contact_form'): ?>
					<?php if(get_sub_field('enable_contact_form')):?>
						<div class ='contact_forms'>
							<?php echo do_shortcode('[contact-form-7 id="182" title="Contact form 1"]'); ?>
						</div>
					<?php endif; ?>
				<?php endif;?>

		<?php endwhile; ?>
		</div>
	<?php endif; ?>

	<?php
		if( have_rows('our_campaigns_repeater') ): ?>
			<div class="layouts">
				<?php while( have_rows('our_campaigns_repeater') ): the_row(); ?>
						<div class = "our_campaigns_container margins">
							<details>
								<summary>
									<h2 class = "campaign_title title"><?php echo get_sub_field('campaign_title'); ?></h2>
								</summary>
								<div class = "details_content">
									<?php $image = get_sub_field('campaign_image');?>
									<?php $size = 'full';?>
									<?php	if( $image ): ?>
										<?php echo wp_get_attachment_image( $image, $size );?>
										<?php endif;?>
									<?php if(get_sub_field('campaign_wysiwyg')): ?>
										<div class = 'campaign_wysiwyg'>
											<?php apply_filters('the_content',the_sub_field('campaign_wysiwyg')); ?> 
										</div>
									<?php endif; ?>
									<?php if(get_sub_field('campaign_gallery')): ?>
										<div class = 'campaign_gallery'>
											<?php if(get_sub_field('campaign_gallery_title')):?>
												<h2 class = "campaign_gallery_title title"><?php echo get_sub_field('campaign_gallery_title'); ?></h2>
											<?php endif; ?>
											<div class = "campsign_carousel swiper">
												<div class = "swiper-wrapper">
													<?php foreach( get_sub_field('campaign_gallery') as $item) { ?>
																<div class = "campaign_carousel_item swiper-slide">
																	<div class = "campaign_carousel_thumbnail">
																		<?php echo wp_get_attachment_image($item, 'large'); ?>
																	</div>
																	<p class = "campaign_carousel_title"><?php echo get_the_title($item); ?></p>
																</div>
													<?php } ?> 
												</div>
												<div class="swiper-button-prev"></div>
												<div class="swiper-button-next"></div>
											</div>

										</div>
									<?php endif; ?>
									<?php if(get_sub_field('campaign_video_embed')): ?>
										<div class = 'campaign_video'>
										<?php if(get_sub_field('campaign_video_title')):?>
												<h2 class = "campaign_video_title title"><?php echo get_sub_field('campaign_video_title'); ?></h2>
											<?php endif; ?>
											<div class="embed-container">
												<?php the_sub_field('campaign_video_embed'); ?>
											</div>
										</div>
									<?php endif;?>
							</details>
						</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>	
		
		<?php
/* Our Movement Child Pages*/
			$child_pages = get_pages(
				array(
				'parent' => get_the_ID(),
				'sort_column' => 'menu_order'
				)
			);
			foreach ($child_pages as $child){ ?>
				<div class = 'our_movement_title'>
					<h2 class = 'title'> <?php echo $child->post_title;?> </h2>
				</div>
				<div class = 'our_movement_wysiwyg'>
					<?php the_field('our_movement_wysiwyg', $child); ?>
				</div>
				<div class = 'our_movement_grandchild_list'>

					<?php	$grandchild_pages = get_pages(
							array(
							'parent' => $child->ID,
							'sort_column' => 'menu_order'
							)
						);
						foreach($grandchild_pages as $grandchild){
							$url = get_permalink($grandchild); ?>
							<a href = <?php echo $url;?>><?php echo $grandchild->post_title;?></a>
						<?php } ?>
				</div> 
			<?php } ?>

			<?php
				if( have_rows('our_movement_layouts') ): ?>
					<div class="layouts">
						<?php while( have_rows('our_movement_layouts') ): the_row(); ?>
							<div class = "our_movements_container margins">
							<?php $image = get_sub_field('our_movement_hc_image');?>
								<?php $size = 'full';?>
								<?php	if( $image ): ?>
									<?php echo wp_get_attachment_image( $image, $size );?>
									<?php endif;?>
							<?php if(get_sub_field('our_movement_hc_wysiwyg')): ?>
								<div class = 'our_movement_hc_wysiwyg'>
									<?php apply_filters('the_content',the_sub_field('our_movement_hc_wysiwyg')); ?> 
								</div>
								<?php endif;?>
								<?php if( have_rows('our_movement_hc_quote') ): ?>
    								<?php while( have_rows('our_movement_hc_quote') ): the_row(); ?>
										<?php $title = get_sub_field('our_movement_quote_title'); ?>
										<?php $quote = get_sub_field('our_movement_quote_quote'); ?>
										<?php $source = get_sub_field('our_movement_quote_name'); ?>
										<?php $info = get_sub_field('our_movement_quote_info'); ?>
								<div class= 'hc_quote_block quote'>
									<?php if($title): ?>
										<h5 class = 'hc_quote_title'> <?php echo ($title);?></h5>
									<?php endif;?>
									<?php if($quote): ?>
										<p class = 'hc_quote italic'> <?php echo ($quote);?></p>
									<?php endif;?>
									<div class = 'hc_quote_source_info'>
										<?php if($source): ?>
											<p class = 'hc_quote_source'> <strong><?php echo ($source);?></strong></p>
										<?php endif;?>
										<?php if($info): ?>
											<p class = 'hc_quote_info'> <?php echo ($info);?></p>
										<?php endif;?>
									</div>
								<?php endwhile; ?>
							<?php endif; ?>
						<?php endwhile; ?>
				<?php endif; ?>
				<?php

				if( have_rows('resources_layouts') ): ?>
					<?php while( have_rows('resources_layouts') ): the_row(); ?>
						<div class = "resources_container">
							<div class = 'resources_wysiwyg'>
								<?php apply_filters('the_content',the_sub_field('resources_wysiwyg')); ?> 
							</div>
							<?php if( have_rows('resource_repeater') ):
								while( have_rows('resource_repeater') ) : the_row();?>
								<details>
									<summary>
										<?php $title =  get_sub_field('resource_repeater_title');?>
										<h2 class = 'resource_title title'><?php echo $title;?></h2>
									</summary>
										<div class = 'resource_description_wysiwyg margins'>
											<?php apply_filters('the_content', the_sub_field('resource_repeater_wysiwyg')); ?>
												<?php if(have_rows('resources_file_repeater')):?>
													<div class = 'downloadable files'>
														<?php while(have_rows('resources_file_repeater')) : the_row();?>
															<?php 
																$file = get_sub_field('resource_file');
																$name = get_sub_field('resource_file_name');
																	if( $file ): ?>
																		<a href="<?php echo $file['url']; ?>"target="_blank" download><?php echo $name; ?></a>
																	<?php endif; ?>
														<?php endwhile; ?>
																	</div>
												<?php endif; ?>
										</div>
									</details>
								<?php endwhile; ?>
							<?php endif;?>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>




	</div><!-- .entry-content -->
	

</article><!-- #post-<?php the_ID(); ?> -->
