<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Reclaimthecity
 */

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('shop no-max'); ?>>
		<?php
		//get_product_title();
		$banners = array();
		//var_dump(get_field('layouts'));
		if( have_rows('layouts') ): ?>
		<?php while( have_rows('layouts') ): the_row(); ?>
		<?php
		if ( get_row_layout()=='banner' ){
			$wysiwyg = get_sub_field('banner_wysiwyg');
			$banner_id = strtolower(str_replace('%','',str_replace('+','_',urlencode(trim(get_sub_field('banner_title'))))));
			$image_mobile = wp_get_attachment_url(get_sub_field('banner_background_image_mobile'));
			$image_desktop = wp_get_attachment_url(get_sub_field('banner_background_image'));
			$output='';
			if ($image_mobile && $image_desktop) {
				$bg_m_style = 'background-image: url('. $image_mobile .')';
				$bg_d_style = 'background-image: url('. $image_desktop .')';
				$output.='
				<style>
					#'.$banner_id.'{
						'.$bg_m_style.'
					}
					@media screen and (min-width:700px) {
						#'.$banner_id.'{
						'.$bg_d_style.'
						}
					}
				</style>';
			} 
			elseif($image_mobile||$image_desktop){
				$image = $image_mobile?$image_mobile:$image_desktop;
				$bg_d_style = 'background-image: url('. $image .')';
				$output.='
				<style>
					#'.$banner_id.'{
						'. $bg_d_style.'
					}
				</style>';
			}
			?>

			<?php 
			if( get_sub_field('background_color') == 'none' ) {
				$bg_color = '';
			}
			else{
				$bg_color = get_sub_field('background_color');
			}
				?>
			<?php if (get_sub_field('banner_internal_link')){
			$url = get_permalink(get_sub_field('banner_internal_link')[0]);
			
			}
			else{
			$url = get_sub_field('banner_external_link');
			} 
			$output.= '<div id="'.$banner_id.'" class="shop_container container banner_container padding '. $bg_color .'">';
				$output.='<div class = "shop_banner_content"><a href="'.$url.'" target="_blank"><h2 class = "banner_title">'.get_sub_field('banner_title').'</h2></a>';
				if($wysiwyg){
					$output.='<div class = "banner_wysiwyg">'. $wysiwyg .'</div> </div>';
				}
				else{
					$output.='</div>';
				}
				$output.='<a href="'.$url.'" target="_blank"  class = "button_container">';
				if(isset(get_sub_field('banner_internal_link')[0])){
						$output.='<div class = "button banner_book_cover">'.get_the_post_thumbnail(get_sub_field('banner_internal_link')[0]).'</div>';
				}
				else{
					$output.='<div class = "button banner_button">'.get_sub_field('banner_button_text').'</div>';
					 }
				$output.='</a></div>';
				$position = get_sub_field('banner_position');
				$banner = array(
					'position'=>$position, 
					'content'=>$output
				);
				$banners[]=$banner;
		}
		

		endwhile; ?>
		</div>
	<?php endif; ?>
	<div class="layouts">
	<?php
	foreach($banners as $banner){
		if($banner['position']==0){
			echo $banner['content'];
		}
	}
	$terms = get_terms( array(
		'taxonomy' => 'product_cat',
		'hide_empty' => false,
		'parent'   => 0,
		'meta_key' => 'ordering',
		'orderby' => 'meta_value_num',
	) );
	$count = 1;
	foreach( $terms as $term){
			$image_mobile='';
			$image_desktop='';
			$image='';
			$term_id = $term->term_id;
			$term_name = $term->name;
			$term_slug = $term->slug;
			$bg = get_field('background_color',$term);
			$thumbnails = get_field('remove_book_thumbnails', $term);
			$text = '';
			$image_mobile = wp_get_attachment_url(get_field('background_image_mobile', $term));
			$image_desktop = wp_get_attachment_url(get_field('background_image', $term));
			if ($image_mobile && $image_desktop) {
				$text = get_field('dark_light_text',$term);
				$bg_m_style = 'background-image: url('. $image_mobile .')';
				$bg_d_style = 'background-image: url('. $image_desktop .')';
				?>
				<style>
					<?php echo '#'.$term_slug; ?>{
						<?php echo $bg_m_style; ?>
					}
					@media screen and (min-width:700px) {
						<?php echo '#'.$term_slug; ?>{
						<?php echo $bg_d_style; ?>
						}
					}
				</style>
				<?php 
			} 
			elseif($image_mobile||$image_desktop){
				$image = $image_mobile?$image_mobile:$image_desktop;
				$text = get_field('dark_light_text',$term);
				$bg_d_style = 'background-image: url('. $image .')';
				?>
				<style>
					<?php echo '#'.$term_slug; ?>{
						<?php echo $bg_d_style; ?>
					}
				</style>
				<?php 
			}
			?>


			<a href = "/shop/list/<?php echo $term_slug; ?>" id="<?php echo $term_slug; ?>" class = "shop_category padding <?php echo $text.' '; echo $count%2==0?'even':'odd'; echo $bg?' '.$bg:' yellow'; echo $thumbnails?' centered_shop':''; ?>">
				<h2 class = "shop_category_title">
					<?php echo $term_name ?>
					
				</h2>
				<?php if (!$thumbnails){?>
				<div class = "shop_category_recent">
					<?php 
					$args = array(
						'numberposts' => 3,
						'orderby'=> 'date',
						'order' => 'DESC',
						'post_type'=> 'product',
						'post_status' => 'publish',
						'tax_query' => array(
							array(
								'taxonomy' => 'product_cat',
								'field'=> 'slug',
								'terms' => $term_slug,
							)
						)
					);
					$recents = get_posts( $args );
					foreach($recents as $recent){
						echo get_the_post_thumbnail($recent->ID, 'medium');
					}
					?>

				</div>
				<?php } ?>
			</a>

	<?php
	foreach($banners as $banner){
		if($banner['position']==$count){
			echo $banner['content'];
		}
	} 
	$count++;
	} ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->