<?php

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

add_action('wp_enqueue_scripts', 'flatsome_child_enqueue_styles', 20);

function flatsome_child_enqueue_styles()
{
    wp_enqueue_style(
        'flatsome-child-style',
        get_stylesheet_uri(),
        array('flatsome-main'),
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    wp_enqueue_style(
        'reset-css',
        get_stylesheet_directory_uri() . '/assets/css/reset.css',
        array('flatsome-child-style'),
        filemtime(get_stylesheet_directory() . '/assets/css/reset.css')
    );

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

    $global_css = array(
        'customize-css' => 'customize.css',
        'header-css'    => 'header.css',
        'footer-css'    => 'footer.css',
        'components-css' => 'components.css',
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

    $inspaire_css_files = array(
        'inspaire-fontawesome-css'    => 'all.min.css',
        'inspaire-animate-css'        => 'animate.css',
        'inspaire-swiper-css'         => 'swiper-bundle.min.css',
        'inspaire-magnific-popup-css' => 'magnific-popup.css',
        'inspaire-mousecursor-css'    => 'mousecursor.css',
        'inspaire-custom-v1-css'      => 'inspaire-custom-v1.css',
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

    $inspaire_custom_path = get_stylesheet_directory() . '/assets/css/inspaire-custom.css';
    $inspaire_custom_uri  = get_stylesheet_directory_uri() . '/assets/css/inspaire-custom.css';

    if (file_exists($inspaire_custom_path)) {
        wp_enqueue_style(
            'inspaire-custom-css',
            $inspaire_custom_uri,
            array(
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

add_action('wp_enqueue_scripts', 'nk_enqueue_inspaire_local_scripts');

function nk_enqueue_inspaire_local_scripts()
{
    $theme_uri  = get_stylesheet_directory_uri();
    $theme_path = get_stylesheet_directory();

    wp_enqueue_script(
        'nk-bootstrap',
        $theme_uri . '/assets/js/bootstrap.min.js',
        array(),
        filemtime($theme_path . '/assets/js/bootstrap.min.js'),
        true
    );

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
            'nk-bootstrap',
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
            'nk-magiccursor',
        ),
        filemtime($theme_path . '/assets/js/function.js'),
        true
    );
}
