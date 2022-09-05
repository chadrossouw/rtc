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
		the_content();
		if(have_rows('faqs')){ ?>
			<div class="faqs">
				<?php while(have_rows('faqs')){
					the_row(); ?>
						<details>
							<summary>
								<span class="summary-title"><?php echo get_sub_field('question') ?></span>
								<div class="arrow_up">
									<?php echo file_get_contents(get_template_directory() . '/assets/detail_arrow.svg'); ?>
								</div>
							</summary>
							<div class="details-text">
								<div class="details-text--inner">
									<?php echo apply_filters('the_content',get_sub_field('answer')); ?>
								</div>
							</div>
						</details>
				<?php } ?>
			</div>
		<?php }
		?>
	</div><!-- .entry-content -->
	<?php if(is_page('library-project')){ ?>
		<div class="bl_content_right">
			<a href="/product/library-project-donation/"><img class="bl_kids_sidebar" src="/wp-content/uploads/dynamik-gen/theme/images/BL_librarydonate.png"></a>
			<h2 class="bl_kids_sidebar"><a href="/contact-us">contact us</a></h2>
		</div>
	<?php } ?>
	<?php if(is_page('storytime')){ ?>
		<div class="bl_content_right">
			<h3 class="bl_kids_sidebar">to find out about this week's storytime</h3>
			<h2 class="bl_kids_sidebar"><a href="/contact-us">contact us</a></h2>
		</div>
	<?php } ?>

</article><!-- #post-<?php the_ID(); ?> -->
