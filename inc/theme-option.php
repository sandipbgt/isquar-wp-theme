<?php

/**
 * Setup the Theme Admin Settings Page
 * 
 * Add "Theme Options" link to the "Appearance" menu
 * 
 */
function isquar_theme_page() {
	add_theme_page( __( 'Isquar Theme Options', 'isquar' ), __( 'Theme Options', 'isquar' ), 'edit_theme_options', 'isquar_options', 'isquar_admin_options_page' );
}
// Load the Admin Options page
add_action( 'admin_menu', 'isquar_theme_page' );

function isquar_register_settings() {
	register_setting( 'isquar_theme_options', 'isquar_theme_options', 'isquar_validate_theme_options' );
}

add_action( 'admin_init', 'isquar_register_settings' );

function isquar_admin_options_page() { ?>
	<div class="wrap">
		<?php isquar_admin_options_page_tabs(); ?>
		<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
			<div class='updated'><p><?php _e( 'Theme settings updated successfully.', 'isquar' ); ?></p></div>
		<?php endif; ?>
		<form action="options.php" method="post">
			<?php settings_fields( 'isquar_theme_options' ); ?>
			<?php do_settings_sections('isquar_options'); ?>
			<p>&nbsp;</p>
			<?php $tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'general' ); ?>
			<input name="isquar_theme_options[submit-<?php echo $tab; ?>]" type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'isquar' ); ?>" />
			<input name="isquar_theme_options[reset-<?php echo $tab; ?>]" type="submit" class="button-secondary" value="<?php _e( 'Reset Defaults', 'isquar' ); ?>" />
		</form>
	</div>
<?php
}

function isquar_admin_options_page_tabs( $current = 'general' ) {
	$current = ( isset ( $_GET['tab'] ) ? $_GET['tab'] : 'general' );
	$tabs = array(
		'general' => __( 'General', 'isquar' ),
		'layout' => __( 'Layout', 'isquar' ),
		'about' => __( 'About', 'isquar' ),
	);
	$links = array();
	foreach( $tabs as $tab => $name )
		$links[] = "<a class='nav-tab" . ( $tab == $current ? ' nav-tab-active' : '' ) ."' href='?page=isquar_options&tab=$tab'>$name</a>";
	echo '<div id="icon-themes" class="icon32"><br /></div>';
	echo '<h2 class="nav-tab-wrapper">';
	foreach ( $links as $link )
		echo $link;
	echo '</h2>';
}

function isquar_admin_options_init() {
	global $pagenow;
	if( 'themes.php' == $pagenow && isset( $_GET['page'] ) && 'isquar_options' == $_GET['page'] ) {
		$tab = ( isset ( $_GET['tab'] ) ? $_GET['tab'] : 'general' );
		switch ( $tab ) {
			case 'general' :
				isquar_general_settings_sections();
				break;
			case 'layout' :
				isquar_layout_settings_sections();
				break;
			case 'about' :
				isquar_about_settings_sections();
				break;
		}
	}
}

add_action( 'admin_init', 'isquar_admin_options_init' );

function isquar_general_settings_sections() {
	add_settings_section( 'isquar_homepage_post_label_options', __( 'Excerpt / More Tag Settings', 'isquar' ), 'isquar_homepage_post_label_options', 'isquar_options' );
	add_settings_section( 'isquar_homepage_navigation_label_options', __( 'Homepage Content Nav Labels', 'isquar' ), 'isquar_homepage_navigation_label_options', 'isquar_options' );
	add_settings_section( 'isquar_search_label_options', __( 'Search Text Settings', 'isquar' ), 'isquar_search_label_options', 'isquar_options' );
	add_settings_section( 'isquar_footer_options', __( 'Footer Settings', 'isquar' ), 'isquar_footer_options', 'isquar_options' );
	add_settings_section( 'isquar_slider_options', __( 'Slider Settings', 'isquar' ), 'isquar_slider_options', 'isquar_options' );
}

function isquar_layout_settings_sections() {
	add_settings_section( 'isquar_layout_options', __( 'Body Margin Options', 'isquar' ), 'isquar_layout_options', 'isquar_options' );
	add_settings_section( 'isquar_content_width_options', __( 'Site Content Area Width', 'isquar' ), 'isquar_content_width_options', 'isquar_options' );
}

function isquar_about_settings_sections() {
	add_settings_section( 'isquar_about_support', __( 'About Author / Support', 'isquar' ), 'isquar_about_support', 'isquar_options' );
}

