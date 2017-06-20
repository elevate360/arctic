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

	$setting = arctic_setting_default();

	// Arctic Theme Setting Panel
	$wp_customize->add_panel( 'theme_settings', array(
		'title' 		=> __( 'Theme Settings', 'arctic' ),
		'priority' 		=> 199,
	) );

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

	/** WP */
	$wp_customize->get_section( 'header_image' )->panel 				= 'theme_settings';
	$wp_customize->get_section( 'background_image' )->panel 			= 'theme_settings';
	$wp_customize->get_section( 'colors' )->panel 						= 'theme_settings';


	/** Theme Colors */
	$wp_customize->add_setting(
		'primary_color',
		array(
			'default'           => $setting['primary_color'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
		'primary_color',
		array(
			'label'       	=> __( 'Link Color', 'arctic' ),
			'description'	=> __( 'Used for link, button ', 'arctic' ),
			'section'     	=> 'colors',
			'setting'		=> 'primary_color',
			'priority'		=> 99
	) ) );

	$wp_customize->add_setting(
		'secondary_color',
		array(
			'default'           => $setting['secondary_color'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
		'secondary_color',
		array(
			'label'       	=> __( 'Hover Color', 'arctic' ),
			'description'	=> __( 'Used for link:hover, button:hover, selection.', 'arctic' ),
			'section'     	=> 'colors',
			'setting'		=> 'secondary_color',
			'priority'		=> 99
	) ) );


	/** Slider Settings */
	$wp_customize->add_section(
		'content_slider' ,
		array(
			'title' 			=> __( 'Content Slider', 'arctic' ),
			'priority' 			=> 200,
			'panel'				=> 'theme_settings'
	) );

	$wp_customize->add_setting(
		'enable_slider' ,
		 array(
		    'default' 			=> $setting['enable_slider'],
		    'sanitize_callback' => 'arctic_sanitize_checkbox',
	) );

	$wp_customize->add_control(
		'enable_slider',
		array(
			'label'    => __( 'Enable Content Slider', 'arctic' ),
			'section'  => 'content_slider',
			'settings' => 'enable_slider',
			'type'     => 'checkbox'
		)
	);

	$wp_customize->add_setting(
		'slider_cat',
		array(
			'default'           => $setting['slider_cat'],
			'sanitize_callback' => 'arctic_sanitize_select',
	) );

	$wp_customize->add_control(
		'slider_cat',
		array(
			'label'    => __( 'Select Category', 'arctic' ),
			'section'  => 'content_slider',
			'setting'  => 'slider_cat',
			'type'     => 'select',
			'choices'  => arctic_get_terms( 'category' )
	) );

	$wp_customize->add_setting(
		'slides_num' ,
		 array(
		    'default' 			=> $setting['slider_num'],
		    'sanitize_callback' => 'arctic_sanitize_number_absint',
	) );

	$wp_customize->add_control(
		'slides_num',
		array(
			'label'    => __( 'Number of posts to display', 'arctic' ),
			'section'  => 'content_slider',
			'settings' => 'slides_num',
			'type'     => 'number',
		    'input_attrs' => array(
		        'min'   => 1,
		        'max'   => 99,
		    )
		)
	);

	$wp_customize->add_setting(
		'slider_orderby',
		array(
			'default'           => $setting['slider_orderby'],
			'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control(
		'slider_orderby',
		array(
			'label'    => __( 'Orderby', 'arctic' ),
			'section'  => 'content_slider',
			'setting'  => 'slider_orderby',
			'type'     => 'select',
			'choices'  => array(
				'ID'  			=> esc_attr__( 'Post ID', 'arctic' ),
				'author' 		=> esc_attr__( 'Author', 'arctic' ),
				'date'			=> esc_attr__( 'Date', 'arctic' ),
				'title' 		=> esc_attr__( 'Title', 'arctic' ),
				'comment_count'	=> esc_attr__( 'Comment count', 'arctic' ),
				'modified'		=> esc_attr__( 'Last Modified Date', 'arctic' ),
				'rand'			=> esc_attr__( 'Random', 'arctic' ),
			),
	) );

	$wp_customize->add_setting(
		'slider_order',
		array(
			'default'           => $setting['slider_order'],
			'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control(
		'slider_order',
		array(
			'label'    => __( 'Orderby', 'arctic' ),
			'section'  => 'content_slider',
			'setting'  => 'slider_order',
			'type'     => 'select',
			'choices'  => array(
				'ASC'  	=> esc_attr__( 'Lowest to highest values', 'arctic' ),
				'DESC' 	=> esc_attr__( 'Highest to lowest values', 'arctic' ),
			),
	) );


	// Archive Setting
	$wp_customize->add_section(
		'blog_section' ,
		array(
			'title' 			=> __( 'Blog Setting', 'arctic' ),
			'priority' 			=> 200,
			'panel'				=> 'theme_settings'
	) );

	$wp_customize->add_setting(
		'post_date' ,
		 array(
		    'default' 			=> $setting['post_date'],
		    'transport'			=> 'postMessage',
		    'sanitize_callback' => 'arctic_sanitize_checkbox',
	) );

	$wp_customize->add_control(
		'post_date',
		array(
			'label'    => __( 'Display Post Date', 'arctic' ),
			'section'  => 'blog_section',
			'settings' => 'post_date',
			'type'     => 'checkbox'
		)
	);

	$wp_customize->add_setting(
		'post_author' ,
		 array(
		    'default' 			=> $setting['post_author'],
		    'transport'			=> 'postMessage',
		    'sanitize_callback' => 'arctic_sanitize_checkbox',
	) );

	$wp_customize->add_control(
		'post_author',
		array(
			'label'    => __( 'Display Post Author', 'arctic' ),
			'section'  => 'blog_section',
			'settings' => 'post_author',
			'type'     => 'checkbox'
		)
	);

	$wp_customize->add_setting(
		'post_cat' ,
		 array(
		    'default' 			=> $setting['post_cat'],
		    'transport'			=> 'postMessage',
		    'sanitize_callback' => 'arctic_sanitize_checkbox',
	) );

	$wp_customize->add_control(
		'post_cat',
		array(
			'label'    => __( 'Display Post Category', 'arctic' ),
			'section'  => 'blog_section',
			'settings' => 'post_cat',
			'type'     => 'checkbox'
		)
	);

	$wp_customize->add_setting(
		'post_tag' ,
		 array(
		    'default' 			=> $setting['post_tag'],
		    'transport'			=> 'postMessage',
		    'sanitize_callback' => 'arctic_sanitize_checkbox',
	) );

	$wp_customize->add_control(
		'post_tag',
		array(
			'label'    => __( 'Display Post Tag', 'arctic' ),
			'section'  => 'blog_section',
			'settings' => 'post_tag',
			'type'     => 'checkbox'
		)
	);

	$wp_customize->add_setting(
		'author_display' ,
		 array(
		    'default' 			=> $setting['author_display'],
		    'transport'			=> 'postMessage',
		    'sanitize_callback' => 'arctic_sanitize_checkbox',
	) );

	$wp_customize->add_control(
		'author_display',
		array(
			'label'    => __( 'Display Author biography at single post', 'arctic' ),
			'section'  => 'blog_section',
			'settings' => 'author_display',
			'type'     => 'checkbox'
		)
	);

	$wp_customize->add_setting(
		'posts_navigation',
		array(
			'default'           => $setting['posts_navigation'],
			'sanitize_callback' => 'arctic_sanitize_select',
			'transport'         => 'postMessage',
	) );

	$wp_customize->add_control(
		'posts_navigation',
		array(
			'label'    => __( 'Posts Navigation', 'arctic' ),
			'section'  => 'blog_section',
			'setting'  => 'posts_navigation',
			'type'     => 'select',
			'choices'  => array(
				'posts_navigation' 	=> esc_attr__( 'Prev / Next', 'arctic' ),
				'posts_pagination' 	=> esc_attr__( 'Numeric', 'arctic' ),
			),
	) );


	// Footer Widgets
	$wp_customize->add_section(
		'footer_area' ,
		array(
			'title' 			=> __( 'Footer', 'arctic' ),
			'priority' 			=> 200,
			'panel'				=> 'theme_settings'
	) );

	$wp_customize->add_setting(
		'footer_image',
		array(
			'default'           => $setting['footer_image'],
			'sanitize_callback' => 'arctic_sanitize_image',
			'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
		'footer_image',
		array(
			'label'      => __( 'Footer widgets background', 'arctic' ),
			'section'    => 'footer_area',
			'settings'   => 'footer_image',
	) ) );

	$wp_customize->add_setting(
		'footer_copyright' ,
		 array(
		    'default' 			=> '',
		    'transport'			=> 'postMessage',
		    'sanitize_callback' => 'arctic_sanitize_html',
	) );

	$wp_customize->add_control(
		'footer_copyright',
		array(
			'label'    		=> __( 'Footer copyright', 'arctic' ),
			'description'	=> __( 'Use [YEAR] for dynamic current year.', 'arctic' ),
			'section'  		=> 'footer_area',
			'settings' 		=> 'footer_copyright',
			'type'     		=> 'textarea'
		)
	);

    if ( isset( $wp_customize->selective_refresh ) ) {

		$wp_customize->selective_refresh->add_partial(
			'posts_navigation',
			array(
				'selector' 				=> array( '.navigation.posts-navigation', '.navigation.pagination' ),
				'settings' 				=> array( 'posts_navigation' ),
				'render_callback' 		=> 'arctic_posts_navigation',
				'container_inclusive'	=> true,
		) );

		$wp_customize->selective_refresh->add_partial(
			'footer_copyright',
			array(
				'selector' 				=> '.site-info',
				'settings' 				=> array( 'footer_copyright' ),
				'render_callback' 		=> 'arctic_do_footer_copyright',
				'container_inclusive'	=> false,
		) );

    }

}
add_action( 'customize_register', 'arctic_customize_register' );
