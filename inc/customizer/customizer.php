<?php
/**
 * Arctic Theme Customizer
 *
 * @package Arctic
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function arctic_customize_preview_js() {
	wp_enqueue_script( 'arctic_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'arctic_customize_preview_js' );

/**
 * [arctic_setting_default description]
 * @return [type] [description]
 */
function arctic_setting_default(){
	$settings = array(
		'footer_image'	=> get_template_directory_uri() . '/assets/images/footer-image.jpg',
	);

	return apply_filters( 'arctic_setting_default', $settings );
}

/**
 * Load Customizer Setting.
 */
require get_template_directory() . '/inc/customizer/sanitization-callbacks.php';
require get_template_directory() . '/inc/customizer/setting-general.php';

/**
 * Arctic custom logo, header and background
 */
function arctic_custom_logo_header_and_background(){

	/** Enable support for custom logo */
	add_theme_support( 'custom-logo', array(
		'width'       => 400,
		'height'      => 100,
		'flex-width'  => true,
		'flex-height' => false,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	/** Custom Header */
	add_theme_support( 'custom-header', apply_filters( 'arctic_custom_header_args', array(
		'width'       			=> 1600,
		'height'      			=> 1600,
		'default-image'          => '',
		'default-text-color'     => 'ffffff',
		'flex-width'             => true,
		'flex-height'            => true,
	) ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'arctic_custom_background_args', array(
		'default-color' 		=> 'eceff1',
		'default-repeat'        => 'no-repeat',
		'default-attachment'    => 'scroll',
	) ) );

}
add_action( 'after_setup_theme', 'arctic_custom_logo_header_and_background' );

/**
 * Print inline style
 *
 * @return string
 */
function arctic_add_inline_style(){

	$default = arctic_setting_default();

	$css= '';

	if ( is_singular() && has_post_thumbnail( get_the_id() ) ) {
		$image_id 	= get_post_thumbnail_id();
		$image 		= wp_get_attachment_image_src( $image_id, 'full' );
		$css .= '
			.hero-image {
				background-image: url("'. esc_url( $image[0] ) .'");
			}
		';
	}

	$term_id 	= ( is_archive() ) ? get_queried_object()->term_id : '';
	if ( is_archive() && $term_id ) {
		$image_id 	= get_term_meta( $term_id, 'image', true );
		$image 		= wp_get_attachment_image_src( $image_id, 'full' );
		$css .= '
			.hero-image {
				background-image: url("'. esc_url( $image[0] ) .'");
			}
		';
	}

	$footer_image = get_theme_mod( 'footer_image', $default['footer_image'] );
	if ( !empty( $footer_image ) ) {
		$css .= '
			.footer-image {
				background-image: url("'. esc_url( $footer_image ) .'");
			}
		';
	}

    $css = str_replace( array( "\n", "\t", "\r" ), '', $css );

	if ( ! empty( $css ) ) {
		wp_add_inline_style( 'arctic-style', apply_filters( 'arctic_inline_style', trim( $css ) ) );
	}

}
add_action( 'wp_enqueue_scripts', 'arctic_add_inline_style' );

/**
 * [arctic_editor_style description]
 * @param  [type] $mceInit [description]
 * @return [type]          [description]
 */
function arctic_editor_style( $mceInit ) {

	$primary_text_color 	= get_theme_mod( 'primary_text_color', '#455a64' );
	$secondary_text_color 	= get_theme_mod( 'secondary_text_color', '#90a4ae' );
	$primary_color 			= get_theme_mod( 'primary_color', '#f06292' );
	$secondary_color 		= get_theme_mod( 'secondary_color', '#f7a8c2' );

	$styles = '';
	$styles .= '.mce-content-body{ color: ' . esc_attr( $primary_text_color ) . '; }';
	$styles .= '.mce-content-body a{ color: ' . esc_attr( $primary_color ) . '; }';
	$styles .= '.mce-content-body a:hover, .mce-content-body a:focus{ color: ' . esc_attr( $secondary_color ) . '; }';
	$styles .= '.mce-content-body ::selection{ background-color: ' . esc_attr( $secondary_color ) . '; }';
	$styles .= '.mce-content-body ::-mozselection{ background-color: ' . esc_attr( $secondary_color ) . '; }';

	if ( !isset( $mceInit['content_style'] ) ) {
		$mceInit['content_style'] = trim( $styles ) . ' ';
	} else {
		$mceInit['content_style'] .= ' ' . trim( $styles ) . ' ';
	}

	return $mceInit;

}
add_filter( 'tiny_mce_before_init', 'arctic_editor_style' );

