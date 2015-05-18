<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Isquar
 */
?>
	</div><!-- #main -->
	<footer id="colophon" class="site-footer" role="contentinfo">
			<?php get_sidebar( 'footer' ); ?>
			
		<p id="copyright-text"><?php isquar_copyright_text(); ?> </p>
		<div class="site-info">
			<?php do_action( 'isquar_credits' ); ?>

		<?php if( isquar_get_option( 'theme_credit_link' ) ) : ?>
			<p class="footer-credits">
				<?php $theme_credit_link = '<a href="' . esc_url( 'http://sandipbhagat.com.np/isquar-free-wordpress-theme' ) . '" title="' . esc_attr( __( 'Isquar Theme', 'isquar' ) ) . '">' . __( 'Isquar Theme', 'isquar' ) . '</a>'; ?>
				<?php if( isquar_get_option( 'theme_credit_link' ) )  : ?>
					<?php echo sprintf( __( 'Powered by %1$s', 'isquar' ), $theme_credit_link ); ?>
				<?php endif; ?>
			</p>
		<?php endif; ?>
		</div><!-- .site-info -->
		<div class="clear"></div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>