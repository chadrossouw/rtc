<?php
/**
 * Functions for querying and displaying Events
 *
 * @package reclaimthecity
 */

function rtc_twitter(){
   $twitter_feed = get_field('social_media', 'option')["twitter"];
    ?>
    <a class="twitter-link" href="<?php echo $twitter_feed; ?>">
        <img class="twitter-timeline--icon" src="<?php echo get_template_directory_uri(); ?>/assets/twitter.svg"> 
        Twitter
    </a>
    <a class="twitter-timeline" href="<?php echo $twitter_feed; ?>?ref_src=twsrc%5Etfw"
    data-chrome="noheader noscrollbar transparent nofooter noborders"
    data-tweet-limit="3"
    data-width="100%">
    <img class="twitter-timeline--icon" src="<?php echo get_template_directory_uri(); ?>/assets/twitter.svg"> Twitter
    </a> 
    <script type="text/javascript">
        if(window.innerWidth<1200 && window.innerWidth>700){
            document.querySelector('.twitter-timeline').dataset.tweetLimit = 4;
        }
    </script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
    <?php
}