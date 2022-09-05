<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Reclaimthecity
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header margins">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'aaa' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			
			<div class="margins bl_book_list"><?php
	// Check if there are any posts to display
	// The Loop
	$count = 0;
	while ( have_posts() ) : the_post(); $count++; ?>
	<?php $post_id = get_the_ID(); ?>
		<div class="bl_book_container">
			<?php if(get_post_type()!='product'){ ?>
					<a class="post-image-link" href="<?php echo get_permalink($post_id); ?>">
						<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
						echo get_the_post_thumbnail($post_id, 'custom-thumb-3');
						}
						elseif(in_category('podcasts')){
						echo "<img width='300' src='/wp-content/uploads/dynamik-gen/theme/images/Podcastdefault.jpg'>";
						}
					?></a>
						<div class="bl_book_category">
							Blog Post:
							<?php if(the_category($post_id)){?>
								<h5 class="bl_book_cats"><?php the_category(',','',$post_id); ?></h5>
							<?php } 
							?>
						</div>       
						<h3 class="bl_book_title" itemprop="headline">
							<a href="<?php echo get_permalink($post_id); ?>" title="<?php echo get_the_title(); ?>" rel="bookmark"><?php echo get_the_title(); ?></a>
						</h2> 
						<?php if( get_the_term_list( $post_id, 'writer' ) ){?>
							<h4 class="bl_book_author"><?php echo get_the_term_list( $post_id, 'writer','',', ' ); ?></h4>
							<?php 
							}
							$staffmember=get_the_term_list($post_id,'staff-member','',' & ' );
							if ($staffmember){ ?>
								<div class="bl_tiny_text">Recommended by <?php echo $staffmember; ?></div>
								<?php
								}
				 		
		 }
		else{ ?>
			<a href="<?php the_permalink(); ?>" class = "bl_book_cat">
			<?php  echo get_the_post_thumbnail(get_the_ID(), 'custom-thumb-3'); ?>
			</a>
			<div class = "bl_book_category">
			</div>
			<h3 class = "bl_book_title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?>
			</a>
			</h3>
			<h4 class = "bl_book_author">
			<?php echo get_the_term_list(get_the_ID(),'writer', '', ',', ''); ?>
			</h4>
			<div class= "bl_book_price">
			<?php
			$product = wc_get_product();
			echo $product->get_price_html();
			if ( !$product->is_in_stock() ){
				echo '<p class="stock out-of-stock">Out of Stock</p>';
			}
			else {
				$checkout_url = wc_get_checkout_url(); ?>
				<a href="<?php echo $checkout_url; ?>" value="<?php echo get_the_ID(); ?>" class="ajax_add_to_cart add_to_cart_button" data-product_id="<?php echo get_the_ID(); ?>"> Add to Cart </a>
				<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
			<?php } ?>
			</div>
		<?php }?>
	</div>
	<?php
	endwhile; ?>
	<div class="bl_book_container"></div>
	<div class="bl_book_container"></div>
	<div class="bl_book_container"></div>
	<?php 
	$big = 999999999;
	global $wp_query;
	$paginate = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'total'        => $wp_query->max_num_pages,
            'current'      => max( 1, $paged),
            'format'       => '?paged=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 5,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => '<span class="screen-reader-text">Previous Page</span><',
            'next_text'    => '<span class="screen-reader-text">Next Page</span>>',
            'add_args'     => false,
            'add_fragment' => '',
        ) );
        echo '<div class="pagination">'.$paginate.'</div>'; ?>
</div>
<?php endif; ?>
	</main><!-- #main -->

<?php
get_footer();
