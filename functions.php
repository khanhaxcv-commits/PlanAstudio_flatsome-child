<?php

use UxBuilder\Collections\Components;

add_action('init', function () {
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
    remove_filter('comment_text', 'wpautop');
});


add_action('wp_enqueue_scripts', 'plana_enqueue_google_fonts');

function plana_enqueue_google_fonts()
{
    wp_enqueue_style(
        'plana-google-fonts',
        'https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap',
        array(),
        null
    );
}

add_filter('wp_resource_hints', 'plana_google_fonts_resource_hints', 10, 2);

function plana_google_fonts_resource_hints($urls, $relation_type)
{
    if ('preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
        );

        $urls[] = array(
            'href'        => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }

    return $urls;
}

/**
 * Load Lucide Icons Local
 */
function load_lucide_icons()
{
    wp_enqueue_script(
        'lucide-icons',
        get_stylesheet_directory_uri() . '/assets/js/lucide.min.js',
        array(),
        filemtime(get_stylesheet_directory() . '/assets/js/lucide.min.js'),
        true
    );

    wp_add_inline_script(
        'lucide-icons',
        'document.addEventListener("DOMContentLoaded", function() {
            if (typeof lucide !== "undefined") {
                lucide.createIcons();
            }
        });'
    );
}

function flatsome_child_enqueue_styles()
{
    // 1) style.css
    wp_enqueue_style(
        'flatsome-child-style',
        get_stylesheet_uri(),
        array('flatsome-main'),
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    // 2) reset.css
    wp_enqueue_style(
        'reset-css',
        get_stylesheet_directory_uri() . '/assets/css/reset.css',
        array('flatsome-child-style'),
        filemtime(get_stylesheet_directory() . '/assets/css/reset.css')
    );
    // 2.1) tailwind.css
    $tailwind_path = get_stylesheet_directory() . '/assets/css/tailwind.css';
    $tailwind_uri  = get_stylesheet_directory_uri() . '/assets/css/tailwind.css';

    if (file_exists($tailwind_path)) {
        wp_enqueue_style(
            'tailwind-css',
            $tailwind_uri,
            array('reset-css'),
            filemtime($tailwind_path)
        );
    }
    // 3) CSS luôn load trên mọi trang
    $global_css = array(
        'customize-css' => 'customize.css',
        'header-css'    => 'header.css',
        'footer-css'    => 'footer.css',
        'components-css' => 'components.css'
    );

    foreach ($global_css as $handle => $file) {
        $path = get_stylesheet_directory() . '/assets/css/' . $file;
        $uri  = get_stylesheet_directory_uri() . '/assets/css/' . $file;

        if (file_exists($path)) {
            wp_enqueue_style(
                $handle,
                $uri,
                array('reset-css'),
                filemtime($path)
            );
        }
    }

    // 4) Trang HOME → chỉ load trang-chu.css
    // if (is_front_page() || is_page('trang-chu-1')) {
    //     wp_enqueue_style(
    //         'trang-chu-css',
    //         get_stylesheet_directory_uri() . '/assets/trang-chu.css',
    //         array('reset-css'),
    //         filemtime(get_stylesheet_directory() . '/assets/trang-chu.css')
    //     );

    //     wp_enqueue_style(
    //         'trang-chu-1-css',
    //         get_stylesheet_directory_uri() . '/assets/trang-chu-1.css',
    //         array('reset-css'),
    //         filemtime(get_stylesheet_directory() . '/assets/trang-chu-1.css')
    //     );
    // }

    // 5) Load CSS theo từng trang cụ thể
    // if (is_page('tam-nhin-su-menh')) {
    //     wp_enqueue_style(
    //         'tam-nhin-su-menh-css',
    //         get_stylesheet_directory_uri() . '/assets/tam-nhin-su-menh.css',
    //         array('reset-css'),
    //         filemtime(get_stylesheet_directory() . '/assets/tam-nhin-su-menh.css')
    //     );
    // }
}
add_action('wp_enqueue_scripts', 'flatsome_child_enqueue_styles', 20);
