<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Bootstrap Theme' );
define( 'CHILD_THEME_URL', 'http://www.avidnetizen.com/' );
define( 'CHILD_THEME_VERSION', '2.0.1' );

add_action( 'wp_enqueue_scripts', 'genesis_bootstrap_style' );
function genesis_bootstrap_style() {
        wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.css' );
        wp_enqueue_style( 'bootstrap-responsive', get_stylesheet_directory_uri() . '/css/bootstrap-responsive.css' );
		wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'), 'v3.0.0', true );
}

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Remove site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );