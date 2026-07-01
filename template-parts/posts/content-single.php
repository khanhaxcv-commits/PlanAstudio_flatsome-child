<?php
/**
 * Posts content single override.
 *
 * Keeps Flatsome's single content structure but moves share icons to
 * template-parts/posts/partials/entry-title.php.
 *
 * @package FlatsomeChild
 */

?>
<div class="entry-content single-page">

    <?php the_content(); ?>

    <?php
    wp_link_pages();
    ?>
</div>

<?php if (get_theme_mod('blog_single_footer_meta', 1)) : ?>
    <footer class="entry-meta text-<?php echo esc_attr(get_theme_mod('blog_posts_title_align', 'center')); ?>">
        <?php
        $category_list = get_the_category_list(__(', ', 'flatsome'));
        $tag_list = get_the_tag_list('', __(', ', 'flatsome'));

        if ('' !== $tag_list) {
            $meta_text = __('This entry was posted in %1$s and tagged %2$s.', 'flatsome');
        } else {
            $meta_text = __('This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flatsome');
        }

        printf($meta_text, $category_list, $tag_list, get_permalink(), the_title_attribute('echo=0'));
        ?>
    </footer>
<?php endif; ?>

<?php if (get_theme_mod('blog_author_box', 1)) : ?>
    <div class="entry-author author-box">
        <div class="flex-row align-top">
            <div class="flex-col mr circle">
                <div class="blog-author-image">
                    <?php echo get_avatar(get_the_author_meta('ID'), apply_filters('flatsome_author_bio_avatar_size', 90)); ?>
                </div>
            </div>
            <div class="flex-col flex-grow">
                <h5 class="author-name uppercase pt-half">
                    <?php the_author_meta('display_name'); ?>
                </h5>
                <p class="author-desc small"><?php the_author_meta('description'); ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
if (get_theme_mod('blog_single_next_prev_nav', 1)) :
    flatsome_content_nav('nav-below');
endif;
