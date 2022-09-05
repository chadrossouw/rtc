<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Reclaimthecity
 */
$cat = $args['slug'];
$sub_cat = get_query_var('bl_sub_cat')?json_decode(urldecode(get_query_var('bl_sub_cat'))):false;
$order = get_query_var('bl_sort')?get_query_var('bl_sort'):'date';
$paged = get_query_var('paged')?get_query_var('paged'):1;
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('no-max'); ?>>
		<div class="padding shop-header <?php echo $args['bg']; ?>">
			<h2 class = "shop_category_title">Shop: <?php echo $args['title']; ?></h2>
			<div id="filter" data-cat="<?php echo $cat; ?>">
				<?php get_filters($cat); ?>
			</div>
		</div>
		<div id="loader"></div>
		<div id="response" class = "margins">
		<?php 
			echo get_shop_grid($cat,$sub_cat,$order,$paged);
		?>
		</div>
</article><!-- #post-<?php the_ID(); ?> -->