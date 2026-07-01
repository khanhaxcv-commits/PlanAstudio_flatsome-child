<?php
/**
 * Post-entry title override.
 *
 * @package FlatsomeChild
 */

if (is_single()) :
    if (get_theme_mod('blog_single_header_category', 1)) :
        echo '<h6 class="entry-category is-xsmall">';
        echo get_the_category_list(__(', ', 'flatsome'));
        echo '</h6>';
    endif;
else :
    echo '<h6 class="entry-category is-xsmall">';
    echo get_the_category_list(__(', ', 'flatsome'));
    echo '</h6>';
endif;

if (is_single()) :
    if (get_theme_mod('blog_single_header_title', 1)) :
        echo '<h1 class="entry-title">' . esc_html(get_the_title()) . '</h1>';
        echo '<div class="entry-divider is-divider small"></div>';
    endif;
else :
    echo '<h2 class="entry-title"><a href="' . esc_url(get_the_permalink()) . '" rel="bookmark" class="plain">' . esc_html(get_the_title()) . '</a></h2>';
    echo '<div class="entry-divider is-divider small"></div>';
endif;
?>

<?php
$single_post = is_singular('post');

if ($single_post && get_theme_mod('blog_single_header_meta', 1)) :
    $reading_time = function_exists('plana_get_post_reading_time') ? plana_get_post_reading_time(get_the_ID()) : '';
    ?>
    <div class="plana-single-post-meta-row">
        <div class="entry-meta plana-single-post-meta">
            <span class="plana-single-post-meta__item">
                <i class="fa-regular fa-user" aria-hidden="true"></i>
                <?php echo esc_html(get_the_author()); ?>
            </span>

            <span class="plana-single-post-meta__item">
                <i class="fa-regular fa-clock" aria-hidden="true"></i>
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo esc_html(get_the_date('d/m/Y')); ?>
                </time>
            </span>

            <?php if (!empty($reading_time)) : ?>
                <span class="plana-single-post-meta__item">
                    <i class="fa-regular fa-circle-check" aria-hidden="true"></i>
                    <?php echo esc_html($reading_time); ?>
                </span>
            <?php endif; ?>
        </div>

        <?php if (get_theme_mod('blog_share', 1)) : ?>
            <div class="plana-single-post-share">
                <?php
                echo flatsome_apply_shortcode('share', array(
                    'class'   => 'plana-header-share-icons',
                    'style'   => 'plain',
                    'tooltip' => 'false',
                ));
                ?>
            </div>
        <?php endif; ?>
    </div>
<?php elseif (!$single_post && 'post' === get_post_type()) : ?>
    <div class="entry-meta uppercase is-xsmall">
        <?php flatsome_posted_on(); ?>
    </div>
<?php endif; ?>
