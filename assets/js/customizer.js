/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $, api ) {

	// Site title and description.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	api( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description, .main-navigation a, .sidebar-toggle span, .sidebar-toggle span:before, .sidebar-toggle span:after' ).css( {
					'color': to
				} );
			}
		} );
	} );


	// Post Meta
	api( 'post_date', function( value ) {
		value.bind( function( to ) {
			if ( true === to ) {
				$( '.entry-meta .posted-on' ).css( {
					'display': 'inline-block'
				} );
			} else {
				$( '.entry-meta .posted-on' ).css( {
					'display': 'none'
				} );
			}
		} );
	} );

	api( 'post_author', function( value ) {
		value.bind( function( to ) {
			if ( true === to ) {
				$( '.entry-meta .byline' ).css( {
					'display': 'inline-block'
				} );
			} else {
				$( '.entry-meta .byline' ).css( {
					'display': 'none'
				} );
			}
		} );
	} );

	api( 'post_cat', function( value ) {
		value.bind( function( to ) {
			if ( true === to ) {
				$( '.entry-footer .cat-links' ).css( {
					'display': 'inline-block'
				} );
			} else {
				$( '.entry-footer .cat-links' ).css( {
					'display': 'none'
				} );
			}
		} );
	} );

	api( 'post_tag', function( value ) {
		value.bind( function( to ) {
			if ( true === to ) {
				$( '.entry-footer .tags-links' ).css( {
					'display': 'inline-block'
				} );
			} else {
				$( '.entry-footer .tags-links' ).css( {
					'display': 'none'
				} );
			}
		} );
	} );

	api( 'author_display', function( value ) {
		value.bind( function( to ) {
			if ( true === to ) {
				$( '.author-info' ).css( {
					'display': 'inline-block'
				} );
			} else {
				$( '.author-info' ).css( {
					'display': 'none'
				} );
			}
		} );
	} );

	api( 'footer_image', function( value ) {
		value.bind( function( to ) {
			$( '.footer-image' ).css( {
				'background-image': 'url(' + to + ')'
			} );
		} );
	} );

	api( 'primary_color', function( value ){
		value.bind( function( to ) {
			var primaryColorBgColor 	= 'button, input[type="button"], input[type="reset"], input[type="submit"], a.post-edit-link, .comment-body > .reply a, .sidebar-toggled .sidebar-toggle:hover span:before, .sidebar-toggled .sidebar-toggle:hover span:after, .sidebar-toggled .sidebar-toggle:focus span:before, .sidebar-toggled .sidebar-toggle:focus span:after, .page-numbers:hover:not(.current), .page-numbers:focus:not(.current), .widget_tag_cloud a:hover, .widget_tag_cloud a:focus',
				primaryColorTextColor 	= 'a, .widget_nav_menu a:hover, .widget_nav_menu a:focus, .widget_nav_menu li.current_page_item > a, .widget_nav_menu li.current-menu-item > a, .social-links ul a:hover, .social-links ul a:focus',
				primaryColorBorderColor = '.widget_tag_cloud a:hover,.widget_tag_cloud a:focus';

			$( '#primary-color' ).text( primaryColorBgColor + '{background-color:'+ to +'}' + primaryColorTextColor + '{color:'+ to +'}' + primaryColorBorderColor + '{border-color:'+ to +'}' );
		} );
	} );

	api( 'secondary_color', function( value ){
		value.bind( function( to ) {
			var secondaryColorBgColor 	= 'button:hover, button:active, button:focus, input[type="button"]:hover, input[type="button"]:active, input[type="button"]:focus, input[type="reset"]:hover, input[type="reset"]:active, input[type="reset"]:focus, input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus, a.post-edit-link:hover, a.post-edit-link:focus, .comment-body > .reply a:hover, .comment-body > .reply a:active, .comment-body > .reply a:focus',
				secondaryColorTextColor = 'a:hover, a:focus, .featured-content .entry-title a:hover, .featured-content .entry-title a:focus, .home .site-main .entry-title a:hover, .home .site-main .entry-title a:focus, .archive .site-main .entry-title a:hover, .archive .site-main .entry-title a:focus, .entry-meta a:hover, .entry-meta a:focus, .cat-links a:hover, .cat-links a:focus, .tags-links a:hover, .tags-links a:focus, .comments-link a:hover, .comments-link a:focus, .comment-navigation a:hover, .comment-navigation a:focus, .posts-navigation a:hover, .posts-navigation a:focus, .post-navigation a:hover, .post-navigation a:focus, .comment-meta a:hover, .comment-meta a:focus, .author-title a:hover, .author-title a:focus, .site-footer a:hover, .site-footer a:focus',
				secondaryColorBorderColor = '.widget_tag_cloud a:hover,.widget_tag_cloud a:focus';

			$( '#secondary-color' ).text( secondaryColorBgColor + '{background-color:'+ to +'}' + secondaryColorTextColor + '{color:'+ to +'}' + secondaryColorBorderColor + '{border-color:'+ to +'}' );
		} );
	} );

    api.selectiveRefresh.bind( 'sidebar-updated', function( sidebarPartial ) {

        if ( 'sidebar-4' === sidebarPartial.sidebarId ) {

			if ( jQuery().slick ) {

				$( '#quaternary .instagram-pics' ).not('.slick-initialized').slick({
					infinite: true,
					dots: false,
					adaptiveHeight: false,
					slidesToShow: 8,
					slidesToScroll: 1,
					autoplay: true,
					autoplaySpeed: 5000,
					arrows: false,
					responsive: [
						{
							breakpoint: 960,
							settings: {
								slidesToShow: 6
							}
						},
						{
							breakpoint: 768,
							settings: {
								slidesToShow: 4
							}
						},
						{
							breakpoint: 480,
							settings: {
								slidesToShow: 2
							}
						}
					]
				});

				$( window ).resize();

			}
        }

    } );

} )( jQuery, wp.customize );
