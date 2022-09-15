<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Reclaimthecity
 */

?>

	<footer id="colophon" class="site-footer">
	<div class="bl_footer margins" itemscope itemtype="http://schema.org/LocalBusiness">
		<div class="rtc_logo">
			<a href="/"><img src="/wp-content/themes/reclaimthecity/assets/rtc_logo.svg"></a>
		</div>
		<div class="footer_contact_copyright">
			<?php $email = get_field('contact_email_address','option'); ?>
			<?php $copyright = get_field('copyright_notice','option'); ?>
			<div class = "footer_contact">
				<a href="mailto:<?php $email; ?>"><?php echo $email;?></a>
			</div>
			<div class = "footer_copyright">
				<p><?php echo $copyright;?></p>
			</div>
		</div>
		<div class = 'social_media_block'>
			<?php get_footer_social_buttons(); ?>
		</div>
		<div class = 'blackman_rossouw_block'>
			<p>Design by</p>
			<a href = "https://blackmanrossouw.co.za/" target = "_blank">Blackman Rossouw</a>
		</div>
	</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
