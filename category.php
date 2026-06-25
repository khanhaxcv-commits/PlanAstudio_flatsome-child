<?php

/**
 * Category archive template
 * File: wp-content/themes/flatsome-child/category.php
 */

get_header();

$theme_uri = get_stylesheet_directory_uri();

$current_cat = get_queried_object();
$is_bao_chi  = is_category('bao-chi');

$category_title = single_cat_title('', false);
?>

<!-- Page Header Start -->
<div class="page-header parallaxie">
    <div class="container">
        <div class="row">
            <div class="large-12 col">

                <div class="page-header-box">
                    <h1 class="text-anime-style-2" data-cursor="-opaque">
                        <?php echo esc_html($category_title); ?>
                    </h1>

                    <nav class="wow fadeInUp">
                        <ol class="breadcrumb" style="display: inline-flex; gap: 5px;">
                            <li class="breadcrumb-item">
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    Trang chủ
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                /
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php echo esc_html($category_title); ?>
                            </li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Archive Section Start -->
<div class="page-blog">
    <div class="row">

        <?php if (have_posts()) : ?>

            <?php
            $post_index = 0;
            ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php
                $post_index++;
                $delay = ($post_index - 1) * 0.2;

                /**
                 * Link card:
                 * - Báo chí: ưu tiên link ngoài từ ACF link_bai_bao
                 * - Danh mục khác: link chi tiết bài viết
                 */
                $external_link = '';
                $card_link     = get_permalink();
                $target_attr   = '';

                if ($is_bao_chi) {
                    $external_link = function_exists('get_field') ? get_field('link_bai_bao') : get_post_meta(get_the_ID(), 'link_bai_bao', true);

                    if (!empty($external_link)) {
                        $card_link   = $external_link;
                        $target_attr = ' target="_blank" rel="noopener noreferrer"';
                    }
                }

                /**
                 * ACF Báo chí
                 */
                $ten_bao = '';
                $ngay_dang_bao = '';

                if ($is_bao_chi) {
                    $ten_bao = function_exists('get_field') ? get_field('ten_bao') : get_post_meta(get_the_ID(), 'ten_bao', true);
                    $ngay_dang_bao = function_exists('get_field') ? get_field('ngay_dang_bao') : get_post_meta(get_the_ID(), 'ngay_dang_bao', true);

                    if (empty($ngay_dang_bao)) {
                        $ngay_dang_bao = get_the_date('d/m/Y');
                    }
                }
                ?>

                <div class="large-4 medium-6 col">
                    <div
                        class="post-item wow fadeInUp"
                        <?php if ($delay > 0) : ?>
                        data-wow-delay="<?php echo esc_attr($delay); ?>s"
                        <?php endif; ?>>

                        <!-- Post Featured Image Start -->
                        <div class="post-featured-image">
                            <a
                                href="<?php echo esc_url($card_link); ?>"
                                class="image-anime"
                                data-cursor-text="<?php echo $is_bao_chi ? 'Read' : 'View'; ?>"
                                <?php echo $target_attr; ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large', [
                                        'alt' => esc_attr(get_the_title()),
                                    ]); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/no-image.jpg'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                <?php endif; ?>
                            </a>
                        </div>
                        <!-- Post Featured Image End -->

                        <!-- Post Item Body Start -->
                        <div class="post-item-body">

                            <?php if ($is_bao_chi) : ?>

                                <!-- Press Meta Start -->
                                <div class="press-card-meta">
                                    <?php if (!empty($ten_bao)) : ?>
                                        <span class="press-name">
                                            <?php echo esc_html($ten_bao); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if (!empty($ten_bao) && !empty($ngay_dang_bao)) : ?>
                                        <span class="press-divider">|</span>
                                    <?php endif; ?>

                                    <?php if (!empty($ngay_dang_bao)) : ?>
                                        <span class="press-date">
                                            <?php echo esc_html($ngay_dang_bao); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <!-- Press Meta End -->

                            <?php else : ?>

                                <!-- Normal Date Start -->
                                <div class="normal-card-date">
                                    <?php echo esc_html(get_the_date('d/m/Y')); ?>
                                </div>
                                <!-- Normal Date End -->

                            <?php endif; ?>

                            <!-- Post Item Content Start -->
                            <div class="post-item-content">
                                <h3>
                                    <a href="<?php echo esc_url($card_link); ?>" <?php echo $target_attr; ?>>
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                            </div>
                            <!-- Post Item Content End -->

                            <?php if ($is_bao_chi) : ?>

                                <?php if (has_excerpt()) : ?>
                                    <div class="press-card-excerpt">
                                        <?php echo esc_html(get_the_excerpt()); ?>
                                    </div>
                                <?php endif; ?>

                            <?php else : ?>

                                <!-- Blog Item Button Start -->
                                <div class="post-item-btn">
                                    <a href="<?php echo esc_url($card_link); ?>" class="post-btn">
                                        Xem thêm
                                    </a>
                                </div>
                                <!-- Blog Item Button End -->

                            <?php endif; ?>

                        </div>
                        <!-- Post Item Body End -->

                    </div>
                </div>

            <?php endwhile; ?>

            <div class="large-12 col">
                <div class="page-pagination wow fadeInUp" data-wow-delay="0.2s">
                    <?php
                    the_posts_pagination([
                        'mid_size'  => 2,
                        'prev_text' => '<i class="fa-solid fa-angle-left"></i>',
                        'next_text' => '<i class="fa-solid fa-angle-right"></i>',
                        'screen_reader_text' => '',
                    ]);
                    ?>
                </div>
            </div>

        <?php else : ?>

            <div class="large-12 col">
                <div class="empty-category-message">
                    <p>Chưa có bài viết nào trong danh mục này.</p>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>
<!-- Archive Section End -->

<?php get_footer(); ?>