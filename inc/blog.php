<?php

function plana_get_post_reading_time($post_id = null)
{
    $post_id = $post_id ? $post_id : get_the_ID();
    $content = get_post_field('post_content', $post_id);
    $content = strip_shortcodes($content);
    $content = wp_strip_all_tags($content);
    preg_match_all('/\p{L}+/u', $content, $words);

    $word_count = count($words[0]);
    $reading_time = max(1, (int) ceil($word_count / 200));

    return sprintf(
        _n('%s phút đọc', '%s phút đọc', $reading_time, 'flatsome-child'),
        number_format_i18n($reading_time)
    );
}

function plana_get_primary_post_category($post_id = null)
{
    $post_id = $post_id ? $post_id : get_the_ID();
    $categories = get_the_category($post_id);

    if (empty($categories)) {
        return null;
    }

    $primary_category_id = (int) get_post_meta($post_id, '_yoast_wpseo_primary_category', true);

    if (!$primary_category_id) {
        $primary_category_id = (int) get_post_meta($post_id, 'rank_math_primary_category', true);
    }

    if ($primary_category_id) {
        foreach ($categories as $category) {
            if ((int) $category->term_id === $primary_category_id) {
                return $category;
            }
        }
    }

    return $categories[0];
}
