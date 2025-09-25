<?php
/*
 * Register Custom Post Types and Taxonomies from JSON
 * Author: Haroon Yamin
 * Author URI: https://www.linkedin.com/in/haroon-webdev/
**/

add_action('init', 'register_cpts_and_taxonomies_from_json');

function register_cpts_and_taxonomies_from_json() {
    $json_file = __DIR__ . '/register.json';

    if (!file_exists($json_file)) {
        return; // Exit if the file doesn't exist
    }

    $cpts = json_decode(file_get_contents($json_file), true);

    if (empty($cpts) || !is_array($cpts)) {
        return; // Exit if JSON is invalid or empty
    }

    foreach ($cpts as $cpt) {
        $post_type = $cpt['post_type'];
        $taxonomy_name = ''; // Initialize taxonomy name

        // Register Custom Taxonomy if it exists
        if (!empty($cpt['taxonomy'])) {
            $taxonomy_name = $cpt['taxonomy']['name'];
            register_taxonomy(
                $taxonomy_name,
                array($post_type),
                array(
                    'labels'            => $cpt['taxonomy']['labels'],
                    'hierarchical'      => true,
                    'public'            => true,
                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'show_in_nav_menus' => true,
                    'show_tagcloud'     => true,
                    'show_in_rest'      => true,
                )
            );
        }

        // Register Custom Post Type
        register_post_type($post_type, array(
            'show_in_rest' => true,
            'supports'     => $cpt['supports'],
            'rewrite'      => array('slug' => $cpt['slug']),
            'has_archive'  => true,
            'public'       => true,
            'taxonomies'   => !empty($taxonomy_name) ? array($taxonomy_name) : array(),
            'labels'       => $cpt['labels'],
            'menu_icon'    => $cpt['menu_icon']
        ));

        // NEW: Check if this CPT should have a "featured" option
        if (!empty($cpt['has_featured_option']) && $cpt['has_featured_option'] === true) {
            // Use a dynamic hook for adding the meta box to the specific post type
            add_action('add_meta_boxes_' . $post_type, 'add_featured_option_meta_box');
            
            // Use a dynamic hook for saving the meta data
            add_action('save_post_' . $post_type, 'save_featured_option_meta_data', 10, 2);
        }
    }
}

/**
 * Adds the "Featured" meta box to the post editor screen.
 */
function add_featured_option_meta_box($post) {
    add_meta_box(
        'featured_option_metabox',                  // Meta box ID
        'Featured Option',                          // Meta box title
        'featured_option_meta_box_html',            // Callback function to display the HTML
        $post->post_type,                           // The post type to show the box on
        'side',                                     // Context (where it appears)
        'default'                                   // Priority
    );
}

/**
 * Renders the HTML for the "Featured" meta box.
 */
function featured_option_meta_box_html($post) {
    // Use a nonce for verification
    wp_nonce_field('featured_option_nonce_action', 'featured_option_nonce');

    // Get the saved meta value
    $is_featured = get_post_meta($post->ID, '_is_featured', true);
    ?>
    <p>
        <input type="checkbox" id="featured_option_checkbox" name="featured_option_checkbox" value="1" <?php checked($is_featured, '1'); ?>>
        <label for="featured_option_checkbox">Mark this item as featured</label>
    </p>
    <?php
}

/**
 * Saves the "Featured" option meta data when the post is saved.
 */
function save_featured_option_meta_data($post_id, $post) {
    // Verify the nonce
    if (!isset($_POST['featured_option_nonce']) || !wp_verify_nonce($_POST['featured_option_nonce'], 'featured_option_nonce_action')) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Don't save on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check if the checkbox was checked
    $is_featured = isset($_POST['featured_option_checkbox']) ? '1' : '0';

    // Update the post meta
    update_post_meta($post_id, '_is_featured', $is_featured);
}