<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Arctic
 */

if ( ! function_exists( 'arctic_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function arctic_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'arctic' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'arctic' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'arctic_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function arctic_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'arctic' ) );
		if ( $categories_list && arctic_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'arctic' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'arctic' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'arctic' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'arctic' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'arctic' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function arctic_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'arctic_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'arctic_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so arctic_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so arctic_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in arctic_categorized_blog.
 */
function arctic_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'arctic_categories' );
}
add_action( 'edit_category', 'arctic_category_transient_flusher' );
add_action( 'save_post',     'arctic_category_transient_flusher' );

if ( ! function_exists( 'arctic_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 */
function arctic_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

if( ! function_exists( 'arctic_do_breadcrumb' ) ) :
/**
 * [arctic_do_breadcrumb description]
 * @return [type] [description]
 */
function arctic_do_breadcrumb(){

	$breadcrumb_markup_open = '<div id="breadcrumb" typeof="BreadcrumbList" vocab="http://schema.org/">';
	$breadcrumb_markup_close = '</div>';

	if ( function_exists( 'bcn_display' ) ) {
		echo $breadcrumb_markup_open;
		bcn_display();
		echo $breadcrumb_markup_close;
	}
	elseif ( function_exists( 'breadcrumbs' ) ) {
		breadcrumbs();
	}
	elseif ( function_exists( 'crumbs' ) ) {
		crumbs();
	}
	elseif ( class_exists( 'WPSEO_Breadcrumbs' ) ) {
		yoast_breadcrumb( $breadcrumb_markup_open, $breadcrumb_markup_close );
	}
	elseif( function_exists( 'yoast_breadcrumb' ) && ! class_exists( 'WPSEO_Breadcrumbs' ) ) {
		yoast_breadcrumb( $breadcrumb_markup_open, $breadcrumb_markup_close );
	}

}
endif;

if ( ! function_exists( 'arctic_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 */
function arctic_post_thumbnail( $size = 'post-thumbnail') {

	if ( is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) {
		echo '<div class="post-thumbnail">';
		the_post_thumbnail( $size );
		echo '</div>';
	} else {
		echo '<div class="post-thumbnail">';
			echo '<a href="'. get_permalink( get_the_id() ) .'">';
				the_post_thumbnail( $size );
			echo '</a>';
		echo '</div>';
	}

}
endif;

if ( !function_exists( 'arctic_posts_navigation' ) ) :
/**
 * [arctic_posts_navigation description]
 * @return [type] [description]
 */
function arctic_posts_navigation(){

	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		return;
	}

	if ( get_theme_mod( 'posts_navigation', 'posts_navigation' ) == 'posts_navigation' ) {
		the_posts_navigation( array(
            'prev_text'          => __( '&larr; Older posts', 'arctic' ),
            'next_text'          => __( 'Newer posts &rarr;', 'arctic' ),
		) );
	} else {
		the_posts_pagination( array(
			'prev_text'          => __( '<span class="fa fa-angle-left"></span><span class="screen-reader-text">Previous Page</span>', 'arctic' ),
			'next_text'          => __( '<span class="fa fa-angle-right"></span><span class="screen-reader-text">Next Page</span>', 'arctic' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'arctic' ) . ' </span>',
		) );
	}

}
endif;

if ( ! function_exists( 'arctic_footer_copyright' ) ) :
/**
 * [arctic_footer_copyright description]
 * @return [type] [description]
 */
function arctic_footer_copyright(){

	$footer_copyright =	sprintf( __( 'Copyright &copy; %1$s %2$s. Proudly powered by %3$s.', 'arctic' ),
		date_i18n( __('Y', 'arctic' ) ),
		'<a href="'. esc_url( home_url() ) .'">'. esc_attr( get_bloginfo( 'name' ) ) .'</a>',
		'<a href="'. esc_url( 'https://wordpress.org/' ) .'">WordPress</a>' );

	echo apply_filters( 'arctic_footer_copyright', $footer_copyright );

}
endif;

if ( ! function_exists( 'arctic_do_footer_copyright' ) ) :
/**
 * Render footer copyright
 *
 * @return string
 */
function arctic_do_footer_copyright(){

	$footer_copyright = get_theme_mod( 'footer_copyright' );

	if ( !empty( $footer_copyright ) ) {
		$footer_copyright = str_replace( '[YEAR]', date_i18n( __('Y', 'arctic' ) ), $footer_copyright );
		echo esc_attr( $footer_copyright );
	} else {
		arctic_footer_copyright();
	}

}
endif;
