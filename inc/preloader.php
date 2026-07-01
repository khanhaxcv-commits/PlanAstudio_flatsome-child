<?php

add_action('wp_body_open', 'pcn_add_preloader');

function pcn_add_preloader()
{
    $theme_uri = get_stylesheet_directory_uri();
    ?>
    <!-- Preloader Start -->
    <div class="preloader">
        <div class="loading-container">
            <div class="loading"></div>
            <div id="loading-icon">
                <!-- <img src="<?php echo esc_url($theme_uri . '/assets/images/loader.svg'); ?>" alt="Loading"> -->
                <img src="https://img.lightshot.app/uTtkhNiTTH6W7y2Kpk2mEA.jpg" alt="Loading">
            </div>
        </div>
    </div>
    <!-- Preloader End -->
    <?php
}
