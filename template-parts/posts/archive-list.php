<?php

/**
 * Custom posts archive list.
 *
 * @package FlatsomeChild
 */

if (have_posts()) : ?>
    <div id="post-list" class="plana-blog-list">
        <?php while (have_posts()) : the_post(); ?>
            <?php
            $primary_category = function_exists('plana_get_primary_post_category') ? plana_get_primary_post_category(get_the_ID()) : null;
            $thumbnail_url = has_post_thumbnail()
                ? get_the_post_thumbnail_url(get_the_ID(), 'large')
                : get_stylesheet_directory_uri() . '/assets/images/page-header-bg.jpg';
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('plana-blog-card'); ?>>
                <a class="plana-blog-card__thumb image-anime relative" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(get_the_title()); ?>">
                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                </a>

                <div class="plana-blog-card__body">
                    <?php if ($primary_category) : ?>
                        <a class="plana-blog-card__category" href="<?php echo esc_url(get_category_link($primary_category)); ?>">
                            <?php echo esc_html($primary_category->name); ?>
                        </a>
                    <?php endif; ?>

                    <h2 class="plana-blog-card__title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>

                    <p class="plana-blog-card__excerpt">
                        <?php echo esc_html(flatsome_get_the_excerpt(26)); ?>
                    </p>

                    <div class="plana-blog-card__footer">
                        <div class="plana-blog-card__meta">
                            <span class="plana-blog-card__meta-item">
                                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date('d/m/Y')); ?>
                                </time>
                            </span>
                            <span class="plana-blog-card__meta-separator" aria-hidden="true">.</span>
                            <span class="plana-blog-card__meta-item">
                                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                                <?php echo esc_html(plana_get_post_reading_time(get_the_ID())); ?>
                            </span>
                        </div>

                        <!-- <a class="plana-blog-card__read-more" href="<?php the_permalink(); ?>">
                            <?php esc_html_e('Đọc tiếp', 'flatsome-child'); ?>
                            <span aria-hidden="true">→</span>
                        </a> -->
                    </div>
                </div>
            </article>
        <?php endwhile; ?>

        <?php flatsome_posts_pagination(); ?>
    </div>
<?php else : ?>
    <?php get_template_part('template-parts/posts/content', 'none'); ?>
<?php endif; ?>