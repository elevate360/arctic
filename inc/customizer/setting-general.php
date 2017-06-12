<?php
/**
 * Setting general
 *
 * @package Arctic
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function arctic_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         		= 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  		= 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport 		= 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport 			= 'postMessage';
	$wp_customize->get_setting( 'header_image_data'  )->transport 		= 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport 		= 'postMessage';
	$wp_customize->get_setting( 'background_image' )->transport 		= 'postMessage';
	$wp_customize->get_setting( 'background_repeat' )->transport 		= 'postMessage';
	$wp_customize->get_setting( 'background_position_x' )->transport 	= 'postMessage';
	$wp_customize->get_setting( 'background_attachment' )->transport 	= 'postMessage';

}
add_action( 'customize_register', 'arctic_customize_register' );
