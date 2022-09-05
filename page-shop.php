<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Reclaimthecity
 */

$merch_var=get_query_var('list');
$term_name = '';
$bg = '';
if($merch_var){
	$term = get_term_by('slug',$merch_var,'product_cat');
	$term_name = $term->name;
    add_filter('document_title',function($title) use ($term_name){
        
        return $term_name.' – '.$title;
    });
	$bg = get_field('background_color',$term);
}

get_header();
?>

	<main id="primary" class="site-main">
		<?php if(!$merch_var): ?>
			<h2 class = "shop_title margins">Shop</h2>
		<?php endif; ?>
		<?php
		while ( have_posts() ) :
			the_post();
			if($merch_var){
				get_template_part( 'template-parts/shop', 'list',array('slug'=>$merch_var,'title'=>$term_name,'bg'=>$bg) );
			}
			else{
				get_template_part( 'template-parts/shop', 'layouts' );
			}


		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
