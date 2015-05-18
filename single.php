<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Isquar
 */
GLOBAL $isquar_options; 
get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>
		
			<?php isquar_content_nav( 'nav-below' ); ?>
			
	<div class="clear"></div>
	<div id="author_bio">
		<div class="author_text">
			<h4><?php echo esc_html(__('About Author', 'isquar')); ?></h4>
			<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '75' );  } ?>
		    <h4><span>
			<?php 
			
			echo sprintf(__('<a href="%1$s" title="%2$s">%3$s</a>'),
					esc_url(get_author_posts_url( get_the_author_meta( 'ID' ))),
					esc_attr(__('Post Author', 'isquar' )),
					esc_attr(__(get_the_author_meta('display_name'), 'isquar' ))
				);
			?>
			</span></h4>
			<p><?php echo esc_html(the_author_meta('description')); ?></p>
		</div>
	</div>
	
	<div class="clear"></div>
			
			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>