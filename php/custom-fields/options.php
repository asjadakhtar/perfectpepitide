<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add ACF Options Pages
if ( function_exists( 'acf_add_options_page' ) ) {

	// Parent page: Theme Settings
	acf_add_options_page( array(
		'page_title'    => 'Theme Settings',
		'menu_title'    => 'Theme Settings',
		'menu_slug'     => 'theme-settings',
		'capability'    => 'edit_posts',
		'redirect'      => true, // Makes it redirect to first child
		'position'      => 30,
		'icon_url'      => 'dashicons-admin-generic'
	) );

	// Subpage: General
	acf_add_options_sub_page( array(
		'page_title'    => 'General Settings',
		'menu_title'    => 'General',
		'parent_slug'   => 'theme-settings',
		'menu_slug'     => 'theme-general',
	) );

	// Subpage: Header
	acf_add_options_sub_page( array(
		'page_title'    => 'Header Settings',
		'menu_title'    => 'Header',
		'parent_slug'   => 'theme-settings',
		'menu_slug'     => 'theme-header',
	) );

	// Subpage: Footer
	acf_add_options_sub_page( array(
		'page_title'    => 'Footer Settings',
		'menu_title'    => 'Footer',
		'parent_slug'   => 'theme-settings',
		'menu_slug'     => 'theme-footer',
	) );

	// Subpage: Footer
	acf_add_options_sub_page( array(
		'page_title'    => 'Section Settings',
		'menu_title'    => 'Sections',
		'parent_slug'   => 'theme-settings',
		'menu_slug'     => 'theme-sections',
	) );
}
