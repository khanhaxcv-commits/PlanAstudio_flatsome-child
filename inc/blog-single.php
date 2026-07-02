<?php

add_action('wp_enqueue_scripts', 'plana_enqueue_blog_single_styles', 30);
add_action('flatsome_after_header', 'plana_render_single_post_breadcrumb_bar', 5);
add_filter('flatsome_share_links', 'plana_single_post_share_links');
add_shortcode('plana_related_posts', 'plana_related_posts_shortcode');

function plana_enqueue_blog_single_styles()
{
    if (!is_singular('post')) {
        return;
    }

    $style_path = get_stylesheet_directory() . '/assets/css/blog-single.css';

    if (file_exists($style_path)) {
        wp_enqueue_style(
            'plana-blog-single-css',
            get_stylesheet_directory_uri() . '/assets/css/blog-single.css',
            array('flatsome-child-style'),
            filemtime($style_path)
        );
    }
}

function plana_single_post_share_links($share_links)
{
    if (!is_singular('post')) {
        return $share_links;
    }

    $allowed_links = array('facebook', 'linkedin', 'x', 'email');

    foreach ($share_links as $key => $share_link) {
        $share_links[$key]['enabled'] = in_array($key, $allowed_links, true);
    }

    if (isset($share_links['linkedin'])) {
        $share_links['linkedin']['priority'] = 30;
    }

    if (isset($share_links['x'])) {
        $share_links['x']['priority'] = 40;
    }

    if (isset($share_links['email'])) {
        $share_links['email']['priority'] = 50;
    }

    return $share_links;
}

function plana_render_single_post_breadcrumb_bar()
{
    if (!is_singular('post')) {
        return;
    }
    ?>
    <div class="plana-single-breadcrumb-bar">
        <div class="container">
            <?php plana_breadcrumbs(); ?>
        </div>
    </div>
    <?php
}

function plana_related_posts_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'limit'             => 3,
            'title'             => 'Bài viết nổi bật',
            'category'          => '',
            'show_reading_time' => 'true',
        ),
        $atts,
        'plana_related_posts'
    );

    $post_id = get_the_ID();
    $category_ids = plana_get_related_post_category_ids($atts['category'], $post_id);

    if (empty($category_ids)) {
        return '';
    }

    $related_posts = new WP_Query(array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => max(1, absint($atts['limit'])),
        'post__not_in'        => is_singular('post') ? array($post_id) : array(),
        'category__in'        => $category_ids,
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ));

    if (!$related_posts->have_posts()) {
        return '';
    }

    ob_start();
    ?>
    <section class="plana-related-posts">
        <?php if (!empty($atts['title'])) : ?>
            <h3 class="plana-related-posts__title">
                <?php echo esc_html($atts['title']); ?>
            </h3>
        <?php endif; ?>

        <div class="plana-related-posts__list">
            <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                <article class="plana-related-posts__item">
                    <a class="plana-related-posts__thumb" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(get_the_title()); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('thumbnail', array('alt' => esc_attr(get_the_title()))); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/page-header-bg.jpg'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                        <?php endif; ?>
                    </a>

                    <div class="plana-related-posts__body">
                        <p class="plana-related-posts__post-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </p>

                        <div class="plana-related-posts__meta">
                            <span>
                                <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date('d/m/Y')); ?>
                                </time>
                            </span>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
    <?php
    wp_reset_postdata();

    return ob_get_clean();
}

function plana_get_related_post_category_ids($category, $post_id)
{
    if (!empty($category)) {
        $category_ids = array();
        $category_values = array_map('trim', explode(',', $category));

        foreach ($category_values as $category_value) {
            $term = is_numeric($category_value)
                ? get_category((int) $category_value)
                : get_category_by_slug($category_value);

            if ($term && !is_wp_error($term)) {
                $category_ids[] = (int) $term->term_id;
            }
        }

        return array_unique($category_ids);
    }

    $categories = get_the_category($post_id);

    if (empty($categories)) {
        return array();
    }

    return wp_list_pluck($categories, 'term_id');
}
