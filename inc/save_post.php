<?php 

function add_surname_meta_for_ordering($post_id,$post){
    $terms = get_the_terms($post_id, 'writer');
    if($terms){
        $name = $terms[0];
        $name = explode(" ",$name);
        $name = array_pop($name).', '.implode(' ',$name);
        update_post_meta($post_id,'writer_surname',$name);
    }
}

add_action('save_post_product','add_surname_meta_for_ordering',10,2);