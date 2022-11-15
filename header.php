<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Reclaimthecity
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Londrina+Solid:wght@300;400&display=swap" rel="stylesheet"> 
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-KCJ6R3PF84"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-KCJ6R3PF84');
</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'aaa' ); ?></a>

	<header id="masthead" class="site-header home_section">
		
		<div class="site-branding">
		<div class='bl_header'><a href="/"><img src="/wp-content/themes/reclaimthecity/assets/rtc_logo.svg" class="bl_header_image"></a></div>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="hamburger hamburger--squeeze" type="button" id="hamburger" aria-controls="primary-menu" aria-expanded="false">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</button>
			<div class = "menu_search_container">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
				<!-- #site-navigation -->
			</div>
		</nav>

		
	</header><!-- #masthead -->
	<div id="sticky-header-jump-fix"></div>