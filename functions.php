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

//* Register home page widgets
/** Register widget areas */
genesis_register_sidebar( array(
	'id'			=> 'jumbotron',
	'name'			=> __( 'Jumbotron', 'genesis-bootstrap' ),
	'description'	=> __( 'This is the jumbotron section.', 'genesis-bootstrap' ),
	'before_widget' => genesis_markup( array(
		'html5' => '<div class="container"><section id="%1$s" class="widget %2$s jumbotron"><div class="widget-wrap jumbotron">',
		'xhtml' => '<div class="container"><div id="%1$s" class="widget %2$s jumbotron"><div class="widget-wrap jumbotron">',
		'echo'  => false,
	) ),
	'after_widget'  => genesis_markup( array(
		'html5' => '</div></section></div>' . "\n",
		'xhtml' => '</div></div></div>' . "\n",
		'echo'  => false
	) ),
	'before_title'  => '<h1 class="widget-title widgettitle">',
	'after_title'   => "</h1>\n",
) );
genesis_register_sidebar( array(
	'id'			=> 'home-middle-1',
	'name'			=> __( 'Home Middle #1', 'genesis-bootstrap' ),
	'description'	=> __( 'This is the first column of the home middle section.', 'genesis-bootstrap' ),
	'before_title'  => '<h2 class="widget-title widgettitle">',
	'after_title'   => "</h2>\n",
) );
genesis_register_sidebar( array(
	'id'			=> 'home-middle-2',
	'name'			=> __( 'Home Middle #2', 'genesis-bootstrap' ),
	'description'	=> __( 'This is the second column of the home middle section.', 'genesis-bootstrap' ),
	'before_title'  => '<h2 class="widget-title widgettitle">',
	'after_title'   => "</h2>\n",
) );
genesis_register_sidebar( array(
	'id'			=> 'home-middle-3',
	'name'			=> __( 'Home Middle #3', 'genesis-bootstrap' ),
	'description'	=> __( 'This is the third column of the home middle section.', 'genesis-bootstrap' ),
	'before_title'  => '<h2 class="widget-title widgettitle">',
	'after_title'   => "</h2>\n",
) );

//* Add .container
add_action( 'genesis_before', 'child_site_container' );
function child_site_container() {
	echo '<div class="container">';
}

//* Remove header-right sidebar
unregister_sidebar( 'header-right' );

//* Remove site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Add masthead class to header
add_filter( 'genesis_attr_site-header', 'child_attributes_header' );
function child_attributes_header( $attributes ) {
	
	$attributes['class']  = 'site-header masthead';

	return $attributes;

}

//* Add .muted class to title
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
add_action( 'genesis_site_title', 'child_seo_site_title' );
function child_seo_site_title() {

	//* Set what goes inside the wrapping tags
	$inside = sprintf( '<a href="%s" title="%s">%s</a>', trailingslashit( home_url() ), esc_attr( get_bloginfo( 'name' ) ), get_bloginfo( 'name' ) );

	//* Determine which wrapping tags to use
	$wrap = 'h3';

	//* Build the title
	$title  = genesis_html5() ? sprintf( "<{$wrap} %s>", genesis_attr( 'site-title' ) ) : sprintf( '<%s id="title">%s</%s>', $wrap, $inside, $wrap );
	$title .= genesis_html5() ? "{$inside}</{$wrap}>" : '';

	//* Echo (filtered)
	echo apply_filters( 'genesis_seo_title', $title, $inside, $wrap );

}

//* Add .text-muted to title
add_filter( 'genesis_attr_site-title', 'child_attributes_site_title' );

function child_attributes_site_title( $attributes ) {

	$attributes['class'] = 'text-muted';

	return $attributes;

}

//* Add collapse button
add_action( 'genesis_header', 'child_collapse_button' );
function child_collapse_button() {
	echo '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>';
}

//* Add .nav and .nav-justified class to menu-primary
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'child_do_nav' );
function child_do_nav() {

	//* Do nothing if menu not supported
	if ( ! genesis_nav_menu_supported( 'primary' ) )
		return;

	//* If menu is assigned to theme location, output
	if ( has_nav_menu( 'primary' ) ) {

		$class = 'menu genesis-nav-menu menu-primary nav nav-justified';
		if ( genesis_superfish_enabled() )
			$class .= ' js-superfish';

		$args = array(
			'theme_location' => 'primary',
			'container'      => '',
			'menu_class'     => $class,
			'echo'           => 0,
		);

		$nav = wp_nav_menu( $args );

		//* Do nothing if there is nothing to show
		if ( ! $nav )
			return;

		$nav_markup_open = genesis_markup( array(
			'html5'   => '<div id="navbar-collapse" class="collapse navbar-collapse"><nav %s>',
			'xhtml'   => '<div class="collapse navbar-collapse" id="nav">',
			'context' => 'nav-primary',
			'echo'    => false,
		) );
		$nav_markup_open .= genesis_structural_wrap( 'menu-primary', 'open', 0 );

		$nav_markup_close  = genesis_structural_wrap( 'menu-primary', 'close', 0 );
		$nav_markup_close .= genesis_html5() ? '</nav></div>' : '</div>';

		$nav_output = $nav_markup_open . $nav . $nav_markup_close;

		echo apply_filters( 'genesis_do_nav', $nav_output, $nav, $args );

	}

}

