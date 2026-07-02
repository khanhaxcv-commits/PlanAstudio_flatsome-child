<?php

if (!defined('WPCF7_AUTOP_FILTER')) {
    define('WPCF7_AUTOP_FILTER', false);
}

add_action('init', function () {
    // remove_filter('the_content', 'wpautop');
    // remove_filter('the_excerpt', 'wpautop');
    // remove_filter('comment_text', 'wpautop');
});