function isquar_homepage_post_label_options(){
	add_settings_field( 'isquar_custom_readmore', __( 'More tag text', 'isquar' ), 'isquar_custom_readmore', 'isquar_options', 'isquar_homepage_post_label_options' );
	add_settings_field( 'isquar_custom_excerpt_length', __( 'Excerpt Length', 'isquar' ), 'isquar_custom_excerpt_length', 'isquar_options', 'isquar_homepage_post_label_options' );
}

function isquar_homepage_navigation_label_options(){
	add_settings_field( 'isquar_older_post_label', __( 'Older Posts', 'isquar' ), 'isquar_older_post_label', 'isquar_options', 'isquar_homepage_navigation_label_options' );
	add_settings_field( 'isquar_newer_post_label', __( 'Newer Posts', 'isquar' ), 'isquar_newer_post_label', 'isquar_options', 'isquar_homepage_navigation_label_options' );
}

function isquar_search_label_options(){
	add_settings_field( 'isquar_default_search_text', __( 'Default Text in Search', 'isquar' ), 'isquar_default_search_text', 'isquar_options', 'isquar_search_label_options' );
	add_settings_field( 'isquar_search_button_text', __( 'Search Button Text', 'isquar' ), 'isquar_search_button_text', 'isquar_options', 'isquar_search_label_options' );
}

function isquar_footer_options(){
	add_settings_field( 'isquar_copyright_text', __( 'Copyright Text', 'isquar' ), 'isquar_copyright_text', 'isquar_options', 'isquar_footer_options' );
	add_settings_field( 'isquar_credit_links', __( 'Credit Links', 'isquar' ), 'isquar_credit_links', 'isquar_options', 'isquar_footer_options' );
}

function isquar_slider_options(){
	add_settings_field( 'isquar_slider_disable', __( 'Disable Slider on Homepage', 'isquar' ), 'isquar_slider_disable', 'isquar_options', 'isquar_slider_options' );
	add_settings_field( 'isquar_slider_cat', __( 'Select Category', 'isquar' ), 'isquar_slider_cat', 'isquar_options', 'isquar_slider_options' );
	add_settings_field( 'isquar_slider_post_no', __( 'Number of Posts', 'isquar' ), 'isquar_slider_post_no', 'isquar_options', 'isquar_slider_options' );
}

function isquar_layout_options(){
	add_settings_field( 'isquar_site_margin_left', __( 'Site Left Margin ', 'isquar' ), 'isquar_site_margin_left', 'isquar_options', 'isquar_layout_options' );
	add_settings_field( 'isquar_site_margin_right', __( 'Site Right Margin', 'isquar' ), 'isquar_site_margin_right', 'isquar_options', 'isquar_layout_options' );
}

function isquar_content_width_options(){
	add_settings_field( 'isquar_content_area_width', __( 'Content Area Width', 'isquar' ), 'isquar_content_area_width', 'isquar_options', 'isquar_content_width_options' );
	add_settings_field( 'isquar_widget_area_width', __( 'Sidebar Area Width', 'isquar' ), 'isquar_widget_area_width', 'isquar_options', 'isquar_content_width_options' );

}

function isquar_about_support(){
	add_settings_field( 'isquar_author_info', __( 'Author Info ', 'isquar' ), 'isquar_author_info', 'isquar_options', 'isquar_about_support' );
	add_settings_field( 'isquar_theme_support', __( 'Theme Support ? Donations ? ', 'isquar' ), 'isquar_theme_support', 'isquar_options', 'isquar_about_support' );
}

function isquar_custom_readmore() { ?>
	<label class="description">
		<input name="isquar_theme_options[custom_readmore]" type="text" value="<?php echo isquar_get_option( 'custom_readmore' ); ?>" />
		<span><?php _e( 'Enter custom read more text here.', 'isquar' ); ?></span>
	</label>
<?php
}

function isquar_custom_excerpt_length() { ?>
	<label class="description">
		<input name="isquar_theme_options[custom_excerpt_length]" type="text" value="<?php echo isquar_get_option( 'custom_excerpt_length' ); ?>" />
		<span><?php _e( 'Enter custom excerpt length here.', 'isquar' ); ?></span>
	</label>
<?php
}

function isquar_older_post_label() { ?>
	<label class="description">
		<input name="isquar_theme_options[older_post_label]" type="text" value="<?php echo isquar_get_option( 'older_post_label' ); ?>" />
		<span><?php _e( 'Enter Older Post label.', 'isquar' ); ?></span>
	</label>
<?php
}

