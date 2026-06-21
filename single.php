<?php

/**
 * Single post template
 * File: wp-content/themes/flatsome-child/single.php
 */

get_header();
$theme_uri = get_stylesheet_directory_uri();

if (have_posts()) :
    while (have_posts()) :
        the_post();

        $post_title = get_the_title();
        $short_title = wp_trim_words($post_title, 8, '...');

        $categories = get_the_category();
        $primary_cat = !empty($categories) ? $categories[0] : null;

        $category_name = $primary_cat ? $primary_cat->name : 'Bài viết';
        $category_link = $primary_cat ? get_category_link($primary_cat->term_id) : home_url('/');

        $is_bao_chi = has_category('bao-chi');

        $link_bai_bao = '';
        $ten_bao = '';
        $ngay_dang_bao = '';

        if ($is_bao_chi) {
            $link_bai_bao = function_exists('get_field') ? get_field('link_bai_bao') : get_post_meta(get_the_ID(), 'link_bai_bao', true);
            $ten_bao = function_exists('get_field') ? get_field('ten_bao') : get_post_meta(get_the_ID(), 'ten_bao', true);
            $ngay_dang_bao = function_exists('get_field') ? get_field('ngay_dang_bao') : get_post_meta(get_the_ID(), 'ngay_dang_bao', true);

            if (empty($ngay_dang_bao)) {
                $ngay_dang_bao = get_the_date('d/m/Y');
            }
        }
?>

        <!-- Page Header Start -->
        <div class="page-header parallaxie">
            <div class="container">
                <div class="row">
                    <div class="large-12 col">
                        <div class="page-header-box">
                            <h1 class="text-anime-style-2" data-cursor="-opaque">
                                <?php echo esc_html($short_title); ?>
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
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo esc_url($category_link); ?>">
                                            <?php echo esc_html($category_name); ?>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        /
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?php echo esc_html($short_title); ?>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Header End -->


        <!-- Page Single Post Start -->
        <div class="page-single-post">
            <div class="container">
                <div class="row">
                    <div class="large-12 col">

                        <!-- Post Featured Image Start -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-image">
                                <figure class="image-anime reveal">
                                    <?php the_post_thumbnail('full', [
                                        'alt' => esc_attr($post_title),
                                    ]); ?>
                                </figure>
                            </div>
                        <?php endif; ?>
                        <!-- Post Featured Image End -->


                        <!-- Post Single Content Start -->
                        <div class="post-content wow fadeInUp" data-wow-delay="0.3s">

                            <?php if ($is_bao_chi) : ?>
                                <div class="single-press-meta wow fadeInUp">
                                    <?php if (!empty($ten_bao)) : ?>
                                        <span class="single-press-name">
                                            <?php echo esc_html($ten_bao); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if (!empty($ten_bao) && !empty($ngay_dang_bao)) : ?>
                                        <span class="single-press-divider">|</span>
                                    <?php endif; ?>

                                    <?php if (!empty($ngay_dang_bao)) : ?>
                                        <span class="single-press-date">
                                            <?php echo esc_html($ngay_dang_bao); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($link_bai_bao)) : ?>
                                    <div class="single-press-source wow fadeInUp" data-wow-delay="0.2s">
                                        <a href="<?php echo esc_url($link_bai_bao); ?>" target="_blank" rel="noopener noreferrer">
                                            Xem bài viết gốc
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php else : ?>
                                <!-- <div class="single-post-meta wow fadeInUp">
                                    <span><?php echo esc_html(get_the_date('d/m/Y')); ?></span>
                                    <span>|</span>
                                    <span><?php echo esc_html($category_name); ?></span>
                                </div> -->
                            <?php endif; ?>


                            <!-- Post Entry Start -->
                            <div class="post-entry">
                                <?php
                                /**
                                 * Nội dung bài viết WordPress.
                                 * Bạn nhập gì trong editor thì nó render ra ở đây.
                                 */
                                $content = get_the_content();
                                $content = wpautop($content);
                                $content = do_shortcode($content);

                                echo $content;

                                wp_link_pages([
                                    'before' => '<div class="page-links">',
                                    'after'  => '</div>',
                                ]);
                                ?>
                            </div>
                            <!-- Post Entry End -->


                            <!-- Post Tag Links Start -->
                            <div class="post-tag-links">
                                <div class="row align-items-center">

                                    <div class="large-8 col">
                                        <?php
                                        $tags = get_the_tags();

                                        if (!empty($tags)) :
                                        ?>
                                            <div class="post-tags wow fadeInUp" data-wow-delay="0.5s">
                                                <span class="tag-links">
                                                    Tags:
                                                    <?php foreach ($tags as $tag) : ?>
                                                        <a href="#" onclick="event.preventDefault();">
                                                            <?php echo esc_html($tag->name); ?>
                                                        </a>
                                                        <!-- <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                                            <?php echo esc_html($tag->name); ?>
                                                        </a> -->
                                                    <?php endforeach; ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="large-4 col">
                                        <div class="post-social-sharing wow fadeInUp" data-wow-delay="0.5s">
                                            <ul>
                                                <li>
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer">
                                                        <i class="fa-brands fa-facebook-f"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer">
                                                        <i class="fa-brands fa-linkedin-in"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode($post_title); ?>" target="_blank" rel="noopener noreferrer">
                                                        <i class="fa-brands fa-x-twitter"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="mailto:?subject=<?php echo rawurlencode($post_title); ?>&body=<?php echo rawurlencode(get_permalink()); ?>">
                                                        <i class="fa-solid fa-envelope"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Post Tag Links End -->

                        </div>
                        <!-- Post Single Content End -->

                    </div>
                </div>
            </div>
        </div>
        <!-- Page Single Post End -->

<?php
    endwhile;
endif;

get_footer();
