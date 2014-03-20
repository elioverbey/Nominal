<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme 
define( 'CHILD_THEME_NAME', 'Nominal Theme' );
define( 'CHILD_THEME_URL', 'http://elioverbey.net' );
define( 'CHILD_THEME_VERSION', '1.0' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'Nominal_enqueue_scripts_styles' );
function Nominal_enqueue_scripts_styles() {

	wp_enqueue_script( 'Nominal-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'Nominal-google-fonts', '//fonts.googleapis.com/css?family=Montserrat|Sorts+Mill+Goudy', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Merriweather:400,700|Lato:300,400,900', array(), CHILD_THEME_VERSION );

}

//* Add new featured image sizes
add_image_size( 'featured', 740, 200, TRUE );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Unregister secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Reduce the primary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'Nominal_primary_menu_args' );
function Nominal_primary_menu_args( $args ){

	if( 'primary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Hooks after-entry widget area to single posts
add_action( 'genesis_before_footer', 'my_enews_widget'  ); 
function my_enews_widget() {
 
    if ( ! is_singular( 'post' ) )
    	return;
 
    genesis_widget_area( 'enews-widget', array(
		'before' => '<div class="enews-widget widget-area"><div class="wrap">',
		'after'  => '</div></div>',
    ) );
 
}

//* Remove support for 3-column footer widgets
remove_theme_support( 'genesis-footer-widgets', 1 );

//* Remove the entry meta in the entry footer (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_date] [post_author_posts_link]';
	return $post_info;
}

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

/** Remove default sidebar */
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

/** Remove secondary sidebar */
unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'footer-widgets',
	'footer',
) );


/** Add post navigation (requires HTML5 support) */
add_action( 'genesis_after_entry_content', 'genesis_prev_next_post_nav', 10 );

//* Register Email Widget
genesis_register_sidebar( array(
	'id'          => 'enews-widget',
	'name'        => __( 'ENews Widget', 'nominal' ),
	'description' => __( 'This is the widget for Enews', 'nominal' ),
) );