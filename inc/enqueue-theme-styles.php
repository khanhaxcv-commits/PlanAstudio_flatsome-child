<?php

/**
 * Enqueue Theme Styles
 *
 * Load all theme CSS files with proper dependency management.
 *
 * File location rules:
 * - style.css stays in the child theme root.
 * - All other CSS files stay in /assets/css/.
 * - Do not place custom CSS files in the child theme root except style.css.
 *
 * Base dependency:
 * flatsome-main
 *
 * Load order:
 *
 * 1. reset.css
 * ↓
 * 2. style.css
 * ↓
 * 3. vendor/library css (animate.css, mousecursor.css)
 * ↓
 * 4. global.css
 * ↓
 * 5. components.css
 * ↓
 * 6. header.css
 * ↓
 * 7. flatsome-mobile-menu.css
 * ↓
 * 8. flatsome-desktop-menu.css
 * ↓
 * 9. footer.css
 * ↓
 * 10. static page css
 * ↓
 * 11. conditional template css
 * ↓
 * 12. customize.css
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('enqueue_css_file')) {
    function enqueue_css_file($handle, $file, $deps = array(), $media = 'all')
    {
        $path = get_stylesheet_directory() . '/assets/css/' . $file;
        $uri  = get_stylesheet_directory_uri() . '/assets/css/' . $file;

        if (!file_exists($path)) {
            return false;
        }

        wp_enqueue_style(
            $handle,
            $uri,
            $deps,
            filemtime($path),
            $media
        );

        return true;
    }
}

if (!function_exists('enqueue_root_style_file')) {
    function enqueue_root_style_file($handle, $deps = array())
    {
        $path = get_stylesheet_directory() . '/style.css';

        if (!file_exists($path)) {
            return false;
        }

        wp_enqueue_style(
            $handle,
            get_stylesheet_uri(),
            $deps,
            filemtime($path)
        );

        return true;
    }
}

if (!function_exists('enqueue_css_files')) {
    function enqueue_css_files($files, $deps = array())
    {
        $handles = array();

        foreach ($files as $handle => $file) {
            if (enqueue_css_file($handle, $file, $deps)) {
                $handles[] = $handle;
            }
        }

        return $handles;
    }
}

if (!function_exists('get_current_page_slug')) {
    function get_current_page_slug()
    {
        $queried_object = get_queried_object();

        if (!empty($queried_object->post_name)) {
            return sanitize_title($queried_object->post_name);
        }

        if (!empty($queried_object->slug)) {
            return sanitize_title($queried_object->slug);
        }

        return '';
    }
}

if (!function_exists('enqueue_theme_styles')) {
    function enqueue_theme_styles()
    {
        /**
         * 1. reset.css
         *
         * Location:
         * /assets/css/reset.css
         */
        $has_reset = enqueue_css_file(
            'reset-css',
            'reset.css',
            array('flatsome-main')
        );

        /**
         * 2. style.css
         *
         * Location:
         * /style.css
         */
        $has_child_style = enqueue_root_style_file(
            'flatsome-child-style',
            $has_reset ? array('reset-css') : array('flatsome-main')
        );

        $base_deps = $has_child_style ? array('flatsome-child-style') : array('flatsome-main');

        /**
         * 3. vendor/library css
         *
         * Location:
         * /assets/css/
         */
        $vendor_handles = enqueue_css_files(
            array(
                'animate-css'        => 'animate.css',
                'magnific-popup-css' => 'magnific-popup.css',
                'mousecursor-css'    => 'mousecursor.css',
            ),
            $base_deps
        );

        $vendor_deps = !empty($vendor_handles) ? $vendor_handles : $base_deps;

        /**
         * 4. global.css
         *
         * Location:
         * /assets/css/global.css
         */
        $has_global = enqueue_css_file(
            'global-css',
            'global.css',
            $vendor_deps
        );

        $global_deps = $has_global ? array('global-css') : $vendor_deps;

        /**
         * 5. components.css
         *
         * Location:
         * /assets/css/components.css
         */
        $has_components = enqueue_css_file(
            'components-css',
            'components.css',
            $global_deps
        );

        $component_deps = $has_components ? array('components-css') : $global_deps;

        /**
         * 6. header.css
         *
         * Location:
         * /assets/css/header.css
         */
        $has_header = enqueue_css_file(
            'header-css',
            'header.css',
            $component_deps
        );

        $header_deps = $has_header ? array('header-css') : $component_deps;

        /**
         * 7. flatsome-mobile-menu.css
         *
         * Location:
         * /assets/css/flatsome-mobile-menu.css
         */
        $layout_handles = array();

        if ($has_header) {
            $layout_handles[] = 'header-css';
        }

        if (
            enqueue_css_file(
                'flatsome-mobile-menu-css',
                'flatsome-mobile-menu.css',
                $header_deps,
                '(max-width: 849px)'
            )
        ) {
            $layout_handles[] = 'flatsome-mobile-menu-css';
        }

        /**
         * 8. flatsome-desktop-menu.css
         *
         * Location:
         * /assets/css/flatsome-desktop-menu.css
         */
        if (
            enqueue_css_file(
                'flatsome-desktop-menu-css',
                'flatsome-desktop-menu.css',
                $header_deps,
                '(min-width: 850px)'
            )
        ) {
            $layout_handles[] = 'flatsome-desktop-menu-css';
        }

        $footer_deps = !empty($layout_handles) ? $layout_handles : $header_deps;

        /**
         * 9. footer.css
         *
         * Location:
         * /assets/css/footer.css
         */
        if (
            enqueue_css_file(
                'footer-css',
                'footer.css',
                $footer_deps
            )
        ) {
            $layout_handles[] = 'footer-css';
        }

        $static_deps = !empty($layout_handles) ? $layout_handles : $component_deps;

        /**
         * 10. static page css
         *
         * Location:
         * /assets/css/
         */
        $static_handles = array();
        $static_current_deps = $static_deps;

        if (
            enqueue_css_file(
                'inspaire-custom-v1-css',
                'inspaire-custom-v1.css',
                $static_current_deps
            )
        ) {
            $static_handles[] = 'inspaire-custom-v1-css';
            $static_current_deps = array('inspaire-custom-v1-css');
        }

        if (is_front_page()) {
            $page_slug = get_current_page_slug();

            if (
                enqueue_css_file(
                    'front-page-css',
                    'front-page.css',
                    $static_current_deps
                )
            ) {
                $static_handles[] = 'front-page-css';
                $static_current_deps = array('front-page-css');
            }

            if (!empty($page_slug)) {
                if (
                    enqueue_css_file(
                        $page_slug . '-css',
                        $page_slug . '.css',
                        $static_current_deps
                    )
                ) {
                    $static_handles[] = $page_slug . '-css';
                    $static_current_deps = array($page_slug . '-css');
                }

                if (
                    enqueue_css_file(
                        'page-' . $page_slug . '-css',
                        'page-' . $page_slug . '.css',
                        $static_current_deps
                    )
                ) {
                    $static_handles[] = 'page-' . $page_slug . '-css';
                    $static_current_deps = array('page-' . $page_slug . '-css');
                }
            }
        }

        if (is_home() && !is_front_page()) {
            if (
                enqueue_css_file(
                    'home-css',
                    'home.css',
                    $static_current_deps
                )
            ) {
                $static_handles[] = 'home-css';
                $static_current_deps = array('home-css');
            }
        }

        if (is_page() && !is_front_page()) {
            $page_slug = get_current_page_slug();

            if (
                enqueue_css_file(
                    'page-css',
                    'page.css',
                    $static_current_deps
                )
            ) {
                $static_handles[] = 'page-css';
                $static_current_deps = array('page-css');
            }

            if (!empty($page_slug)) {
                if (
                    enqueue_css_file(
                        $page_slug . '-css',
                        $page_slug . '.css',
                        $static_current_deps
                    )
                ) {
                    $static_handles[] = $page_slug . '-css';
                    $static_current_deps = array($page_slug . '-css');
                }

                if (
                    enqueue_css_file(
                        'page-' . $page_slug . '-css',
                        'page-' . $page_slug . '.css',
                        $static_current_deps
                    )
                ) {
                    $static_handles[] = 'page-' . $page_slug . '-css';
                    $static_current_deps = array('page-' . $page_slug . '-css');
                }
            }
        }

        $conditional_deps = !empty($static_handles) ? $static_handles : $static_deps;

        /**
         * 11. conditional template css
         *
         * Location:
         * /assets/css/
         */
        $conditional_handles = array();
        $conditional_current_deps = $conditional_deps;

        if (
            is_home() ||
            is_category() ||
            is_tag() ||
            is_search() ||
            is_singular('post')
        ) {
            if (
                enqueue_css_file(
                    'blog-sidebar-css',
                    'blog-sidebar.css',
                    $conditional_current_deps
                )
            ) {
                $conditional_handles[] = 'blog-sidebar-css';
                $conditional_current_deps = array('blog-sidebar-css');
            }
        }

        if (is_category()) {
            if (
                enqueue_css_file(
                    'blog-category-css',
                    'blog-category.css',
                    $conditional_current_deps
                )
            ) {
                $conditional_handles[] = 'blog-category-css';
                $conditional_current_deps = array('blog-category-css');
            }
        }

        if (is_singular('post')) {
            if (
                enqueue_css_file(
                    'blog-single-css',
                    'blog-single.css',
                    $conditional_current_deps
                )
            ) {
                $conditional_handles[] = 'blog-single-css';
                $conditional_current_deps = array('blog-single-css');
            }
        }

        if (is_tag()) {
            // Add tag CSS here later.
        }

        if (is_search()) {
            // Add search CSS here later.
        }

        if (is_404()) {
            // Add 404 CSS here later.
        }

        if (class_exists('WooCommerce')) {
            if (function_exists('is_woocommerce') && is_woocommerce()) {
                // Add general WooCommerce CSS here later.
            }

            if (function_exists('is_shop') && is_shop()) {
                // Add shop CSS here later.
            }

            if (function_exists('is_product') && is_product()) {
                // Add product detail CSS here later.
            }

            if (function_exists('is_product_category') && is_product_category()) {
                // Add product category CSS here later.
            }

            if (function_exists('is_cart') && is_cart()) {
                // Add cart CSS here later.
            }

            if (function_exists('is_checkout') && is_checkout()) {
                // Add checkout CSS here later.
            }

            if (function_exists('is_account_page') && is_account_page()) {
                // Add my account CSS here later.
            }
        }

        /**
         * 12. customize.css
         *
         * Location:
         * /assets/css/customize.css
         */
        $customize_deps = array_unique(
            array_merge(
                $base_deps,
                $vendor_handles,
                $global_deps,
                $component_deps,
                $layout_handles,
                $static_handles,
                $conditional_handles
            )
        );

        enqueue_css_file(
            'customize-css',
            'customize.css',
            $customize_deps
        );
    }
}

add_action('wp_enqueue_scripts', 'enqueue_theme_styles', 20);
