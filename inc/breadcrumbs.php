<?php

function plana_breadcrumbs()
{
    if (function_exists('rank_math_get_breadcrumbs')) {
        $breadcrumb = trim(rank_math_get_breadcrumbs(array(
            'wrap_before' => '<nav class="cvn-single-breadcrumbs" aria-label="Breadcrumb">',
            'wrap_after'  => '</nav>',
            'separator'   => '<span class="cvn-single-breadcrumbs__divider">&rsaquo;</span>',
        )));

        if ($breadcrumb !== '') {
            echo $breadcrumb;
            return;
        }
    }

    $items = array(
        '<a href="' . esc_url(home_url('/')) . '">Trang chủ</a>',
    );

    if (is_category()) {
        $category = get_queried_object();

        if ($category && !is_wp_error($category)) {
            $items = array_merge($items, plana_get_category_breadcrumb_items($category));
        }
    } elseif (is_single()) {
        $categories = get_the_category();

        if (!empty($categories)) {
            $items = array_merge($items, plana_get_category_breadcrumb_items($categories[0], true));
        }

        $items[] = '<span>' . esc_html(get_the_title()) . '</span>';
    } elseif (is_page()) {
        $ancestors = array_reverse(get_post_ancestors(get_the_ID()));

        foreach ($ancestors as $ancestor_id) {
            $items[] = '<a href="' . esc_url(get_permalink($ancestor_id)) . '">' . esc_html(get_the_title($ancestor_id)) . '</a>';
        }

        $items[] = '<span>' . esc_html(get_the_title()) . '</span>';
    } elseif (is_tag() || is_tax()) {
        $term = get_queried_object();

        if ($term && !is_wp_error($term)) {
            $items[] = '<span>' . esc_html($term->name) . '</span>';
        }
    } elseif (is_search()) {
        $items[] = '<span>' . esc_html__('Tìm kiếm', 'flatsome-child') . '</span>';
    } elseif (is_404()) {
        $items[] = '<span>' . esc_html__('Không tìm thấy', 'flatsome-child') . '</span>';
    } elseif (is_home()) {
        $posts_page_id = (int) get_option('page_for_posts');
        $title = $posts_page_id ? get_the_title($posts_page_id) : esc_html__('Bài viết', 'flatsome-child');

        $items[] = '<span>' . esc_html($title) . '</span>';
    }

    echo '<nav class="cvn-single-breadcrumbs" aria-label="Breadcrumb">' . implode('<span class="cvn-single-breadcrumbs__divider">&rsaquo;</span>', $items) . '</nav>';
}

function plana_get_category_breadcrumb_items($category, $include_current_link = false)
{
    $items = array();
    $ancestors = array_reverse(get_ancestors((int) $category->term_id, 'category'));

    foreach ($ancestors as $ancestor_id) {
        $ancestor = get_category($ancestor_id);

        if (!$ancestor || is_wp_error($ancestor)) {
            continue;
        }

        $items[] = '<a href="' . esc_url(get_category_link($ancestor)) . '">' . esc_html($ancestor->name) . '</a>';
    }

    if ($include_current_link) {
        $items[] = '<a href="' . esc_url(get_category_link($category)) . '">' . esc_html($category->name) . '</a>';
    } else {
        $items[] = '<span>' . esc_html($category->name) . '</span>';
    }

    return $items;
}

function cvn_single_post_breadcrumb()
{
    plana_breadcrumbs();
}
