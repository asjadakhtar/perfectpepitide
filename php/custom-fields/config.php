<?php
/*
 * Custom Fields Blocks Registration
 */
function register_acf_block($name, $title, $description, $template, $keywords) {
    acf_register_block(array(
        'name' => 'acf/' . $name,
        'title' => __($title),
        'description' => __($description),
        'render_template' => THEME_DIR . '/php/custom-fields/blocks/' . $template . '.php',
        'category' => 'formatting',
        'icon' => 'testimonial',
        'keywords' => array($name, $keywords, 'section'),
    ));
}

function blocks_from_json() {
    if (function_exists('acf_register_block')) {
        $json_file = __DIR__ . '/register.json';

        // Load and decode JSON
        if (file_exists($json_file)) {
            $blocks = json_decode(file_get_contents($json_file), true);

            // Register each block from the JSON file
            foreach ($blocks as $block) {
                register_acf_block(
                    $block['name'],
                    $block['title'],
                    $block['description'],
                    $block['template'],
                    $block['keywords'],
                );
            }
        }
    }
}
add_action('acf/init', 'blocks_from_json');

// Include Option Pages
require_once get_template_directory() . '/php/custom-fields/options.php';