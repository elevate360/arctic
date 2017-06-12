/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
(function() {
	var isIe = /(trident|msie)/i.test( navigator.userAgent );

	if ( isIe && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
})();

( function() {
	var container, button, menu, body, links, subMenus;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	body = document.getElementsByTagName( 'body' )[0];


	button.onclick = function() {
		if ( -1 !== body.className.indexOf( 'sidebar-toggled' ) ) {
			body.className = body.className.replace( ' sidebar-toggled', ' sidebar-closed' );
		} else {
			body.className = body.className.replace( ' sidebar-closed', '' );
			body.className += ' sidebar-toggled';
		}
	};

} )();

/**
 * Plugins methode
 */
( function( $ ) {

	function smoothScroll(){
		$('a[href*="#content"]').click(function(event) {
	        // On-page links
	        if (
	            location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
	            location.hostname == this.hostname
	        ) {
	            // Figure out element to scroll to
	            var target = $(this.hash);
	            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
	            // Does a scroll target exist?
	            if (target.length) {
	                // Only prevent default if animation is actually gonna happen
	                event.preventDefault();
	                $('html, body').animate({
	                    scrollTop: target.offset().top
	                }, 500, function() {
	                    // Callback after animation
	                    // Must change focus!
	                    var $target = $(target);
	                    $target.focus();
	                    if ($target.is(":focus")) { // Checking if the target was focused
	                        return false;
	                    } else {
	                        $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
	                        $target.focus(); // Set focus again
	                    };
	                });
	            }
	        }
		});
	}

	function thumbFocus(){
		$( '.entry' ).find( 'a' ).on( 'hover focus blur', function( e ) {
			e.preventDefault();
			$( this ).parent().prev('.post-thumbnail').toggleClass( 'focus' );
		} );
	}

	function run_fitVids(){
		var vidElement = $( '#page' );
		vidElement.fitVids({
			customSelector: "iframe[src^='https://videopress.com']"
		});
	}

	function slick__featured_contents(){

		var prev__btn = '<button type="button" data-role="none" class="arctic-slick-prev" aria-label="Previous" tabindex="0" role="button">' + Arcticl10n.slick.prev_arrow + '</button>',
			next__btn = '<button type="button" data-role="none" class="arctic-slick-next" aria-label="Next" tabindex="0" role="button">' + Arcticl10n.slick.next_arrow + '</button>';

		$('.featured-content').not('.slick-initialized').slick({
			infinite: true,
			dots: true,
			adaptiveHeight: true,
			slidesToScroll: 1,
			fade: true,
			slidesToShow: Arcticl10n.slick.slides_to_show,
			autoplay: Arcticl10n.slick.autoplay,
			autoplaySpeed: Arcticl10n.slick.autoplay_speed,
			arrows: Arcticl10n.slick.arrow,
            dots: Arcticl10n.slick.dots,
            pauseOnHover: Arcticl10n.slick.pause_on_hover,
            pauseOnDotsHover: Arcticl10n.slick.pause_on_dots_hover,
            dotsClass: 'arctic-slick-dots',
            prevArrow: prev__btn,
            nextArrow: next__btn,
			responsive: [
				{
					breakpoint: 788,
					settings: {
						fade: true,
						slidesToShow: 1
					}
				}
			]
		});

	}

	function slick__instagram_footer() {

		$( '.instagram-footer ul' ).not('.slick-initialized').slick({
			infinite: true,
			dots: false,
			adaptiveHeight: false,
			slidesToShow: 8,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 5000,
			arrows: false,
			dots: false,
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

	}

	$(document).ready(function(){

		// Wrap table with div
		// $( 'table' ).wrap( '<div class="table-responsive"></div>' );

		smoothScroll();
		thumbFocus();
		run_fitVids();
		slick__featured_contents();
		slick__instagram_footer();
	});

	$( document.body ).on( 'post-load', function () {
		thumbFocus();
	});

})( jQuery );
