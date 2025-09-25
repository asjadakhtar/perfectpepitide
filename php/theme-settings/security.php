<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Disable file editing from admin
 */
if ( is_admin() ) {
	define( 'DISALLOW_FILE_EDIT', true );
	// define( 'DISALLOW_FILE_MODS', true );
}

/**
 * Remove WordPress version number
 */
add_filter( 'the_generator', '__return_empty_string' );
add_action( 'wp_enqueue_scripts', function() {
	remove_action( 'wp_head', 'wp_generator' );
});

/**
 * Hide login errors for brute force protection
 */
add_filter( 'login_errors', '__return_empty_string' );

/**
 * Disable XML-RPC (commonly abused)
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

/**
 * Disable REST API for non-logged-in users
 */
add_filter( 'rest_authentication_errors', function( $result ) {
	if ( ! is_user_logged_in() ) {
		return new WP_Error( 'rest_not_logged_in', 'REST API restricted to authenticated users.', array( 'status' => 401 ) );
	}
	return $result;
});

/**
 * Disable user enumeration via ?author=1
 */
add_action( 'init', function() {
	if ( isset( $_REQUEST['author'] ) ) {
		wp_die( 'Forbidden', 'Access Denied', 403 );
	}
});

/**
 * Secure headers (limited, add server-level too)
 */
add_action( 'send_headers', function() {
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'X-XSS-Protection: 1; mode=block' );
	header( 'Referrer-Policy: no-referrer-when-downgrade' );
});
