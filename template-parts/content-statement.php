<div class = 'statement_single_page margins'>
    <h2 class="archive_item_title statement" href="<?php echo get_permalink($post_id); ?>">
    <?php echo get_the_title(); ?>
    </h2>
    
    <div class = 'statement_archive_date'> 
        Date: <?php echo get_field('date_of_statement', $post_id);?>
    </div>
    <a class ='download' href= "<?php echo (get_field('press_statement_file', $post_id));?>" download> Download <?php echo (get_the_title($post_id));?></a>
    <div class = 'statement_archive_description'>
         <?php echo get_field('press_statement_description', $post_id);?>
     </div>
    <?php if(get_field('press_statement_full_text')):?>
        <h3 class= 'full_text title'>Full Statement:</h3>
            <div class= 'statement_archive_full_text details_content'>
                <?php apply_filters('the_content',the_field('press_statement_full_text')); ?> 
            </div>
        <?php endif; ?>
</div>