//* Unregister secondary menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );

//* Move breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_after_header', 'genesis_do_breadcrumbs' );

//* Add row to content-sidebar-wrap
add_action( 'genesis_before_content_sidebar_wrap', 'child_before_content_sidebar_wrap');
function child_before_content_sidebar_wrap() {
	echo '<div class="row container">';
}
//* add_action( 'genesis_after_content_sidebar_wrap', 'child_after_content_sidebar_wrap' );
function child_after_content_sidebar_wrap() {
	echo '</div>';
}
/* Special class rule

add_action( 'genesis_before_content', 'child_before_content' );
function child_before_content() {
	echo '<!-- -->';
}*/


//* Dynamically change class of content

add_action( 'genesis_before_loop', 'child_before_loop' );
function child_before_loop() {
	$classes = get_body_class();
	if ( in_array( 'content-sidebar', $classes ) ) {
		echo '<div class="col-sm-8">';
	}
	if ( in_array( 'sidebar-content', $classes ) ) {
		echo '<div class="col-sm-8 col-sm-push-4">';
	}
	if ( in_array( 'content-sidebar-sidebar', $classes ) ) {
		echo '<div class="col-sm-6">';
	}
	if ( in_array( 'sidebar-sidebar-content', $classes ) ) {
		echo '<div class="col-sm-6 col-sm-push-6">';
	}
	if ( in_array( 'sidebar-content-sidebar', $classes ) ) {
		echo '<div class="col-sm-6 col-sm-push-2">';
	}
}
add_action( 'genesis_after_loop', 'child_after_loop' );
function child_after_loop() {
	echo '</div>';
}
//* Add col class to sidebars
add_filter( 'genesis_attr_sidebar-primary', 'child_attributes_sidebar_primary' );
function child_attributes_sidebar_primary( $attributes ) {
	$classes = get_body_class();
	$attributes['class']     = 'sidebar sidebar-primary widget-area col-sm-4';
	
	if ( in_array( 'sidebar-sidebar-content', $classes ) ) {
		$attributes['class']     = 'sidebar sidebar-primary widget-area col-sm-4 col-sm-pull-4';
	}
	if ( in_array( 'sidebar-content', $classes ) ) {
		$attributes['class']     = 'sidebar sidebar-primary widget-area col-sm-4 col-sm-pull-8';
	}
	if ( in_array( 'sidebar-content-sidebar', $classes ) ) {
		$attributes['class']     = 'sidebar sidebar-primary widget-area col-sm-4 col-sm-push-2';
	}
	
	return $attributes;
}
add_filter( 'genesis_attr_sidebar-secondary', 'child_attributes_sidebar_secondary' );
function child_attributes_sidebar_secondary( $attributes ) {
	$classes = get_body_class();
	$attributes['class']     = 'sidebar sidebar-secondary widget-area col-sm-2 col-sm-pull-10';
	if ( in_array( 'sidebar-sidebar-content', $classes ) ) {
		$attributes['class']     = 'sidebar sidebar-primary widget-area col-sm-2 col-sm-pull-10';
	}
	return $attributes;

}
//* Close row before footer
add_action( 'genesis_before_footer', 'child_close_site_inner' );
function child_close_site_inner() {
	echo '</div>';
}
//* Close row before footer
add_action( 'genesis_after_footer', 'child_close_container' );
function child_close_container() {
	echo '</div>';
}
//* Markup footer
add_filter( 'genesis_attr_site-footer', 'child_attributes_site_footer' );
function child_attributes_site_footer( $attributes ) {

	$attributes['class']      = 'site-footer footer';
	return $attributes;
}

//* Put author box in a well
add_filter( 'genesis_attr_author-box', 'child_attributes_author_box' );
function child_attributes_author_box( $attributes ) {

	$attributes['class']  = 'author-box well';

	return $attributes;

}

//* Remove Genesis search form
remove_filter( 'get_search_form', 'genesis_search_form' );

//* Modify footer output
add_filter( 'genesis_footer_output', 'child_output_filter' );
function child_output_filter( $backtotop_text, $creds_text ) {
	$backtotop_text = '';
	$creds_text     = '<p>Copyright © ' . date('Y') . ' · <a href="http://www.avidnetizen.com/" title="Genesis Bootstrap Theme">Genesis Bootstrap Theme</a> on <a href="http://www.avidnetizen.com/go/genesis" title="Genesis Framework">Genesis Framework</a> · <a href="http://wordpress.org/" title="WordPress">WordPress</a></p>';
		return $creds_text;

	echo apply_filters( 'genesis_footer_output', $output, $backtotop_text, $creds_text );
}