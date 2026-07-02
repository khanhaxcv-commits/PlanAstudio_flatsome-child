<?php

$plana_theme_includes = array(
    'inc/cleanup.php',
    'inc/fonts.php',
    'inc/assets.php',
    'inc/breadcrumbs.php',
    'inc/blog.php',
    'inc/blog-category.php',
    'inc/blog-single.php',
    'inc/preloader.php',
    'inc/migration.php',
);

foreach ($plana_theme_includes as $plana_theme_include) {
    $plana_theme_file = get_stylesheet_directory() . '/' . $plana_theme_include;

    if (file_exists($plana_theme_file)) {
        require_once $plana_theme_file;
    }
}
