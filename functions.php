<?php
/**
 * Isquar functions and definitions
 *
 * @package Isquar
 */

 /* 
 * Load the theme options page if in admin mode
 */
if ( is_admin() && is_readable( get_template_directory() . '/inc/theme-option.php' ) )
	require_once( get_template_directory() . '/inc/theme-option.php' );
 
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'isquar_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
		function isquar_setup() {
		
	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Isquar, use a find and replace
	 * to change 'isquar' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'isquar', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	
	add_image_size( 'isquar-slider-image', 960, 350, true );
	

	// Allows users to set a custom background

	$defaults = array(
		'default-color'          => '#D9D9D9',
		'default-image'          => '',
	);
	add_theme_support( 'custom-background', $defaults );
	
	
	// Styles the post editor
	add_editor_style();
	
	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'isquar' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	// add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif; // isquar_setup
add_action( 'after_setup_theme', 'isquar_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function isquar_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'isquar' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar', 'isquar' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'isquar_widgets_init' );

/**
 * Enqueue scripts and styles
 */

function isquar_scripts() {
	wp_enqueue_style( 'Isquar-style', get_stylesheet_uri() );

	wp_enqueue_script( 'Isquar-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_style( 'Isquar-icon-fonts', get_template_directory_uri() . '/css/genericons.css' );
	
	wp_enqueue_script( 'Isquar-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
		
 	if( is_home() && ! is_paged() ) {
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/flexslider.min.js', array( 'jquery' ), null, true );
	} 
	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'Isquar-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
	
}
add_action( 'wp_enqueue_scripts', 'isquar_scripts' );

function isquar_slider_script() {
?>
<?php if( is_home() && ! is_paged() ) : ?>
<script>
 jQuery(document).ready(function($){
	$('.flexslider').flexslider({
		selector          : '.slides > li',
		animation         : 'slide',
		easing            : 'swing',
		direction         : 'horizontal',
		animationLoop     : true,
		smoothHeight       : true,
		startAt           : 0,
		slideshow         : true,
		slideshowSpeed    : 7000,
		animationSpeed    : 600,
		initDelay         : 0,
		pauseOnAction     : true,
		pauseOnHover      : true,
		before: function() {
		$('.flexslider .flex-caption').hide();
		},
		after: function() {
		$('.flexslider .flex-caption').fadeIn();
		}
	});
	});
	

</script>
<?php endif;
}
add_action ('wp_head', 'isquar_slider_script');

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );


if ( ! function_exists( 'isquar_default_options' ) ) :

/**
 * Returns an array of theme default options.
 *
 */
function isquar_default_options() {
	$options = array(
		'custom_readmore' => 'Read More',
		'custom_excerpt_length' => 100,
		'older_post_label' => 'Older Posts',
		'newer_post_label' => 'Newer Posts',
		'default_search_text' => 'Type Your Text Here',
		'search_button_text' => 'Search',
		'copyright_text' => '&copy; %year% %blogname%',
		'theme_credit_link' => true,
		'slider_disable' => true,
		'slider_cat' => 1,
		'slider_post_no' => 3,
		'site_margin_left' => '2%',
		'site_margin_right' => '2%',
		'content_area_width' => '67.75%',
		'widget_area_width' => '29.61%',
	);
	return $options;
}
endif;

if ( ! function_exists( 'isquar_get_option' ) ) :
/**
 * Used to output theme options is an elegant way
 *
 * @uses get_option() To retrieve the options array
 *
 */
function isquar_get_option( $option ) {
	global $isquar_options, $isquar_default_options;
	if( ! isset( $isquar_default_options ) )
		$isquar_default_options = isquar_default_options();
	if( ! isset( $isquar_options ) )
		$isquar_options = get_option( 'isquar_theme_options', $isquar_default_options );
	if( ! isset( $isquar_options[ $option ] ) )
		return $isquar_default_options[ $option ];
	return $isquar_options[ $option ];
}
endif;

if ( ! function_exists( 'isquar_copyright_text' ) ) :
/**
 * Display copyright text in the footer section
 *
 */
function isquar_copyright_text() {
	$copyright = isquar_get_option( 'copyright_text' );
	$copyright = str_replace( '%year%', date( 'Y' ), $copyright );
	$copyright = str_replace( '%blogname%', get_bloginfo( 'name' ), $copyright );
	echo esc_html( $copyright );
}
endif;

function isquar_custom_styles() {
?>
<style type="text/css">
	@media screen and (min-width: 600px) {
	#page {
	margin-left:<?php echo isquar_get_option('site_margin_left'); ?>;
	margin-right:<?php echo isquar_get_option('site_margin_right'); ?>;
	}
	
	.content-area {
	width:<?php echo isquar_get_option('content_area_width'); ?>;
	}
	
	.site-main .widget-area {
    width:<?php echo isquar_get_option('widget_area_width'); ?>;
	}
}
</style>
<?php
}
add_action( 'wp_head', 'isquar_custom_styles' );