<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Isquar
 */

get_header(); ?>

	<?php
		$slider_disable = isquar_get_option( 'slider_disable' );
		$cat_id = isquar_get_option( 'slider_cat' );
		$post_num = isquar_get_option( 'slider_post_no' );
		
		// for debugging
		//echo '<pre>'. print_r($isquar_options, true) .'</pre>';
	?>
	<?php if (is_home() && ! is_paged() ) :?>
		<?php $args = array (
				'cat' => $cat_id,
				'showposts' => $post_num	
			)
			?>
		<?php if( !$slider_disable) : ?>
		<?php $isquar_query = new WP_Query($args); ?>
		<?php if ( $isquar_query -> have_posts() ) : ?>
			<div class="flexslider">
			<ul class="slides">
			<?php while( $isquar_query->have_posts() ) : $isquar_query->the_post(); ?>
			
			<?php get_template_part( 'content', 'slider' ); ?>
			
			<?php endwhile; ?>
			
			</ul>
			</div> <!-- .slides -->
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
		<?php endif; ?>
		
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php isquar_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>