<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Isquar
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function isquar_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'isquar_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function isquar_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'isquar_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function isquar_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'isquar_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function isquar_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'isquar' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'isquar_wp_title', 10, 2 );

/**
 * Filters excerpt_length for a custom excerpt length.
 *
 */
	
function isquar_excerpt_length($length){
	$custom_excerpt_length= isquar_get_option('custom_excerpt_length');
	
	return $custom_excerpt_length ;
}
add_filter('excerpt_length','isquar_excerpt_length');

/**
 * Filters excerpt_more for a custom read more link.
 *
 */
function isquar_read_more_link($more){
	$custom_readmore= isquar_get_option('custom_readmore');
	global $post;
	return '<a href="'. get_permalink($post->ID).'" class="more-link">'. $custom_readmore .' </a>';
}
add_filter('excerpt_more','isquar_read_more_link');
	
/**
 * To link all Post Thumbnails to the Post Permalink
 *
 */
add_filter( 'post_thumbnail_html', 'isquar_post_image_html', 10, 3 );

function isquar_post_image_html( $html, $post_id, $post_image_id ) {

  $html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html . '</a>';
  return $html;

}
