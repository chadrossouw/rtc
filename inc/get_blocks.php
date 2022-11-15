<?php function get_recents($type, $count){  

    $args = array(
    'post_type' => $type,
    'posts_per_page' => $count,  
    
    );
   
    if('statement'==$type){
        $args['meta_key'] = 'date_of_statement';
        $args['orderby'] = 'meta_value';
    } 

    if('podcast'==$type){
        $args['meta_key'] = 'date_of_podcast';
        $args['orderby'] = 'meta_value';
    } 
    $posts = get_posts($args);
    //var_dump($posts);

    foreach ($posts as $recent){
        $id = $recent->ID;
        if('statement'==$type){
            $file = (get_field('press_statement_file', $id));
            $title = get_the_title($id);
            $url = get_permalink($id);?>
            <div class = "statement_download">
                <a href="<?php echo $url;?>"><?php echo $title;?></a>
                <a class ='download' href= <?php echo($file);?> download></a>
            </div>
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
