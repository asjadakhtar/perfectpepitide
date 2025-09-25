<?php
/**
 * WordPress Support Functions
 * 
 * Enables the following WordPress features
 * with proper configuration
 *
 * @package TheTriibe
 * @version 1.0.0
 */

/*
 * WordPress Active Support
 */
function wordpress_active() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'custom-logo' );
	register_nav_menus(
		array(
			'left-header-menu' => esc_html__( 'Left Header Menu', 'main' ),
			'right-header-menu' => esc_html__( 'Right Header Menu', 'main' ),
			'brand-menu' => esc_html__( 'Brand Menu', 'footer' ),
			'service-menu' => esc_html__( 'Service Menu', 'footer' ),
        )
	);
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
}
add_action( 'after_setup_theme', 'wordpress_active' );

/*
 * Allow SVG and WebP uploads
 */
add_filter( 'upload_mimes', function( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['webp'] = 'image/webp';
	return $mimes;
} );

// Sanitize SVG files on upload (only for admins)
add_filter( 'wp_handle_upload_prefilter', function( $file ) {
	if (
		isset( $file['type'] ) &&
		$file['type'] === 'image/svg+xml' &&
		current_user_can( 'administrator' )
	) {
		// Sanitize using built-in filter if you install a library like enshrined/svg-sanitizer
		// Or optionally warn the user if you're not sanitizing
	} elseif ( $file['type'] === 'image/svg+xml' ) {
		$file['error'] = 'Only administrators can upload SVG files.';
	}
	return $file;
} );

/**
 * Simple SVG Icon Loader
 * The function returns the SVG content as a string
 * 
 * The folder that contains the icons is theme/assets/icons
 */
function get_svg($icon_name, $class = '') {
    $filepath = THEME_DIR . "/assets/icons/{$icon_name}.svg";
    
    if (!file_exists($filepath)) {
        return '';
    }

    // Retrieve SVG content with basic XSS prevention
    $svg_content = file_get_contents($filepath);
    $svg_content = preg_replace('/<script[\s\S]*?>[\s\S]*?<\/script>/i', '', $svg_content);
    
    // Add class if provided
    if (!empty($class)) {
        $svg_content = str_replace('<svg', "<svg class='{$class}'", $svg_content);
    }
    
    return $svg_content;
}

// Remove the WooCommerce styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Convert WooCommerce variation dropdown to buttons
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'hy_convert_variation_dropdown_to_buttons', 20, 2 );
function hy_convert_variation_dropdown_to_buttons( $html, $args ) {
    if ( ! isset( $args['options'], $args['attribute'] ) ) return $html;
    
    $options   = $args['options'];
    $attribute = $args['attribute'];
    $product   = $args['product'];
    $name      = esc_attr( $attribute );
    $id        = esc_attr( $attribute );
    $selected  = isset( $args['selected'] ) ? $args['selected'] : '';

    if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
        $attributes = $product->get_variation_attributes();
        $options    = $attributes[ $attribute ];
    }

    if ( empty( $options ) ) return $html;

    $buttons = '<div class="hy-variation-buttons" data-attribute_name="attribute_' . esc_attr( $attribute ) . '">';
    foreach ( $options as $option ) {
        $selected_class = sanitize_title( $selected ) === sanitize_title( $option ) ? ' selected' : '';
        $buttons .= '<button type="button" class="hy-variation-button' . $selected_class . '" data-value="' . esc_attr( $option ) . '">' . esc_html( $option ) . '</button>';
    }
    $buttons .= '</div>';

    // Hide original dropdown (for fallback/accessibility)
    $html = '<div class="hy-hidden-dropdown" style="display:none;">' . $html . '</div>' . $buttons;
    return $html;
}

// Add ACF Menu Item
add_filter('wp_nav_menu_objects', 'add_acf_to_menu_items', 10, 2);

function add_acf_to_menu_items($items, $args) {
    if (!function_exists('get_field')) {
        return $items;
    }
    
    $new_items = array();
    $acf_items = array();
    
    foreach ($items as $item) {
        $new_items[] = $item;
        
        // Get ACF fields for this menu item
        $menu_data = get_field('hy_menu', $item);
        
        // Check if fields exist and are not empty
        if ($menu_data && 
            (!empty($menu_data['image']) || !empty($menu_data['title']) || !empty($menu_data['subtitle']))) {
            
            // Create custom menu item with all required properties
            $custom_item = new stdClass();
            $custom_item->ID = 'acf-' . $item->ID;
            $custom_item->db_id = 0;
            $custom_item->menu_item_parent = $item->ID;
            $custom_item->object_id = 0;
            $custom_item->object = 'custom';
            $custom_item->type = 'custom';
            $custom_item->type_label = 'Custom';
            $custom_item->title = '';
            $custom_item->url = '#';
            $custom_item->target = '';
            $custom_item->attr_title = '';
            $custom_item->description = '';
            $custom_item->classes = array('menu-item-acf');
            $custom_item->xfn = '';
            $custom_item->menu_order = 9999;
            
            // Store ACF data
            $custom_item->acf_image = $menu_data['image'];
            $custom_item->acf_title = $menu_data['title'];
            $custom_item->acf_subtitle = $menu_data['subtitle'];
            
            // Store for later to add at end
            $acf_items[] = $custom_item;
        }
    }
    
    // Add ACF items at the end
    return array_merge($new_items, $acf_items);
}

