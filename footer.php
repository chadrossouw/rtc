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
	<div class="bl_footer <?php if(!is_front_page()){echo 'bl_footer_border';} ?>" itemscope itemtype="http://schema.org/LocalBusiness"><div class="bl_flourish"></div><div class="bl_info">
	<p>Follow us on social media:</p>
	<p><a itemprop="sameAs" href="https://www.facebook.com/Reclaimthecity">Facebook</a></p>
	<p><a itemprop="sameAs" href="https://www.instagram.com/reclaimthecity/">Instagram</a></p>
	<p><a itemprop="sameAs" href="https://twitter.com/book_lounge">Twitter</a></p>
	</div>
	<div class="bl_info" itemprop="openingHours">
	<p>Monday - Friday 09h00 - 18h00</p>
	<p>Saturday 09h00 - 16h00</p>
	<p>Sunday 10h00 to 16h00</p>
	<meta itemprop="openingHours" content="Mo-Fr 09:00-18:00">
	<meta itemprop="openingHours" content="Sa 09:00-16:00">
	<meta itemprop="openingHours" content="Su10:00-16:00">
    </div>
    <div class="bl_info"><div itemprop="telephone"><p><a href="tel:+27214622425">021 462 2425</a></p></div>
    <div itemprop="telephone"><p><a href="https://wa.me/27639616154">Whatsapp: 063 961 6154</a></p></div>
    <div itemprop="address"><p><a href="https://www.google.com/maps/place/The+Book+Lounge/@-33.9292132,18.4215373,21z/data=!4m8!1m2!3m1!2sThe+Book+Lounge!3m4!1s0x1dcc677b8002af1d:0x57e3eace1f53602f!8m2!3d-33.9292058!4d18.4216261">71 Roeland Street</p><p>Cape Town</p></a></div>
	</div>
	<div class="bl_flourish"></div></div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
