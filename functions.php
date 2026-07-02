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
);

foreach ($plana_theme_includes as $plana_theme_include) {
    require_once get_stylesheet_directory() . '/' . $plana_theme_include;
}
