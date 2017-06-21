<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Arctic Black
 */

$setting = arctic_black_setting_default();
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php if ( get_theme_mod( 'footer-image', $setting['footer_image'] ) !== '' ) :?>
			<div class="footer-image"></div>
		<?php endif;?>

		<?php get_sidebar( 'footer' );?>

		<?php get_template_part( 'template-parts/footer', 'social' );?>

		<p class="site-info">
			<?php arctic_black_do_footer_copyright();?>
		</p><!-- .site-info -->
		<p class="site-design">
			<?php echo sprintf( __( 'Theme design by %s.', 'arctic-black' ), '<a href="'. esc_url( 'https://elevate360.com.au/' ) .'">Elevate</a>' );?>
		</p>

	</footer><!-- #colophon -->

	<?php get_sidebar( 'after-footer' );?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
