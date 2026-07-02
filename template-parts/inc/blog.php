<?php

add_action('wp_enqueue_scripts', 'plana_enqueue_blog_archive_styles', 30);
add_action('wp', 'plana_disable_flatsome_category_archive_title');
add_action('flatsome_after_header', 'plana_render_category_hero', 5);
add_action('flatsome_after_header', 'plana_render_single_post_breadcrumb_bar', 5);
add_action('category_add_form_fields', 'plana_category_hero_image_add_field');
add_action('category_edit_form_fields', 'plana_category_hero_image_edit_field');
add_action('created_category', 'plana_save_category_hero_image');
add_action('edited_category', 'plana_save_category_hero_image');
add_action('admin_enqueue_scripts', 'plana_enqueue_category_admin_media');
add_action('admin_footer-edit-tags.php', 'plana_category_hero_image_admin_script');
add_action('admin_footer-term.php', 'plana_category_hero_image_admin_script');
add_filter('theme_mod_blog_style_archive', 'plana_use_custom_category_archive_style');
add_filter('theme_mod_blog_style', 'plana_use_custom_category_archive_style');
add_filter('flatsome_share_links', 'plana_single_post_share_links');
add_shortcode('plana_related_posts', 'plana_related_posts_shortcode');

function plana_enqueue_blog_archive_styles()
{
    if (!is_category()) {
        return;
    }

    $style_path = get_stylesheet_directory() . '/assets/css/blog-archive.css';

    if (file_exists($style_path)) {
        wp_enqueue_style(
            'plana-blog-archive-css',
            get_stylesheet_directory_uri() . '/assets/css/blog-archive.css',
            array('flatsome-child-style'),
            filemtime($style_path)
        );
    }
}

function plana_use_custom_category_archive_style($value)
{
    if (is_category()) {
        return 'normal';
    }

    return $value;
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

function plana_disable_flatsome_category_archive_title()
{
    if (is_category()) {
        remove_action('flatsome_before_blog', 'flatsome_archive_title', 15);
    }
}

function plana_render_category_hero()
{
    if (!is_category()) {
        return;
    }

    $category = get_queried_object();

    if (!$category || is_wp_error($category)) {
        return;
    }

    $image_url = plana_get_category_hero_image_url($category->term_id);
    $description = category_description($category->term_id);
    ?>
    <section class="plana-category-hero" style="background-image: url('<?php echo esc_url($image_url); ?>');">
        <div class="plana-category-hero__overlay"></div>
        <div class="container">
            <div class="plana-category-hero__content">
                <?php plana_breadcrumbs(); ?>

                <h1 class="plana-category-hero__title">
                    <?php echo esc_html($category->name); ?>
                </h1>

                <?php if (!empty($description)) : ?>
                    <div class="plana-category-hero__description">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
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

function plana_get_category_hero_image_url($term_id)
{
    $image_id = (int) get_term_meta($term_id, 'plana_category_hero_image_id', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'full') : '';

    if (!$image_url) {
        $image_url = get_stylesheet_directory_uri() . '/assets/images/page-header-bg.jpg';
    }

    return $image_url;
}

function plana_category_hero_image_add_field()
{
    ?>
    <div class="form-field term-plana-hero-image-wrap">
        <label for="plana_category_hero_image_id"><?php esc_html_e('Ảnh banner danh mục', 'flatsome-child'); ?></label>
        <?php wp_nonce_field('plana_save_category_hero_image', 'plana_category_hero_image_nonce'); ?>
        <input type="hidden" id="plana_category_hero_image_id" name="plana_category_hero_image_id" value="">
        <div class="plana-category-hero-image-preview"></div>
        <p>
            <button type="button" class="button plana-upload-category-hero-image"><?php esc_html_e('Chọn ảnh', 'flatsome-child'); ?></button>
            <button type="button" class="button plana-remove-category-hero-image" style="display:none;"><?php esc_html_e('Xóa ảnh', 'flatsome-child'); ?></button>
        </p>
        <p><?php esc_html_e('Ảnh này sẽ dùng làm banner đầu trang cho danh mục bài viết.', 'flatsome-child'); ?></p>
    </div>
    <?php
}

function plana_category_hero_image_edit_field($term)
{
    $image_id = (int) get_term_meta($term->term_id, 'plana_category_hero_image_id', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
    ?>
    <tr class="form-field term-plana-hero-image-wrap">
        <th scope="row">
            <label for="plana_category_hero_image_id"><?php esc_html_e('Ảnh banner danh mục', 'flatsome-child'); ?></label>
        </th>
        <td>
            <?php wp_nonce_field('plana_save_category_hero_image', 'plana_category_hero_image_nonce'); ?>
            <input type="hidden" id="plana_category_hero_image_id" name="plana_category_hero_image_id" value="<?php echo esc_attr($image_id); ?>">
            <div class="plana-category-hero-image-preview">
                <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="" style="max-width:240px;height:auto;display:block;margin-bottom:10px;">
                <?php endif; ?>
            </div>
            <p>
                <button type="button" class="button plana-upload-category-hero-image"><?php esc_html_e('Chọn ảnh', 'flatsome-child'); ?></button>
                <button type="button" class="button plana-remove-category-hero-image" <?php echo $image_id ? '' : 'style="display:none;"'; ?>><?php esc_html_e('Xóa ảnh', 'flatsome-child'); ?></button>
            </p>
            <p class="description"><?php esc_html_e('Ảnh này sẽ dùng làm banner đầu trang cho danh mục bài viết.', 'flatsome-child'); ?></p>
        </td>
    </tr>
    <?php
}

function plana_save_category_hero_image($term_id)
{
    if (
        !isset($_POST['plana_category_hero_image_nonce']) ||
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['plana_category_hero_image_nonce'])), 'plana_save_category_hero_image')
    ) {
        return;
    }

    if (!isset($_POST['plana_category_hero_image_id'])) {
        return;
    }

    $image_id = absint(wp_unslash($_POST['plana_category_hero_image_id']));

    update_term_meta(
        $term_id,
        'plana_category_hero_image_id',
        $image_id
    );
}

