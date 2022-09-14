<div class= 'podcast_single_page margins'>
    <h2 class="archive_item_title podcast" href="<?php echo get_permalink($post_id); ?>">
    <?php echo get_the_title(); ?>
    </h2>
    <div class = 'podcast_archive_thumbnail'> 
        <?php echo wp_get_attachment_image(get_field('podcast_thumbnail',$post_id), 'medium');?> 
    </div>
    <?php if(get_field('podcast_description', $post_id)):?>
        <div class = 'podcast_archive_description'>
            <?php echo get_field('podcast_description', $post_id);?>
        </div>
    <?php endif; ?>
    <div class = 'podcast_archive_player'>
    <audio controls><source src= "<?php echo (get_field('podcast_file', $post_id));?>" type="audio/mpeg"></audio>
    </div>
    <div class = 'podcast_archive_date'>
        Date: <?php echo get_field('date_of_podcast', $post_id);?>
    </div>
    <a class ='archive_button podcast button' href ="/podcasts">Podcasts Archive</a>
</div>