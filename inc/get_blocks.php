<?php function get_recents($type, $count){  

    $args = array(
    'post_type' => $type,
    'posts_per_page' => $count,  
    
    );
   
    if('statement'==$type){
        $args['meta_key'] = 'date_of_statement';
        $args['orderby'] = 'meta_value';
    } 
 $posts = get_posts($args);
 //var_dump($posts);

    foreach ($posts as $recent){
        $id = $recent->ID;
        if('statement'==$type){
            $file = (get_field('press_statement_file', $id));
            $title = get_the_title($id);?>
            <a class ='download' href= <?php echo($file);?> download><?php echo($title);?></a>
        <?php }
        else{ 
            $title =  get_the_title($id);
            $file =  get_field('podcast_file', $id);
            $description = get_field('podcast_description', $id);?>
            <div class = 'podcast_recent grid'>
                <h3 class = 'podcast_recent_title'><?php echo($title);?></h3>
                <div class = 'podcast_recent_thumbnail'> <?php echo wp_get_attachment_image(get_field('podcast_thumbnail',$id), 'medium');?> </div>
                <div class = 'podcast_recent_description'><?php echo $description;?></div>
                <audio controls><source src= "<?php echo $file;?>" type="audio/mpeg"></audio>
             </div>
        <?php }
    }
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

function get_social_buttons(){
    $social_media = get_field('social_media','option'); 
    $social_media_array=['facebook','twitter','instagram','youtube'];?>
    <div class="flex flex-20 so-me">
        <?php foreach($social_media_array as $item){ ?>
            <?php if ($social_media[$item]){?>
            <a href="<?php echo $social_media[$item]; ?>"target="_blank"><span class="screen-reader-text"><?php echo $item; ?></span><?php echo file_get_contents(get_template_directory() . '/assets/'.$item.'.svg'); ?></a>
            <?php } ?>
        <?php } ?>
    </div>
<?php 
}

function get_footer_social_buttons(){
    $social_media = get_field('social_media','option'); 
    $social_media_array=['facebook','twitter','instagram','youtube'];?>
    <div class="flex flex-20 so-me">
        <?php foreach($social_media_array as $item){ ?>
            <?php if ($social_media[$item]){?>
            <a href="<?php echo $social_media[$item]; ?>"target="_blank"><span class="screen-reader-text"><?php echo $item; ?></span><?php echo file_get_contents(get_template_directory() . '/assets/'.$item.'_white.svg'); ?></a>
            <?php } ?>
        <?php } ?>
    </div>
<?php 
}
