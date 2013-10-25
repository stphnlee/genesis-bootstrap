<?php

add_action( 'genesis_meta', 'genesis_bootstrap_home_genesis_meta' );
function genesis_bootstrap_home_genesis_meta() {
	if ( is_active_sidebar( 'jumbotron' ) || is_active_sidebar( 'home-middle-1' ) || is_active_sidebar( 'home-middle-2' ) || is_active_sidebar( 'home-middle-3' ) || is_active_sidebar( 'home-bottom-1' ) || is_active_sidebar( 'home-bottom-2' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'genesis_bootstrap_home_loop_helper' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

	}
}

function genesis_bootstrap_home_loop_helper() {

	if ( is_active_sidebar( 'jumbotron' ) ) {
		dynamic_sidebar( 'jumbotron' );
		echo '<!-- end .jumbotron -->';
	}
	echo '<div class="container">';
	echo '<div class="home-middle row">';
	
	if ( is_active_sidebar( 'home-middle-1' ) ) {
		echo '<div class="home-middle-1 col-md-4">';
		dynamic_sidebar( 'home-middle-1' );
		echo '</div><!-- end .home-middle-1 -->';
	}
	
	if ( is_active_sidebar( 'home-middle-2' ) ) {
		echo '<div class="home-middle-2 col-md-4">';
		dynamic_sidebar( 'home-middle-2' );
		echo '</div><!-- end .home-middle-2 -->';
	}
	
	if ( is_active_sidebar( 'home-middle-3' ) ) {
		echo '<div class="home-middle-3 col-md-4">';
		dynamic_sidebar( 'home-middle-3' );
		echo '</div><!-- end .home-middle-3 -->';
	}
	
	echo '</div><!-- end .home-middle -->';
	echo '</div><!-- end middle .row -->';
}

genesis();