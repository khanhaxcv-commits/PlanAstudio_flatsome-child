<?php

use UxBuilder\Collections\Components;

add_action('init', function () {
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
    remove_filter('comment_text', 'wpautop');
});


/**
 * Load Google Fonts with Preconnect
 */
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
        'components-css' => 'components.css',
        // 'inspaire-custom-css' => 'inspaire-custom.css',
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

    // 4) CSS Inspaire chỉ load ở trang chủ hoặc page cần dùng animation template
    if (true) {

        $inspaire_css_files = array(
            'inspaire-bootstrap-css'      => 'bootstrap.min.css',
            'inspaire-fontawesome-css'    => 'all.min.css',
            'inspaire-animate-css'        => 'animate.css',
            'inspaire-swiper-css'         => 'swiper-bundle.min.css',
            'inspaire-magnific-popup-css' => 'magnific-popup.css',
            'inspaire-mousecursor-css'    => 'mousecursor.css',
        );

        foreach ($inspaire_css_files as $handle => $file) {
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

        // CSS chính của template Inspaire nên load sau cùng
        $inspaire_custom_path = get_stylesheet_directory() . '/assets/css/inspaire-custom.css';
        $inspaire_custom_uri  = get_stylesheet_directory_uri() . '/assets/css/inspaire-custom.css';

        if (file_exists($inspaire_custom_path)) {
            wp_enqueue_style(
                'inspaire-custom-css',
                $inspaire_custom_uri,
                array(
                    'inspaire-bootstrap-css',
                    'inspaire-fontawesome-css',
                    'inspaire-animate-css',
                    'inspaire-swiper-css',
                    'inspaire-magnific-popup-css',
                    'inspaire-mousecursor-css',
                ),
                filemtime($inspaire_custom_path)
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


add_action('wp_enqueue_scripts', 'nk_enqueue_inspaire_local_scripts');

function nk_enqueue_inspaire_local_scripts()
{
    $theme_uri  = get_stylesheet_directory_uri();
    $theme_path = get_stylesheet_directory();

    // Chỉ load ở trang chủ trước
    // if (!is_front_page()) {
    //     return;
    // }

    wp_enqueue_script(
        'nk-swiper',
        $theme_uri . '/assets/js/swiper-bundle.min.js',
        array(),
        filemtime($theme_path . '/assets/js/swiper-bundle.min.js'),
        true
    );

    wp_enqueue_script(
        'nk-waypoints',
        $theme_uri . '/assets/js/jquery.waypoints.min.js',
        array('jquery'),
        filemtime($theme_path . '/assets/js/jquery.waypoints.min.js'),
        true
    );

    wp_enqueue_script(
        'nk-counterup',
        $theme_uri . '/assets/js/jquery.counterup.min.js',
        array('jquery', 'nk-waypoints'),
        filemtime($theme_path . '/assets/js/jquery.counterup.min.js'),
        true
    );

    wp_enqueue_script(
        'nk-magnific-popup',
        $theme_uri . '/assets/js/jquery.magnific-popup.min.js',
        array('jquery'),
        filemtime($theme_path . '/assets/js/jquery.magnific-popup.min.js'),
        true
    );

    wp_enqueue_script(
        'nk-isotope',
        $theme_uri . '/assets/js/isotope.min.js',
        array('jquery'),
        filemtime($theme_path . '/assets/js/isotope.min.js'),
        true
    );

    wp_enqueue_script(
        'nk-parallaxie',
        $theme_uri . '/assets/js/parallaxie.js',
        array('jquery'),
        filemtime($theme_path . '/assets/js/parallaxie.js'),
        true
    );

    wp_enqueue_script(
        'nk-gsap',
        $theme_uri . '/assets/js/gsap.min.js',
        array(),
        filemtime($theme_path . '/assets/js/gsap.min.js'),
        true
    );

    wp_enqueue_script(
        'nk-scrolltrigger',
        $theme_uri . '/assets/js/ScrollTrigger.min.js',
        array('nk-gsap'),
        filemtime($theme_path . '/assets/js/ScrollTrigger.min.js'),
        true
    );

    wp_enqueue_script(
        'nk-splittext',
        $theme_uri . '/assets/js/SplitText.js',
        array('nk-gsap'),
        filemtime($theme_path . '/assets/js/SplitText.js'),
        true
    );

    wp_enqueue_script(
        'nk-wow',
        $theme_uri . '/assets/js/wow.min.js',
        array(),
        filemtime($theme_path . '/assets/js/wow.min.js'),
        true
    );

    // Magic Cursor cần cả jQuery và GSAP
    wp_enqueue_script(
        'nk-magiccursor',
        $theme_uri . '/assets/js/magiccursor.js',
        array('jquery', 'nk-gsap'),
        filemtime($theme_path . '/assets/js/magiccursor.js'),
        true
    );

    wp_enqueue_script(
        'nk-function',
        $theme_uri . '/assets/js/function.js',
        array(
            'jquery',
            'nk-swiper',
            'nk-waypoints',
            'nk-counterup',
            'nk-magnific-popup',
            'nk-isotope',
            'nk-parallaxie',
            'nk-gsap',
            'nk-scrolltrigger',
            'nk-splittext',
            'nk-wow',
            'nk-magiccursor'
        ),
        filemtime($theme_path . '/assets/js/function.js'),
        true
    );
}
