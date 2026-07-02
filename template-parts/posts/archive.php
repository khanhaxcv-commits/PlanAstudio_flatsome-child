<?php

/**
 * Custom category archive list.
 *
 * This file overrides Flatsome's template-parts/posts/archive.php from the
 * child theme, while parent index/layout files remain in charge.
 */

if (!is_category()) {
    require get_template_directory() . '/template-parts/posts/archive.php';
    return;
}

$category_title = single_cat_title('', false);
?>

<?php if (have_posts()) : ?>
    <div id="post-list" class="plana-blog-list">
        <?php while (have_posts()) : the_post(); ?>
            <?php
            $categories = get_the_category();
            $primary_category = !empty($categories) ? $categories[0] : null;
            $category_name = $primary_category ? $primary_category->name : $category_title;
            $author_name = get_the_author();
            $reading_time = function_exists('plana_get_post_reading_time') ? plana_get_post_reading_time(get_the_ID()) : '';
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('plana-blog-card'); ?>>
                <a class="plana-blog-card__thumb image-anime relative" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(get_the_title()); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large', array('alt' => esc_attr(get_the_title()))); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/page-header-bg.jpg'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    <?php endif; ?>
                </a>

                <div class="plana-blog-card__body">
                    <div class="plana-blog-card__category">
                        <?php echo esc_html($category_name); ?>
                    </div>

                    <h2 class="plana-blog-card__title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>

                    <p class="plana-blog-card__excerpt">
                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), 26, '...')); ?>
                    </p>

                    <div class="plana-blog-card__footer">
                        <div class="plana-blog-card__meta" aria-label="<?php esc_attr_e('Thông tin bài viết', 'flatsome-child'); ?>">
                            <span class="plana-blog-card__meta-item">
                                <i class="fa-solid fa-user" aria-hidden="true"></i>
                                <?php echo esc_html($author_name); ?>
                            </span>

                            <span class="plana-blog-card__meta-item">
                                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date('d/m/Y')); ?>
                                </time>
                            </span>

                            <?php if (!empty($reading_time)) : ?>
                                <span class="plana-blog-card__meta-item">
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                    <?php echo esc_html($reading_time); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>

        <?php flatsome_posts_pagination(); ?>
    </div>
<?php else : ?>
    <?php get_template_part('template-parts/posts/content', 'none'); ?>
<?php endif; ?>