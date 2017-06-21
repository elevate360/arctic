<?php
/**
 * Arctic Theme Customizer
 *
 * @package Arctic Black
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function arctic_black_customize_preview_js() {
	wp_enqueue_script( 'arctic_black_customizer', get_template_directory_uri() . '/assets/js/customizer.min.js', array( 'customize-preview', 'customize-selective-refresh' ), '20151215', true );
}
add_action( 'customize_preview_init', 'arctic_black_customize_preview_js' );

/**
 * [arctic_black_setting_default description]
 * @return [type] [description]
 */
function arctic_black_setting_default(){
	$settings = array(
		'primary_color'		=> '#EC407A',
		'secondary_color'	=> '#F06292',
		'enable_slider'		=> false,
		'slider_cat'		=> '1',
		'slider_num'		=> 5,
		'slider_orderby'	=> 'date',
		'slider_order'		=> 'DESC',
		'post_date'			=> true,
		'post_author'		=> true,
		'post_cat'			=> true,
		'post_tag'			=> true,
		'author_display'	=> true,
		'posts_navigation'	=> 'posts_navigation',
		'footer_image'		=> get_template_directory_uri() . '/assets/images/footer-image.jpg',
	);

	return apply_filters( 'arctic_black_setting_default', $settings );
}

/**
 * Load Customizer Setting.
 */
require get_template_directory() . '/inc/customizer/sanitization-callbacks.php';
require get_template_directory() . '/inc/customizer/setting-general.php';

/**
 * Arctic custom logo, header and background
 */
function arctic_black_custom_logo_header_and_background(){

	/** Enable support for custom logo */
	add_theme_support( 'custom-logo', array(
		'width'       => 400,
		'height'      => 88,
		'flex-width'  => true,
		'flex-height' => false,
		'header-text' => array( 'site-title a', 'site-description' )
	) );

	/** Custom Header */
	add_theme_support( 'custom-header', apply_filters( 'arctic_black_custom_header_args', array(
		'width'       			=> 1600,
		'height'      			=> 1600,
		'default-image'          => '',
		'default-text-color'     => 'ffffff',
		'flex-width'             => true,
		'flex-height'            => true,
	) ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'arctic_black_custom_background_args', array(
		'default-color' 		=> 'ffffff',
		'default-repeat'        => 'no-repeat',
		'default-attachment'    => 'scroll',
	) ) );

}
add_action( 'after_setup_theme', 'arctic_black_custom_logo_header_and_background' );

/**
 * Print inline style
 *
 * @return string
 */
