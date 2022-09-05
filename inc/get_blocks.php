<?php function get_shop_grid($cat,$sub_cat=false,$order='date',$paged=1){  

    $args = array(
    'post_type' => 'product',
    'posts_per_page' => 16,
    'paged'=>$paged,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $cat,
            ),
        ),
    );
    if($sub_cat=='reset'){
        $sub_cat=false;
    }
    if(is_array($sub_cat)){
        $args['tax_query']['relationship']='AND';
        foreach($sub_cat as $cat){
            $args['tax_query'][]=array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $cat,
            );
        }
    }
    if($order == 'date'){
        $args['orderby']=$order;
    }
    elseif($order == 'title'){
        $args['orderby'] = 'title';
        $args['order'] = 'ASC';
    }
    elseif($order == 'author'){
        $args['order'] = 'ASC';
        $args['meta_key'] = 'writer_surname';
        $args['orderby'] = 'meta_value';
    }

    $cat_title = get_term_by('slug',$cat, 'product_cat');
    $sub_cat_title = '';
    if($sub_cat){
        foreach($sub_cat as $cat){
            $sub_cat_title .= '<div class="filter_button filtering active">'.get_term_by('slug',$cat,'product_cat')->name.'</div>';
        }
    }
    $query = new WP_Query($args);
    ob_start();
    if( $query->have_posts() ){ ?>
        <div class="filter-header">
            You are looking at  <?php echo $cat_title->name; ?> 
            <?php if($sub_cat){ ?>
            filtered by <?php echo $sub_cat_title; ?> and
            <?php } ?>
            sorted by <div class="filter_button sorting active"><?php echo $order=='date'?'Recent':ucfirst($order); ?></div>
        </div>
        <?php while( $query->have_posts()) { 
            $query->the_post();  ?>
            <div class = "bl_book_container">
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
                        echo do_shortcode('[yith_wcwl_add_to_wishlist]'); 
                    }
                    else {
                        $checkout_url = wc_get_checkout_url(); ?>
                        <a href="<?php echo $checkout_url; ?>" value="<?php echo get_the_ID(); ?>" class="ajax_add_to_cart add_to_cart_button" data-product_id="<?php echo get_the_ID(); ?>"> Add to Cart </a>
                        <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="bl_book_container empty"></div>
        <div class="bl_book_container empty"></div>
        <div class="bl_book_container empty"></div>
        <?php
        $url = site_url().'/shop/list/'.$cat.'/%_%';
        $paginate = paginate_links( array(
            'base'         => $url,
            'total'        => $query->max_num_pages,
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
        echo '<div class="pagination">'.$paginate.'</div>';
    }
    else{?>
        <h2><?php echo 'Category Not found' ?></h2>
   <?php  }
    $output = ob_get_clean();
    return $output;
     wp_reset_postdata() ; 
}

function get_filters($slug){
    $parent = get_term_by('slug',$slug,'product_cat');
    $parent=$parent->term_id;
    $terms = get_terms(array(
        'taxonomy'=>'product_cat',
        'parent'=>$parent,
    ));
    if(is_array($terms) && count($terms)>0){ ?>
        <div class="filter filter--filters">
            <h3>Show me</h3>
            <?php foreach($terms as $term){ ?>
                <button class="filter_button filtering" data-slug="<?php echo $term->slug; ?>"><span class="screen-reader-text">Filter by</span><?php echo $term->name; ?></button>
            <?php } ?>
            <button class="reset filtering active" data-slug="reset">Clear Filters</button>
        </div>
    <?php } ?>
    <div class="filter filter--sort">
        <h3>Sort by</h3>
        <button class="filter_button sorting active" data-sort="recent">Recent</button>
        <button class="filter_button sorting" data-sort="author">Author</button>
        <button class="filter_button sorting" data-sort="title">Title</button>
    </div>
<?php }

function bl_related(){
    global $post;
    if(get_field('related_books')): ?>
        <h2>You might be interested in</h2>
        <div class="bl_book_list">
           <?php foreach(get_field('related_books') as $id): ?>
            <div class = "bl_book_container">
                <a href="<?php the_permalink($id); ?>" class = "bl_book_cat">
                    <?php  echo get_the_post_thumbnail($id, 'custom-thumb-3'); ?>
                </a>
                <div class = "bl_book_category">
                </div>
                <h3 class = "bl_book_title">
                    <a href="<?php the_permalink($id); ?>"><?php echo get_the_title($id); ?>
                    </a>
                </h3>
                <h4 class = "bl_book_author">
                     <?php echo get_the_term_list($id,'writer', '', ',', ''); ?>
                </h4>
                <div class= "bl_book_price">
                    <?php
                    $product = wc_get_product($id);
                    echo $product->get_price_html();
                    if ( !$product->is_in_stock() ){
                        echo '<p class="stock out-of-stock">Out of Stock</p>';
                    }
                    else {
                        $checkout_url = wc_get_checkout_url(); ?>
                        <a href="<?php echo $checkout_url; ?>" value="<?php echo get_the_ID(); ?>" class="ajax_add_to_cart add_to_cart_button" data-product_id="<?php echo $id; ?>"> Add to Cart </a>
                        <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                    <?php } ?>
                </div>
            </div>
       <?php endforeach; ?>
       <div class="bl_book_container"></div>
        <div class="bl_book_container"></div>
        <div class="bl_book_container"></div>
    </div>
    <?php endif;
}
/*This function converts the old product titles by extracting the By, and adding the result as a taxonomy*/
 function split_titles_and_author(){
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        );

    $query = new WP_Query($args);

    if( $query->have_posts() ){
        while( $query->have_posts()) { 
            $query->the_post();
        
            $title = get_the_title();
            //var_dump($title);
            $title_array = explode("by", $title);
            var_dump($title_array);
            
            if (count($title_array) == 2){
                $new_title = array(
                    'ID'           => get_the_ID(),
                    'post_title'   => trim($title_array[0]),
                );
              // Update the post into the database
                wp_update_post($new_title);
                var_dump($new_title);
                wp_set_post_terms(get_the_ID(),trim($title_array[1]),'writer');
                $name = explode(" ",$title_array[1]);
                $name = array_pop($name).', '.implode(' ',$name);
                var_dump($name);
                update_post_meta(get_the_ID(),'writer_surname',$name);
            }
            else {
                var_dump(the_title());
            }
        }
    }
}

 function add_author_meta(){
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        );

    $query = new WP_Query($args);

    if( $query->have_posts() ){
        while( $query->have_posts()) { 
            $query->the_post();
                $terms = get_the_terms(get_the_ID(),'writer');
                if($terms){
                    $name = explode(" ",$terms[0]->name);
                    $name = array_pop($name).', '.implode(' ',$name);
                    update_post_meta(get_the_ID(),'writer_surname',$name);
                }
        }
    }
}
