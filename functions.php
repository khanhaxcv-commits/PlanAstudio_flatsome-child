<?php

$theme_includes = array(
    'inc/cleanup.php',
    'inc/fonts.php',

    'inc/enqueue-theme-styles.php',
    'inc/enqueue-external-assets.php',
    'inc/enqueue-vendor-scripts.php',
    'inc/enqueue-theme-scripts.php',
    'inc/enqueue-fontawesome.php',

    'inc/breadcrumbs.php',
    'inc/blog.php',
    'inc/blog-category.php',
    'inc/blog-single.php',
    'inc/preloader.php',
    'inc/migration.php',
);

foreach ($theme_includes as $theme_include) {
    $theme_file = get_stylesheet_directory() . '/' . $theme_include;

    if (file_exists($theme_file)) {
        require_once $theme_file;
    }
}
