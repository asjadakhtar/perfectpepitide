<?php
/**
 * Asset Management Functions
 * 
 * Handles the efficient loading of CSS and JavaScript files
 * with proper versioning and dependency management.
 *
 * @package TheTriibe
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Define asset paths and configurations
 */
define('THEME_ASSETS', [
    'css' => [
        'bebas' => [
            'path' => '/assets/fonts/bebas/stylesheet.css',
            'deps' => []
        ],
        'poppins' => [
            'path' => '/assets/fonts/poppins/stylesheet.css',
            'deps' => []
        ],
        'aos' => [
            'path' => '/node_modules/aos/dist/aos.css',
            'deps' => []
        ],
        'swiper' => [
            'path' => '/node_modules/swiper/swiper-bundle.min.css',
            'deps' => []
        ],
        'tailwind-output' => [
            'path' => '/assets/css/tailwind-output.css',
            'deps' => []
        ],
        'main' => [
            'path' => '/assets/css/custom.css',
            'deps' => []
        ]
    ],
    'js' => [
        'swiper' => [
            'path' => '/node_modules/swiper/swiper-bundle.min.js',
            'deps' => []
        ],
        'aos' => [
            'path' => '/node_modules/aos/dist/aos.js',
            'deps' => []
        ],
        'shared-btn' => [
            'path' => '/assets/js/shared-button.js',
            'deps' => ['jquery']
        ],
        'aos' => [
            'path' => '/node_modules/aos/dist/aos.js',
            'deps' => []
        ],
        'main' => [
            'path' => '/assets/js/custom.js',
            'deps' => ['jquery']
        ]
    ]
]);

/**
 * Enqueue stylesheet with proper version control
 */
function enqueue_theme_style($handle, $path, $deps = []) {
    $full_path = THEME_DIR . $path;
    
    if (!file_exists($full_path)) {
        return;
    }

    wp_enqueue_style(
        $handle,
        THEME_URI . $path,
        $deps,
        filemtime($full_path)
    );
}

/**
 * Enqueue script with proper version control
 */
function enqueue_theme_script($handle, $path, $deps = []) {
    $full_path = THEME_DIR . $path;
    
    if (!file_exists($full_path)) {
        return;
    }

    wp_enqueue_script(
        $handle,
        THEME_URI . $path,
        $deps,
        filemtime($full_path),
        true
    );
}

/**
 * Main enqueue function for all theme assets
 */
function enqueue_theme_assets() {
    // Enqueue Styles
    foreach (THEME_ASSETS['css'] as $handle => $asset) {
        enqueue_theme_style($handle, $asset['path'], $asset['deps']);
    }

    // Enqueue Scripts
    wp_enqueue_script('jquery');  // WordPress core jQuery
    foreach (THEME_ASSETS['js'] as $handle => $asset) {
        enqueue_theme_script($handle, $asset['path'], $asset['deps']);
    }

    // Localize Scripts
}
add_action('wp_enqueue_scripts', 'enqueue_theme_assets');

add_theme_support( 'woocommerce' );
