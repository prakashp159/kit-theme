<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package KIT_Theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function kit_theme_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'kit_theme_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function kit_theme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'kit_theme_pingback_header' );

/**
 * Register a custom post type called "phone-app".
 *
 * @see get_post_type_labels() for label keys.
 */
function kit_theme_phone_app_init() {
	$labels = array(
		'name'                  => _x( 'Phone Apps', 'Post type general name', 'kit_theme' ),
		'singular_name'         => _x( 'Phone App', 'Post type singular name', 'kit_theme' ),
		'menu_name'             => _x( 'Phone Apps', 'Admin Menu text', 'kit_theme' ),
		'name_admin_bar'        => _x( 'Phone App', 'Add New on Toolbar', 'kit_theme' ),
		'add_new'               => __( 'Add New', 'kit_theme' ),
		'add_new_item'          => __( 'Add New Phone App', 'kit_theme' ),
		'new_item'              => __( 'New Phone App', 'kit_theme' ),
		'edit_item'             => __( 'Edit Phone App', 'kit_theme' ),
		'view_item'             => __( 'View Phone App', 'kit_theme' ),
		'all_items'             => __( 'All Phone Apps', 'kit_theme' ),
		'search_items'          => __( 'Search Phone Apps', 'kit_theme' ),
		'parent_item_colon'     => __( 'Parent Phone Apps:', 'kit_theme' ),
		'not_found'             => __( 'No Phone Apps found.', 'kit_theme' ),
		'not_found_in_trash'    => __( 'No Phone Apps found in Trash.', 'kit_theme' ),
		'featured_image'        => _x( 'Phone App Cover Image', 'Overrides the "Featured Image" phrase for this post type. Added in 4.3', 'kit_theme' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the "Set featured image" phrase for this post type. Added in 4.3', 'kit_theme' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the "Remove featured image" phrase for this post type. Added in 4.3', 'kit_theme' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the "Use as featured image" phrase for this post type. Added in 4.3', 'kit_theme' ),
		'archives'              => _x( 'Phone App archives', 'The post type archive label used in nav menus. Default "Post Archives". Added in 4.4', 'kit_theme' ),
		'insert_into_item'      => _x( 'Insert into Phone App', 'Overrides the "Insert into post"/"Insert into page" phrase (used when inserting media into a post). Added in 4.4', 'kit_theme' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Phone App', 'Overrides the "Uploaded to this post"/"Uploaded to this page" phrase (used when viewing media attached to a post). Added in 4.4', 'kit_theme' ),
		'filter_items_list'     => _x( 'Filter Phone Apps list', 'Screen reader text for the filter links heading on the post type listing screen. Default "Filter posts list"/"Filter pages list". Added in 4.4', 'kit_theme' ),
		'items_list_navigation' => _x( 'Phone Apps list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default "Posts list navigation"/"Pages list navigation". Added in 4.4', 'kit_theme' ),
		'items_list'            => _x( 'Phone Apps list', 'Screen reader text for the items list heading on the post type listing screen. Default "Posts list"/"Pages list". Added in 4.4', 'kit_theme' ),
	);
 
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'phone-app' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-smartphone',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	);
 
	register_post_type( 'phone-apps', $args );

	unset( $args );
	unset( $labels );

	// Add new taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'              => _x( 'Operating Systems', 'taxonomy general name', 'kit_theme' ),
		'singular_name'     => _x( 'Operating System', 'taxonomy singular name', 'kit_theme' ),
		'search_items'      => __( 'Search Operating Systems', 'kit_theme' ),
		'all_items'         => __( 'All Operating Systems', 'kit_theme' ),
		'parent_item'       => __( 'Parent Operating System', 'kit_theme' ),
		'parent_item_colon' => __( 'Parent Operating System:', 'kit_theme' ),
		'edit_item'         => __( 'Edit Operating System', 'kit_theme' ),
		'update_item'       => __( 'Update Operating System', 'kit_theme' ),
		'add_new_item'      => __( 'Add New Operating System', 'kit_theme' ),
		'new_item_name'     => __( 'New Operating System Name', 'kit_theme' ),
		'menu_name'         => __( 'Operating System', 'kit_theme' ),
	);
 
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'operating-system' ),
	);
 
	register_taxonomy( 'operating-systems', array( 'phone-apps' ), $args );
}
add_action( 'init', 'kit_theme_phone_app_init' );

/**
 * Callback function for phone apps filter
 */
function kit_theme_phone_apps_filter() {
	get_template_part( 'template-parts/content', 'phone-apps-list' );
	die();
}
add_action( 'wp_ajax_phone_apps_filter', 'kit_theme_phone_apps_filter' );
add_action( 'wp_ajax_nopriv_phone_apps_filter', 'kit_theme_phone_apps_filter' );
