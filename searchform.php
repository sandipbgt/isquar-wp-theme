<?php
/**
 * The template for displaying search forms in Isquar
 *
 * @package Isquar
 */
?>
	<form method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<label for="s" class="screen-reader-text"><?php _ex( 'Search', 'assistive text', 'isquar' ); ?></label>
		<input type="search" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo esc_attr_x( ''.isquar_get_option('default_search_text').'', 'placeholder', 'isquar' ); ?>" />
		<input type="submit" class="submit" id="searchsubmit" value="<?php echo esc_attr_x( ''.isquar_get_option('search_button_text').'', 'submit button', 'isquar' ); ?>" />
	</form>
