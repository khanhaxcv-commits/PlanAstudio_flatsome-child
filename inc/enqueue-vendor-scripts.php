<?php

/**
 * Enqueue Vendor Scripts
 *
 * Load local vendor/library scripts from /assets/js/.
 *
 * Dependencies:
 * - jquery
 * - external assets
 *
 * Load order:
 *
 * 1. SplitText.js
 * ↓
 * 2. wow.min.js
 * ↓
 * 3. validator.min.js
 * ↓
 * 4. isotope.min.js
 * ↓
 * 5. jquery.waypoints.min.js
 * ↓
 * 6. jquery.counterup.min.js
 * ↓
 * 7. jquery.magnific-popup.min.js
 * ↓
 * 8. jquery.mb.YTPlayer.min.js
 * ↓
 * 9. jquery.slicknav.js
 * ↓
 * 10. parallaxie.js
 * ↓
 * 11. SmoothScroll.js
 * ↓
 * 12. magiccursor.js
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('enqueue_script_file')) {
    function enqueue_script_file($handle, $file, $deps = array(), $in_footer = true)
    {
        $path = get_stylesheet_directory() . '/assets/js/' . $file;
        $uri  = get_stylesheet_directory_uri() . '/assets/js/' . $file;

        if (!file_exists($path)) {
            return false;
        }

        wp_enqueue_script(
            $handle,
            $uri,
            $deps,
            filemtime($path),
            $in_footer
        );

        return true;
    }
}

if (!function_exists('enqueue_vendor_scripts')) {
    function enqueue_vendor_scripts()
    {
        /**
         * 1. SplitText.js
         *
         * Location:
         * /assets/js/SplitText.js
         */
        enqueue_script_file(
            'splittext-js',
            'SplitText.js',
            array('gsap-js')
        );

        /**
         * 2. wow.min.js
         *
         * Location:
         * /assets/js/wow.min.js
         */
        enqueue_script_file(
            'wow-js',
            'wow.min.js'
        );

        /**
         * 3. validator.min.js
         *
         * Location:
         * /assets/js/validator.min.js
         */
        enqueue_script_file(
            'validator-js',
            'validator.min.js',
            array('jquery')
        );

        /**
         * 4. isotope.min.js
         *
         * Location:
         * /assets/js/isotope.min.js
         */
        enqueue_script_file(
            'isotope-js',
            'isotope.min.js',
            array('jquery')
        );

        /**
         * 5. jquery.waypoints.min.js
         *
         * Location:
         * /assets/js/jquery.waypoints.min.js
         */
        enqueue_script_file(
            'waypoints-js',
            'jquery.waypoints.min.js',
            array('jquery')
        );

        /**
         * 6. jquery.counterup.min.js
         *
         * Location:
         * /assets/js/jquery.counterup.min.js
         */
        enqueue_script_file(
            'counterup-js',
            'jquery.counterup.min.js',
            array('jquery', 'waypoints-js')
        );

        /**
         * 7. jquery.magnific-popup.min.js
         *
         * Location:
         * /assets/js/jquery.magnific-popup.min.js
         */
        enqueue_script_file(
            'magnific-popup-js',
            'jquery.magnific-popup.min.js',
            array('jquery')
        );

        /**
         * 8. jquery.mb.YTPlayer.min.js
         *
         * Location:
         * /assets/js/jquery.mb.YTPlayer.min.js
         */
        enqueue_script_file(
            'ytplayer-js',
            'jquery.mb.YTPlayer.min.js',
            array('jquery')
        );

        /**
         * 9. jquery.slicknav.js
         *
         * Location:
         * /assets/js/jquery.slicknav.js
         */
        enqueue_script_file(
            'slicknav-js',
            'jquery.slicknav.js',
            array('jquery')
        );

        /**
         * 10. parallaxie.js
         *
         * Location:
         * /assets/js/parallaxie.js
         */
        enqueue_script_file(
            'parallaxie-js',
            'parallaxie.js',
            array('jquery')
        );

        /**
         * 11. SmoothScroll.js
         *
         * Location:
         * /assets/js/SmoothScroll.js
         */
        enqueue_script_file(
            'smoothscroll-js',
            'SmoothScroll.js'
        );
        /**
         * 12. magiccursor.js
         *
         * Location:
         * /assets/js/magiccursor.js
         */
        enqueue_script_file(
            'magiccursor-js',
            'magiccursor.js',
            array('jquery', 'gsap-js')
        );
    }
}

add_action('wp_enqueue_scripts', 'enqueue_vendor_scripts', 30);