// Custom walker to display ACF fields
add_filter('wp_nav_menu_args', 'use_acf_walker');

function use_acf_walker($args) {
    $args['walker'] = new ACF_Walker();
    return $args;
}

class ACF_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', $classes);
        
        $output .= '<li class="' . $class_names . '">';
        
        // Check if this is our ACF item
        if (in_array('menu-item-acf', $classes)) {
            // Display ACF content only if fields exist
            if (!empty($item->acf_image)) {
                $output .= '<img src="' . $item->acf_image['url'] . '" alt="' . $item->acf_image['alt'] . '">';
            }
			if (!empty($item->acf_title)) {
				$output .= '<h3>' . $item->acf_title . '</h3>';
			}
			if (!empty($item->acf_subtitle)) {
				$output .= '<p>' . $item->acf_subtitle . '</p>';
			}
        } else {
            // Regular menu item
            $output .= '<a href="' . $item->url . '">' . $item->title . '</a>';
        }
    }
}

// Single Page Quantity controller
add_action('woocommerce_before_add_to_cart_quantity', 'custom_quantity_minus_button');
add_action('woocommerce_after_add_to_cart_quantity', 'custom_quantity_plus_button');

function custom_quantity_minus_button() {
    global $product;
    if ( ! $product->is_sold_individually() ) {
        echo '<div class="quantity-wrapper"><button type="button" class="qty-btn qty-minus">-</button>';
    }
}

function custom_quantity_plus_button() {
    global $product;
    if ( ! $product->is_sold_individually() ) {
        echo '<button type="button" class="qty-btn qty-plus">+</button></div>';
    }
}

// Single Page
add_filter('woocommerce_hide_invisible_variations', '__return_false');

add_filter('woocommerce_product_single_add_to_cart_text', 'change_add_to_cart_text');
function change_add_to_cart_text() {
    return 'Book an Appointment';
}

add_action('woocommerce_before_single_variation', 'add_size_guide_next_to_sizes', 10);
function add_size_guide_next_to_sizes() {
    ?>
    <div id="sizeGuideBtn" class="flex items-center gap-2 text-base font-medium text-black font-secondary cursor-pointer mb-11 hover:bg-[rgba(0,0,0,0.05)] transition-all duration-300 p-2 rounded underline w-fit">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5563 1.41421C16.3374 0.633165 17.6037 0.633165 18.3848 1.41421L22.6274 5.65685C23.4085 6.4379 23.4085 7.70423 22.6274 8.48528L8.48527 22.6274C7.70422 23.4085 6.43789 23.4085 5.65684 22.6274L1.4142 18.3848C0.633153 17.6037 0.633154 16.3374 1.4142 15.5563L15.5563 1.41421ZM16.2634 3.53553C16.654 3.14501 17.2871 3.14501 17.6777 3.53553L20.5061 6.36396C20.8966 6.75449 20.8966 7.38765 20.5061 7.77817L19.799 7.07107C19.4085 6.68054 18.7753 6.68054 18.3848 7.07107C17.9942 7.46159 17.9942 8.09476 18.3848 8.48528L19.0919 9.19239L17.6777 10.6066L15.5563 8.48528C15.1658 8.09476 14.5326 8.09476 14.1421 8.48528C13.7516 8.87581 13.7516 9.50897 14.1421 9.89949L16.2634 12.0208L14.8492 13.435L14.1421 12.7279C13.7516 12.3374 13.1184 12.3374 12.7279 12.7279C12.3374 13.1184 12.3374 13.7516 12.7279 14.1421L13.435 14.8492L12.0208 16.2635L9.89948 14.1421C9.50896 13.7516 8.87579 13.7516 8.48527 14.1421C8.09475 14.5327 8.09475 15.1658 8.48527 15.5563L10.6066 17.6777L9.19238 19.0919L8.48527 18.3848C8.09475 17.9943 7.46158 17.9943 7.07106 18.3848C6.68053 18.7753 6.68053 19.4085 7.07106 19.799L7.77816 20.5061C7.38764 20.8966 6.75447 20.8966 6.36395 20.5061L3.53552 17.6777C3.145 17.2871 3.145 16.654 3.53552 16.2635L16.2634 3.53553Z" fill="#0F0F0F"/>
        </svg>
        Size Guide
   </div>
    <?php
}