function plana_enqueue_category_admin_media($hook)
{
    if (!in_array($hook, array('edit-tags.php', 'term.php'), true)) {
        return;
    }

    $screen = get_current_screen();

    if (!$screen || 'category' !== $screen->taxonomy) {
        return;
    }

    wp_enqueue_media();
}

function plana_category_hero_image_admin_script()
{
    $screen = get_current_screen();

    if (!$screen || 'category' !== $screen->taxonomy) {
        return;
    }
    ?>
    <script>
        jQuery(function($) {
            var frame;

            $('.plana-upload-category-hero-image').on('click', function(e) {
                e.preventDefault();

                if (frame) {
                    frame.open();
                    return;
                }

                frame = wp.media({
                    title: '<?php echo esc_js(__('Chọn ảnh banner danh mục', 'flatsome-child')); ?>',
                    button: {
                        text: '<?php echo esc_js(__('Dùng ảnh này', 'flatsome-child')); ?>'
                    },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    var imageUrl = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;

                    $('#plana_category_hero_image_id').val(attachment.id);
                    $('.plana-category-hero-image-preview').html('<img src="' + imageUrl + '" alt="" style="max-width:240px;height:auto;display:block;margin-bottom:10px;">');
                    $('.plana-remove-category-hero-image').show();
                });

                frame.open();
            });

            $('.plana-remove-category-hero-image').on('click', function(e) {
                e.preventDefault();

                $('#plana_category_hero_image_id').val('');
                $('.plana-category-hero-image-preview').empty();
                $(this).hide();
            });
        });
    </script>
    <?php
}

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
                                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date('d/m/Y')); ?>
                                </time>
                            </span>

                            <!-- <?php if ('false' !== strtolower((string) $atts['show_reading_time'])) : ?>
                                <span>
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                    <?php echo esc_html(plana_get_post_reading_time(get_the_ID())); ?>
                                </span>
                            <?php endif; ?> -->
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
