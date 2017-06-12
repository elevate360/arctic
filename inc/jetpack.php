<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package Arctic
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 */
function arctic_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'type'      		=> 'click',
		'container' 		=> 'main',
		'render'    		=> 'arctic_infinite_scroll_render',
		'footer_widgets'	=> array( 'sidebar-2', 'sidebar-3' ),
	) );
}
add_action( 'after_setup_theme', 'arctic_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function arctic_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content', 'search' );
		else :
			get_template_part( 'template-parts/content', 'home' );
		endif;
	}
}

/** Remove Jetpack Infinity Scroll CSS */
function arctic_deregister_jetpack_styles(){

	 wp_deregister_style( 'the-neverending-homepage' ); // Infinite Scroll

}
add_action( 'wp_print_styles', 'arctic_deregister_jetpack_styles' );