function isquar_newer_post_label() { ?>
	<label class="description">
		<input name="isquar_theme_options[newer_post_label]" type="text" value="<?php echo isquar_get_option( 'newer_post_label' ); ?>" />
		<span><?php _e( 'Enter Newer Post label.', 'isquar' ); ?></span>
	</label>
<?php
}

function isquar_default_search_text() { ?>
	<label class="description">
		<input name="isquar_theme_options[default_search_text]" type="text" value="<?php echo isquar_get_option( 'default_search_text' ); ?>" />
		<span><?php _e( 'Enter default display search text here.', 'isquar' ); ?></span>
	</label>
<?php
}

function isquar_search_button_text() { ?>
	<label class="description">
		<input name="isquar_theme_options[search_button_text]" type="text" value="<?php echo isquar_get_option( 'search_button_text' ); ?>" />
		<span><?php _e( 'Enter custom search button text here.', 'isquar' ); ?></span>
	</label>
<?php
}

function isquar_copyright_text() { ?>
	<label class="description">
		<input name="isquar_theme_options[copyright_text]" type="text" value="<?php echo esc_html(isquar_get_option( 'copyright_text' ) ) ; ?>" />
		<span><?php _e( 'Enter copyright text (%year% = current year, %blogname% = website name) .', 'isquar' ); ?></span>
	</label>
<?php
}

function isquar_credit_links() { ?>
	<label class="description">
		<input name="isquar_theme_options[theme_credit_link]" type="checkbox" value="<?php echo isquar_get_option( 'theme_credit_link' ); ?>" <?php checked( isquar_get_option( 'theme_credit_link' ) ); ?> />
		<span><?php _e( 'Show theme credit link', 'isquar' ); ?></span>
	</label><br>
<?php
}

function isquar_slider_disable() { ?>
	<label class="description">
		<input name="isquar_theme_options[slider_disable]" type="checkbox" value="<?php echo isquar_get_option( 'slider_disable' ); ?>" <?php checked( isquar_get_option( 'slider_disable' ) ); ?> />
		<span><?php _e( 'Disable Slider', 'isquar' ); ?></span>
	</label><br />
<?php
}

