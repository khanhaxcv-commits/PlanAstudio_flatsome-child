<?php

add_action('wp_enqueue_scripts', 'plana_enqueue_blog_category_styles', 30);
add_action('wp', 'plana_disable_flatsome_category_archive_title');
add_action('flatsome_after_header', 'plana_render_category_hero', 5);
add_action('category_add_form_fields', 'plana_category_hero_image_add_field');
add_action('category_edit_form_fields', 'plana_category_hero_image_edit_field');
add_action('created_category', 'plana_save_category_hero_image');
add_action('edited_category', 'plana_save_category_hero_image');
add_action('admin_enqueue_scripts', 'plana_enqueue_category_admin_media');
add_action('admin_footer-edit-tags.php', 'plana_category_hero_image_admin_script');
add_action('admin_footer-term.php', 'plana_category_hero_image_admin_script');

function plana_enqueue_blog_category_styles()
{
    if (!is_category()) {
        return;
    }

    $style_path = get_stylesheet_directory() . '/assets/css/blog-category.css';

    if (file_exists($style_path)) {
        wp_enqueue_style(
            'plana-blog-category-css',
            get_stylesheet_directory_uri() . '/assets/css/blog-category.css',
            array('flatsome-child-style'),
            filemtime($style_path)
        );
    }
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
