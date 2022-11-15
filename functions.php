<?php
/**
 * Reclaimthecity functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Reclaimthecity
 */


if ( ! defined( 'RECLAIMTHECITY_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'RECLAIMTHECITY_VERSION', '1.0.0' );
}

if ( ! function_exists( 'reclaimthecity_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function reclaimthecity_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Reclaimthecity, use a find and replace
		 * to change 'aaa' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'aaa', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'aaa' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);	
		add_image_size( 'custom-thumb-3', 300 );
		update_option( 'medium_size_w', 300 );
		update_option( 'medium_size_h', 0 );
	}
endif;
add_action( 'after_setup_theme', 'reclaimthecity_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function reclaimthecity_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'reclaimthecity_content_width', 640 );
}
add_action( 'after_setup_theme', 'reclaimthecity_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function reclaimthecity_scripts() {
	wp_enqueue_style( 'reclaimthecity-style', get_stylesheet_uri(), array(), RECLAIMTHECITY_VERSION);
	wp_enqueue_script( 'reclaimthecity-navigation', get_template_directory_uri() . '/js/navigation.js', array(), RECLAIMTHECITY_VERSION, true );
	wp_enqueue_script( 'reclaimthecity-player', get_template_directory_uri() . '/js/player.js', array(), RECLAIMTHECITY_VERSION, true );
	wp_enqueue_script( 'reclaimthecity-filter', get_template_directory_uri() . '/js/filter.js', array(), RECLAIMTHECITY_VERSION, true );
	wp_enqueue_script( 'reclaimthecity-filter', get_template_directory_uri() . '/js/reclaimthecity.js', array(), RECLAIMTHECITY_VERSION, true );
	wp_enqueue_script( 'twitter', get_template_directory_uri() . '/js/twitter.js', array('jquery'),'1.0', true );

	if(is_page('shop')||is_archive()){
		wp_enqueue_script('infinite-scroll','/wp-content/themes/reclaimthecity/js/infinite-scroll.pkgd.min.js');
	}

	if(is_front_page()||is_singular('post')){
		wp_enqueue_script( 'reclaimthecity-audio', get_template_directory_uri() . '/js/audio.js', array(), RECLAIMTHECITY_VERSION, true );
	}
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/js/swiper-bundle.min.js', array(), RECLAIMTHECITY_VERSION, true );
	wp_enqueue_script( 'swiper-init', get_template_directory_uri() . '/js/swiper-init.js', array('swiper'), RECLAIMTHECITY_VERSION, true );
	wp_enqueue_style( 'swiper-style', get_template_directory_uri() . '/css/swiper-bundle.min.css', array(), RECLAIMTHECITY_VERSION);

}
add_action( 'wp_enqueue_scripts', 'reclaimthecity_scripts' );



/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Adding CPTs
 */
require get_template_directory() . '/inc/custom_post_types.php';

/**
 * Functions for Content Blocks
 */
require get_template_directory() . '/inc/get_blocks.php';


/**
  * REST API functions
  */

require get_template_directory() . '/inc/rest.php';

require get_template_directory() . '/inc/twitter.php';


/*Disable Gutenberg*/
add_filter('use_block_editor_for_post', '__return_false', 10);



function posts_link_attributes() {
    return 'class="next-post"';
}

add_filter('next_posts_link_attributes', 'posts_link_attributes');

/*Change values of the excerpt*/
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wpse_custom_wp_trim_excerpt');
function wpse_allowedtags() {
    // Add custom tags to this string
        return '<br>,<em>,<i>,<a>,<p>'; 
    }

if ( ! function_exists( 'wpse_custom_wp_trim_excerpt' ) ) : 

    function wpse_custom_wp_trim_excerpt($wpse_excerpt) {
    $raw_excerpt = $wpse_excerpt;
        if ( '' == $wpse_excerpt ) {

            $wpse_excerpt = get_the_content('');
            $wpse_excerpt = strip_shortcodes( $wpse_excerpt );
            $wpse_excerpt = apply_filters('the_content', $wpse_excerpt);
            $wpse_excerpt = str_replace(']]>', ']]&gt;', $wpse_excerpt);
            $wpse_excerpt = strip_tags($wpse_excerpt, wpse_allowedtags()); /*IF you need to allow just certain tags. Delete if all tags are allowed */

            //Set the excerpt word count and only break after sentence is complete.
                $excerpt_word_count = 40;
                $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
                $tokens = array();
                $excerptOutput = '';
                $count = 0;

                // Divide the string into tokens; HTML tags, or words, followed by any whitespace
                preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $wpse_excerpt, $tokens);

                foreach ($tokens[0] as $token) { 

                    if ($count >= $excerpt_length && preg_match('/[\?\.\!]\s*$/uS', $token)) { 
                    // Limit reached, continue until , ; ? . or ! occur at the end
                        $excerptOutput .= trim($token);
                        break;
                    }

                    // Add words to complete sentence
                    $count++;

                    // Append what's left of the token
                    $excerptOutput .= $token;
                }

            $wpse_excerpt = trim(force_balance_tags($excerptOutput));
			if ($count >= $excerpt_length){
				if ( get_post_type( get_the_ID() ) == 'tribe_events' ) {
     $excerpt_end = ' <a href="'. esc_url( get_permalink() ) . '">'  . sprintf(__( 'See the invite to %s', 'wpse' ), get_the_title()) . '</a>';
				}
				else{
                $excerpt_end = ' <a href="'. esc_url( get_permalink() ) . '">' . sprintf(__( 'Read more about %s', 'wpse' ), get_the_title()) . '</a>'; 
				}
                $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end); 

                //$pos = strrpos($wpse_excerpt, '</');
                //if ($pos !== false)
                // Inside last HTML tag
                //$wpse_excerpt = substr_replace($wpse_excerpt, $excerpt_end, $pos, 0); /* Add read more next to last word */
                //else
                // After the content
                $wpse_excerpt .= $excerpt_more; /*Add read more in new paragraph */}

            return $wpse_excerpt;   

        }
        return apply_filters('wpse_custom_wp_trim_excerpt', $wpse_excerpt, $raw_excerpt);
    }

endif; 


/*removing global styles and svg noise introduced in 5.9*/
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );


/*Disabling comments*/
add_action( 'admin_menu', 'boathouse_remove_admin_menus' );
function boathouse_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
}
// Removes from post and pages
add_action('init', 'remove_comment_support', 100);

function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}

function boathouse_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'boathouse_admin_bar_render' );


/*removing paged redirect*/
add_filter( 'redirect_canonical', 'remove_paged_redirect', 10 );
function remove_paged_redirect( $redirect_url ) {
    if ( is_paged() ) {
        return '';
    }
 
    return $redirect_url;
}

/**
 *  Enable Options Page for ACF
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Site Options',
		'menu_title'	=> 'Site Options',
		'menu_slug' 	=> 'site_options',
		'capability'	=> 'activate_plugins',
		'position'		=> '9',
		'redirect'		=> false,
	));
}

/*removing content editor*/
add_action( 'admin_init', 'hide_editor' );
function hide_editor() {
  $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
  if( !isset( $post_id ) ) return;
  $post_type = get_post_type($post_id);
  if($post_type == 'page'|| $post_type=='collection'){
    remove_post_type_support('page', 'editor');
  }
}

add_action( 'pre_get_posts', 'custom_post_type_archive' );

function custom_post_type_archive( $query ) {

	if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'statement' ) ) {

		$query->set( 'meta_key', 'date_of_statement' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'DESC' );
	}
	if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'podcast' ) ) {

		$query->set( 'meta_key', 'date_of_podcast' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'DESC' );
	}
}
