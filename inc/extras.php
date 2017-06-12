<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Arctic
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function arctic_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'arctic_body_classes' );

/**
 * Removes hentry class from the array of post classes.
 * Currently, having the class on pages is not correct use of hentry.
 * hentry requires more properties than pages typically have.
 * Core is not likely to remove class because of backward compatibility.
 * See: https://core.trac.wordpress.org/ticket/28482
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function arctic_post_classes( $classes ) {
	if ( 'page' === get_post_type() ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
	}
	$classes[] = 'entry';
	return $classes;
}
add_filter( 'post_class', 'arctic_post_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function arctic_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'arctic_pingback_header' );

/**
 * Add (Untitled) for post who doesn't have title
 * @param  string  $title
 * @return string
 */
function arctic_untitled_post( $title ) {

	// Translators: Used as a placeholder for untitled posts on non-singular views.
	if ( ! $title && ! is_singular() && in_the_loop() && ! is_admin() )
		$title = esc_html__( '(Untitled)', 'arctic' );

	return $title;
}
add_filter( 'the_title', 'arctic_untitled_post' );

/**
 * [arctic_mixcloud_oembed_parameter description]
 * @param  [type] $html [description]
 * @param  [type] $url  [description]
 * @param  [type] $args [description]
 * @return [type]       [description]
 */
function arctic_mixcloud_oembed_parameter( $html, $url, $args ) {
	return str_replace( 'hide_cover=1', 'hide_cover=1&hide_tracklist=1', $html );
}