function arctic_black_add_inline_style(){

	$setting = arctic_black_setting_default();

	$css= '';

	if ( display_header_text() !== true ) {
		$css .= '
			.site-title a,
			.site-description {
				clip: rect(1px, 1px, 1px, 1px);
				position: absolute;
			}
		';
	}

	if ( get_header_textcolor() !== 'blank' ) {
		$css .= '
			.site-header a,
			.site-description,
			.main-navigation a,
			.main-navigation a:hover,
			.main-navigation a:focus,
			.main-navigation li.current_page_item > a,
			.main-navigation li.current-menu-item > a,
			.main-navigation li.current_page_ancestor > a,
			.main-navigation li.current-menu-ancestor > a {
				color: #'. esc_attr( get_header_textcolor() ) .';
			}
			.sidebar-toggle span,
			.sidebar-toggle span:before,
			.sidebar-toggle span:after,
			.sidebar-toggle:hover span,
			.sidebar-toggle:focus span,
			.sidebar-toggle:hover span:before,
			.sidebar-toggle:hover span:after,
			.sidebar-toggle:focus span:before,
			.sidebar-toggle:focus span:after {
				background-color: #'. esc_attr( get_header_textcolor() ) .';
			}
			.sidebar-toggled .sidebar-toggle span {
				background: transparent;
			}
		';
	}

	if ( is_singular() && has_post_thumbnail( get_the_id() ) ) {
		$image_id 	= get_post_thumbnail_id();
		$image 		= wp_get_attachment_image_src( $image_id, 'arctic-large' );
		$css .= '
			.hero-image {
				background-image: url("'. esc_url( $image[0] ) .'");
			}
		';
	}

	$term_id 	= ( is_archive() ) ? get_queried_object()->term_id : '';
	if ( is_archive() && $term_id ) {
		$image_id 	= get_term_meta( $term_id, 'image', true );
		$image 		= wp_get_attachment_image_src( $image_id, 'arctic-large' );
		$css .= '
			.hero-image {
				background-image: url("'. esc_url( $image[0] ) .'");
			}
		';
	}

	$footer_image = get_theme_mod( 'footer_image', $setting['footer_image'] );
	if ( !empty( $footer_image ) ) {
		$css .= '
			.footer-image {
				background-image: url("'. esc_url( $footer_image ) .'");
			}
		';
	}

	if ( get_theme_mod( 'post_date', $setting['post_date'] ) == false ) {
		$css .= '.entry-meta .posted-on{ display: none }';
	}

	if ( get_theme_mod( 'post_author', $setting['post_author'] ) == false ) {
		$css .= '.entry-meta .byline{ display: none }';
	}

	if ( get_theme_mod( 'post_cat', $setting['post_cat'] ) == false ) {
		$css .= '.entry-footer .cat-links{ display: none }';
	}

	if ( get_theme_mod( 'post_tag', $setting['post_tag'] ) == false ) {
		$css .= '.entry-footer .tags-links{ display: none }';
	}


	$primary_color = get_theme_mod( 'primary_color', $setting['primary_color'] );
	$primary_color_background_color = '
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		a.post-edit-link,
		.comment-body > .reply a,
		.sidebar-toggled .sidebar-toggle:hover span:before,
		.sidebar-toggled .sidebar-toggle:hover span:after,
		.sidebar-toggled .sidebar-toggle:focus span:before,
		.sidebar-toggled .sidebar-toggle:focus span:after,
		.page-numbers:hover:not(.current),
		.page-numbers:focus:not(.current),
		.widget_tag_cloud a:hover,
		.widget_tag_cloud a:focus
	';
	$primary_color_text_color = '
		a,
		.sticky-label,
		.widget_nav_menu a:hover,
		.widget_nav_menu a:focus,
		.widget_nav_menu li.current_page_item > a,
		.widget_nav_menu li.current-menu-item > a,
		.social-links ul a:hover,
		.social-links ul a:focus
	';

	$primary_color_border_color = '
		.widget_tag_cloud a:hover,
		.widget_tag_cloud a:focus
	';

	if ( $primary_color ) {
		$css .= sprintf( '%s{ background-color: %s }', $primary_color_background_color, esc_attr( $primary_color ) );
		$css .= sprintf( '%s{ color: %s }', $primary_color_text_color, esc_attr( $primary_color ) );
		$css .= sprintf( '%s{ border-color: %s }', $primary_color_border_color, esc_attr( $primary_color ) );
	}

	$secondary_color = get_theme_mod( 'secondary_color', $setting['secondary_color'] );
	$secondary_color_background_color = '
		button:hover,
		button:active,
		button:focus,
		input[type="button"]:hover,
		input[type="button"]:active,
		input[type="button"]:focus,
		input[type="reset"]:hover,
		input[type="reset"]:active,
		input[type="reset"]:focus,
		input[type="submit"]:hover,
		input[type="submit"]:active,
		input[type="submit"]:focus,
		a.post-edit-link:hover,
		a.post-edit-link:focus,
		.comment-body > .reply a:hover,
		.comment-body > .reply a:active,
		.comment-body > .reply a:focus
	';
	$secondary_color_text_color = '
		a:hover,
		a:focus,
		.featured-content .entry-title a:hover,
		.featured-content .entry-title a:focus,
		.home .site-main .entry-title a:hover,
		.home .site-main .entry-title a:focus,
		.archive .site-main .entry-title a:hover,
		.archive .site-main .entry-title a:focus,
		.entry-meta a:hover,
		.entry-meta a:focus,
		.cat-links a:hover,
		.cat-links a:focus,
		.tags-links a:hover,
		.tags-links a:focus,
		.comments-link a:hover,
		.comments-link a:focus,
		.comment-navigation a:hover,
		.comment-navigation a:focus,
		.posts-navigation a:hover,
		.posts-navigation a:focus,
		.post-navigation a:hover,
		.post-navigation a:focus,
		.comment-meta a:hover,
		.comment-meta a:focus,
		.author-title a:hover,
		.author-title a:focus,
		.site-footer a:hover,
		.site-footer a:focus
	';

	$secondary_color_border_color = '

	';

	if ( $secondary_color ) {
		$css .= sprintf( '%s{ background-color: %s }', $secondary_color_background_color, esc_attr( $secondary_color ) );
		$css .= sprintf( '%s{ color: %s }', $secondary_color_text_color, esc_attr( $secondary_color ) );
		//$css .= sprintf( '%s{ border-color: %s }', $secondary_color_border_color, esc_attr( $secondary_color ) );
		$css .= sprintf( '::selection{background-color:%1$s}::-moz-selection{background-color:%1$s}', esc_attr( $secondary_color ) );
	}

    $css = str_replace( array( "\n", "\t", "\r" ), '', $css );

	if ( ! empty( $css ) ) {
		wp_add_inline_style( 'arctic-style', apply_filters( 'arctic_black_inline_style', trim( $css ) ) );
	}

}
add_action( 'wp_enqueue_scripts', 'arctic_black_add_inline_style' );

/**
 * [arctic_black_customizer_style_placeholder description]
 * @return [type] [description]
 */
function arctic_black_customizer_style_placeholder(){
	if ( is_customize_preview() ) {
		echo '<style id="primary-color"></style>';
		echo '<style id="secondary-color"></style>';
	}
}
add_action( 'wp_head', 'arctic_black_customizer_style_placeholder', 15 );

/**
 * [arctic_black_editor_style description]
 * @param  [type] $mceInit [description]
 * @return [type]          [description]
 */
function arctic_black_editor_style( $mceInit ) {

	$primary_color 			= get_theme_mod( 'primary_color', '#f06292' );
	$secondary_color 		= get_theme_mod( 'secondary_color', '#f7a8c2' );

	$styles = '';
	$styles .= '.mce-content-body a{ color: ' . esc_attr( $primary_color ) . '; }';
	$styles .= '.mce-content-body a:hover, .mce-content-body a:focus{ color: ' . esc_attr( $secondary_color ) . '; }';
	$styles .= '.mce-content-body ::selection{ background-color: ' . esc_attr( $secondary_color ) . '; }';
	$styles .= '.mce-content-body ::-mozselection{ background-color: ' . esc_attr( $secondary_color ) . '; }';

	$styles = str_replace( array( "\n", "\t", "\r" ), '', $styles );

	if ( !isset( $mceInit['content_style'] ) ) {
		$mceInit['content_style'] = trim( $styles ) . ' ';
	} else {
		$mceInit['content_style'] .= ' ' . trim( $styles ) . ' ';
	}

	return $mceInit;

}
add_filter( 'tiny_mce_before_init', 'arctic_black_editor_style' );