function isquar_slider_cat() {
	$categories = get_categories( array( 'hide_empty' => 0, 'hierarchical' => 0 ) ); ?>
	<select name="isquar_theme_options[slider_cat]">
		<option value="-1" <?php selected( isquar_get_option( 'slider_cat' ), -1 ); ?>>&mdash;</option>
		<?php foreach( $categories as $category ) : ?>
			<option value="<?php echo $category->cat_ID; ?>" <?php selected( isquar_get_option( 'slider_cat' ), $category->cat_ID ); ?>><?php echo $category->cat_name; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function isquar_slider_post_no() { ?>
	<label class="description">
		<input name="isquar_theme_options[slider_post_no]" type="text" value="<?php echo isquar_get_option( 'slider_post_no' ); ?>" />
		<span><?php _e( 'Number of Post to show in slider', 'isquar' ); ?></span>
	</label>
<?php
}

function isquar_site_margin_left() { ?>
	<label class="description">
		<input name="isquar_theme_options[site_margin_left]" type="text" value="<?php echo isquar_get_option( 'site_margin_left' ); ?>" />
		<span><?php _e( 'Enter left margin in [ % ].', 'isquar' ); ?></span>
	</label>
<?php
}

function isquar_site_margin_right() { ?>
	<label class="description">
		<input name="isquar_theme_options[site_margin_right]" type="text" value="<?php echo isquar_get_option( 'site_margin_right' ); ?>" />
		<span><?php _e( 'Enter right margin in [ % ].', 'isquar' ); ?></span>
	</label>
<?php
}

function isquar_content_area_width() { ?>
	<label class="description">
		<input name="isquar_theme_options[content_area_width]" type="text" value="<?php echo isquar_get_option( 'content_area_width' ); ?>" />
		<span><?php _e( 'Enter Width for Primary Content Area in [ % ].', 'isquar' ); ?></span>
	</label>
<?php
}

function isquar_widget_area_width() { ?>
	<label class="description">
		<input name="isquar_theme_options[widget_area_width]" type="text" value="<?php echo isquar_get_option( 'widget_area_width' ); ?>" />
		<span><?php _e( 'Enter Width for Sidebar Area in [ % ].', 'isquar' ); ?></span>
		<span><br/>
		<?php _e( '<strong>Note:</strong> Total Width is <strong> 97.36% </strong> ( Primary Content Area + Sidebar Content Area ).', 'isquar' ); ?>
		</span>
		<span><br/>
		<?php _e( 'Entered width should not <strong>exceed</strong> the default total width.', 'isquar' ); ?>
		</span>
	</label>
<?php
}

function isquar_author_info() { ?>
	<label class="description">
	<?php $author_link = '<a target="_blank" href="' . esc_url( 'http://www.sandipbhagat.com.np/' ) . '" title="' . esc_attr( __( 'Sandip Bhagat', 'isquar' ) ) . '">' . __( 'sandipbhagat.com.np', 'isquar' ) . '</a>'; ?>
		<span><?php echo 'This theme was created by <strong>Sandip Bhagat</strong> ('.$author_link.')'; ?></span>
	</label>
<?php
}

function isquar_theme_support() { ?>
	<label class="description">
	<?php $author_facebook_link = '<a target="_blank" href="' . esc_url( 'http://www.facebook.com/sandip02/' ) . '" title="' . esc_attr( __( 'Facebook', 'isquar' ) ) . '">' . __( 'Facebook', 'isquar' ) . '</a>'; ?>
	<?php $author_twitter_link = '<a target="_blank" href="' . esc_url( 'http://www.twitter.com/san_dip02' ) . '" title="' . esc_attr( __( 'Twitter', 'isquar' ) ) . '">' . __( 'Twitter', 'isquar' ) . '</a>'; ?>
		<span><?php echo 'If you love this free themes and wish to give back, you can follow me on '.$author_twitter_link.' or add me on '.$author_facebook_link.' .This way you can support me.!<br /><br />'; ?></span>
		<p>
		<label>You can also like our facebook page to get update on Isquar theme:  </label><br><br>

		<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fisquartheme&amp;width=292&amp;height=258&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;show_border=true&amp;header=false&amp;appId=476920349056222" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:258px;" allowTransparency="true"></iframe>		
		</p>
	</label>
<?php
}

function isquar_validate_theme_options( $input ) {
	if( isset( $input['submit-general'] ) || isset( $input['reset-general'] ) ) {
		$input['custom_readmore'] = sanitize_text_field( $input['custom_readmore'] );
		$input['custom_excerpt_length']= absint($input['custom_excerpt_length']) ? $input['custom_excerpt_length'] : 35  ;	
		$input['older_post_label'] = sanitize_text_field( $input['older_post_label'] );
		$input['newer_post_label'] = sanitize_text_field( $input['newer_post_label'] );
		$input['default_search_text'] = sanitize_text_field( $input['default_search_text'] );
		$input['search_button_text'] = sanitize_text_field( $input['search_button_text'] );
		$input['copyright_text'] = balanceTags( $input['copyright_text'] );
		$input['theme_credit_link'] = ( isset( $input['theme_credit_link'] ) ? true : false );		
		$input['slider_disable'] = ( isset( $input['slider_disable'] ) ? true : false );
		$input['slider_post_no']= absint($input['slider_post_no']) ? $input['slider_post_no'] : 3  ;	
		
		if( -1 != $input['slider_cat'] ) {
			$valid = 0;
			$categories = get_categories( array( 'hide_empty' => 0, 'hierarchical' => 0 ) );
			foreach( $categories as $category ) {
				if( $input['slider_cat'] == $category->cat_ID )
					$valid = 1;
			}
			if( ! $valid )
				$input['slider_cat'] = isquar_get_option( 'slider_cat' );
		}
		
		} elseif( isset( $input['submit-layout'] ) || isset( $input['reset-layout'] ) ) {
		$input['site_margin_left'] = balanceTags( $input['site_margin_left'] );
		$input['site_margin_right'] = balanceTags( $input['site_margin_right'] );
		$input['content_area_width'] = balanceTags( $input['content_area_width'] );
		$input['widget_area_width'] = balanceTags( $input['widget_area_width'] );
	}
	if( isset( $input['reset-general'] ) || isset( $input['reset-layout'] )  ) {
		$default_options = isquar_default_options();
		foreach( $input as $name => $value )
			if( 'reset-general' != $name  && 'reset-layout' != $name )
				$input[$name] = $default_options[$name];
	}
	$input = wp_parse_args( $input, get_option( 'isquar_theme_options', isquar_default_options() ) );
	return $input;
}