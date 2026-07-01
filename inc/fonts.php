<?php

add_action('wp_enqueue_scripts', 'plana_enqueue_google_fonts');
add_filter('wp_resource_hints', 'plana_google_fonts_resource_hints', 10, 2);

function plana_enqueue_google_fonts()
{
    wp_enqueue_style(
        'plana-font-body',
        'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100..900;1,100..900&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'plana-font-heading',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'plana-font-chuky',
        'https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap',
        array(),
        null
    );
}

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
