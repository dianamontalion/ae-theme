<?php
/**
 * Architecting Enterprise Theme
 *
 * This file adds functions to the AE custom theme.
 *
 * @package AE theme
 * @author  Diana Montalion 
 * @license GPL-2.0+
 * based on Twenty Seven Pro theme
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
load_child_theme_textdomain( 'twenty-seven', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'twenty-seven' ) );

// Add color select to WordPress theme customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Twenty Seven Pro' );
define( 'CHILD_THEME_URL', 'https://briangardner.com/themes/twenty-seven/' );
define( 'CHILD_THEME_VERSION', '1.1' );

// Enqueue scripts and styles.
add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
function genesis_sample_enqueue_scripts_styles() {

	wp_enqueue_style( 'twenty-seven-fonts', '//fonts.googleapis.com/css?family=Cormorant+Garamond:400,700|Proza+Libre:400,400i,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'twenty-seven-ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'twenty-seven-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'twenty-seven-matchHeights', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.js', array( 'jquery' ), '0.5.2', true );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'twenty-seven-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'twenty-seven-responsive-menu',
		'genesis_responsive_menu',
		twenty_seven_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function twenty_seven_responsive_menu_settings() {
	$settings = array(
		'mainMenu'          => __( 'Menu', 'twenty-seven' ),
		'menuIconClass'     => 'ionicons-before ion-drag',
		'subMenu'           => __( 'Menu', 'twenty-seven' ),
		'subMenuIconsClass' => 'ionicons-before ion-ios-arrow-down',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-secondary',
			),
			'others'  => array(),
		),
	);
	return $settings;
}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 512,
	'height'          => 134,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Rename menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Left Menu', 'modern-studio' ), 'secondary' => __( 'Right Menu', 'modern-studio' ) ) );

// Reposition left menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 5 );

// Reposition right menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_subnav', 12 );

// Remove header right widget area.
unregister_sidebar( 'header-right' );

// Remove secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Remove site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Remove navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'twenty_seven_remove_genesis_metaboxes' );
function twenty_seven_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}


// Modify size of Gravatar in entry comments.
add_filter( 'genesis_comment_list_args', 'twenty_seven_comments_gravatar' );
function twenty_seven_comments_gravatar( $args ) {

	$args['avatar_size'] = 120;

	return $args;

}

// Hook sticky message widget area.
add_action( 'genesis_before', 'twenty_seven_sticky_message' );
function twenty_seven_sticky_message() {

	genesis_widget_area( 'sticky-message', array(
		'before' => '<div class="sticky-message">',
		'after'  => '</div>',
	) );

}

// Hook before header widget area.
add_action( 'genesis_before_header', 'twenty_seven_before_header' );
function twenty_seven_before_header() {

	genesis_widget_area( 'before-header', array(
		'before' => '<div class="before-header"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

// Hook before footer widget area.
add_action( 'genesis_before_footer', 'twenty_seven_before_footer' );
function twenty_seven_before_footer() {

	genesis_widget_area( 'before-footer', array(
		'before' => '<div class="before-footer"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

// Register widget areas.
genesis_register_sidebar( array(
	'id'          => 'sticky-message',
	'name'        => __( 'Sticky Message', 'twenty-seven' ),
	'description' => __( 'This is the sticky message section.', 'twenty-seven' ),
) );
genesis_register_sidebar( array(
	'id'          => 'before-header',
	'name'        => __( 'Before Header', 'twenty-seven' ),
	'description' => __( 'This is the before header section.', 'twenty-seven' ),
) );
genesis_register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => __( 'Before Footer', 'twenty-seven' ),
	'description' => __( 'This is the before footer section.', 'twenty-seven' ),
) );

// Customize category display to show an edition (category) and tags (topics)
add_filter( 'genesis_post_meta', 'ae_entry_meta' );
function ae_entry_meta( $post_meta ) {
	
	$post_meta = '[post_terms taxonomy="category" before="Edition: "]' . '[post_tags before="Topics: "]';	return $post_meta;
}

// Change the footer credit text
add_filter('genesis_footer_creds_text', 'ae_footer_creds_filter');
function ae_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] &middot; <a href="http://mentrixgroup.com">Mentrix Group</a>';
	return $creds;
}

 
genesis_register_sidebar( array(
	'id'          => 'ae-author',
	'name'        => __( 'AE Author Bio', 'ae-theme' ),
	'description' => __( 'This is the author bio box.', 'ae-theme' ),
) );

add_action('genesis_before_sidebar_widget_area', 'ae_display_author_bio', 1);

function ae_display_author_bio() {
    if (is_singular('post')) {
      genesis_widget_area('ae-author', 
        array(
                'before' => '<span class="custom-author-box">',
                'after' => '</span>')
                ); 
    }              
}

add_filter( 'widget_display_callback', 'ae_author_content', 10, 3 );
function ae_author_content( $instance, $widget, $args ) {

    if ($args['id'] == 'ae-author' && is_singular('post') ) {
      
      $instance['title'] = get_the_author_meta( 'display_name' );
      $instance['content'] = get_ae_author_markup();
    
    }
    
    return $instance;
}

// Depends on Simple Social Share plugin 
function get_ae_author_markup() {
	
	// Get data
	if ( is_singular('post') ) {
		$author_avatar 	= get_avatar( get_the_author_meta( 'ID' ), 70 );
		$author_name 	= get_the_author_meta( 'display_name' );
		$author_desc 	= get_the_author_meta( 'description' );
		$email = get_the_author_meta( 'email' );
		$facebook 	= get_the_author_meta( 'facebook' );
		$googleplus 	= get_the_author_meta( 'googleplus' );
		$twitter 	= get_the_author_meta( 'twitter' );
		$website 	= get_the_author_meta( 'url' );
		
		// Output author image, name and bio
		$markup =  $author_avatar;
		$markup .= '<div class="custom-author-box"><p>' . $author_desc . '</p></div>';
		  if ($website) { $markup .= '<p><a href="' . $website . '">Visit my website</a></p>'; }
		
		// Output social share links using simple social share icons IF plugin is active
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
		if ( is_plugin_active('simple-social-icons/simple-social-icons.php') 
		     && ($twitter || $facebook || $googleplus || $email )) {

			// Create the space for displaying icons
			$open_markup = '<div class="author-social-links">
			               <section id="simple-social-icons-2" class="simple-social-icons">
			               <ul>';
			$markup .= $open_markup;
		
		  // Display icons that include data
		  if ( $facebook ) {
		      $markup .=  '<li class="ssi-facebook">
		               <a href="http://facebook.com/' . $facebook . ' " target="_blank">
		               <svg role="img" class="social-facebook" aria-labelledby="social-facebook">
		               <title id="social-facebook">Facebook</title>
		               <use xlink:href="' . plugin_dir_url('simple-social-icons') . 'simple-social-icons/symbol-defs.svg#social-facebook">
		               </use></svg></a></li>';
		  }
		  // Repurpose G+ to linkedin TODO recode this when adding new fields
		  if ( $googleplus ) {
			 $markup .= '<li class="ssi-linkedin">
		               <a href="http://linkedin.com/in/' . $googleplus . ' " target="_blank">
		               <svg role="img" class="social-linkedin" aria-labelledby="social-linkedin">
		               <title id="social-linkedin">Linkedin</title>
		               <use xlink:href="' . plugin_dir_url('simple-social-icons') . 'simple-social-icons/symbol-defs.svg#social-linkedin">
		               </use></svg></a></li>';
		  }
		  if ( $twitter ) {
			 $markup .= '<li class="ssi-twitter">
		               <a href="http://twitter.com/@' . $twitter . ' " target="_blank">
		               <svg role="img" class="social-twitter" aria-labelledby="social-twitter">
		               <title id="social-twitter">Twitter</title>
		               <use xlink:href="' . plugin_dir_url('simple-social-icons') . 'simple-social-icons/symbol-defs.svg#social-twitter">
		               </use></svg></a></li>';
		  }
          if ( $email ) {
			  $markup .= '<li class="ssi-email">
		               <a href="mailto:' . $email . ' " target="_blank">
		               <svg role="img" class="social-email" aria-labelledby="social-email">
		               <title id="social-email">Email</title>
		               <use xlink:href="' . plugin_dir_url('simple-social-icons') . 'simple-social-icons/symbol-defs.svg#social-email">
		               </use></svg></a></li>';
		
		  // Close up list
          $markup .= '</ul></section></div>';
		  }
	  }
    }
   
    return $markup;
 }

//* Allow the use of shortcodes in widget areas
add_filter('widget_text', 'do_shortcode');

// Add shortcode for title used in sticky region
add_shortcode( 'post_title', function( $atts ) {
    $atts = shortcode_atts( array(
        'id' => get_the_ID(),
    ), $atts, 'post_title' );
    return get_the_title( absint( $atts['id'] ) );
});

add_filter('widget_tag_cloud_args', 'ae_tag_cloud_as_list', 10, 1);

/**
 * Output the tag_cloud widget as a list of same font size items
 * @param    array $args    Display arguments.
 * @return array Settings for the output.
 */
function ae_tag_cloud_as_list($args) {
    
    // Format $args => array( breaks widget output so, this.
    $args['smallest'] = 1.4;
    $args['largest'] = 1.4;
    $args['unit'] = 'rem';
    $args['format'] = 'list';
                
    return $args;
}


//****************** PLAYGROUND ***********************************************************// 
//****************************************************************************************//


//Add author shortcodes
add_shortcode( 'author', 'author_bio_func' );

//[author field = name || description || website]
function author_bio_func( $atts ) {

	$val = $atts['field'];
	
    $vals = array(
            'name' =>   get_the_author_meta( 'display_name' ),
            'description' => get_the_author_meta('user_description'), // if empty, return pythonipsum
            'website' => get_the_author_meta('user_url'), // if empty, return something
            );
            
	return $vals[$val];
	
}

//* Display author box on single posts
//add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

//* Removes default Genesis Author Box, Adds a custom Author Box
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );
//add_action( 'genesis_after_entry', 'ae_author_box', 8 );

// Depends on Simple Social Share plugin 
function ae_author_box() {
	
	// Get data
	if ( is_singular('post') ) {
		$author_avatar 	= get_avatar( get_the_author_meta( 'ID' ), 70 );
		$author_name 	= get_the_author_meta( 'display_name' );
		$author_desc 	= get_the_author_meta( 'description' );
		$email = get_the_author_meta( 'email' );
		$facebook 	= get_the_author_meta( 'facebook' );
		$googleplus 	= get_the_author_meta( 'googleplus' );
		$twitter 	= get_the_author_meta( 'twitter' );
		$website 	= get_the_author_meta( 'url' );
		
		// Output author image, name and bio
		echo '<section class="author-box">';
		echo $author_avatar;
		echo '<h4 class="author-box-title">About ' . $author_name . '</h4>';
		echo '<div class="author-box-content" itemprop="description"><p>' . $author_desc . '</p>';
		  //TODO Breaks styling, fix
		  //if ($website) { echo '<a href="' . $website . '>Visit my website</a>'; }
		echo '</div>';
		
		// Output social share links using simple social share icons IF plugin is active
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
		if ( is_plugin_active('simple-social-icons/simple-social-icons.php') 
		     && ($twitter || $facebook || $googleplus || $email )) {

			// Create the space for displaying icons
			$open_markup = '<div class="author-social-links">
			               <section id="simple-social-icons-2" class="simple-social-icons">
			               <ul>';
			echo $open_markup;
		
		  //$plugin_url = plugin_dir_url('simple-social-icons') . '
		  // Display icons that include data
		  if ( $facebook ) {
		      $markup = '<li class="ssi-facebook">
		               <a href="http://facebook.com/' . $facebook . ' " target="_blank">
		               <svg role="img" class="social-facebook" aria-labelledby="social-facebook">
		               <title id="social-facebook">Facebook</title>
		               <use xlink:href="' . plugin_dir_url('simple-social-icons') . 'simple-social-icons/symbol-defs.svg#social-facebook">
		               </use></svg></a></li>';
			 echo $markup;
		  }
		  // Repurpose G+ to linkedin TODO recode this when adding new fields
		  if ( $googleplus ) {
			 $markup = '<li class="ssi-linkedin">
		               <a href="http://linkedin.com/in/' . $googleplus . ' " target="_blank">
		               <svg role="img" class="social-linkedin" aria-labelledby="social-linkedin">
		               <title id="social-linkedin">Linkedin</title>
		               <use xlink:href="' . plugin_dir_url('simple-social-icons') . 'simple-social-icons/symbol-defs.svg#social-linkedin">
		               </use></svg></a></li>';
			 echo $markup;
		  }
		  if ( $twitter ) {
			 $markup = '<li class="ssi-twitter">
		               <a href="http://twitter.com/@' . $twitter . ' " target="_blank">
		               <svg role="img" class="social-twitter" aria-labelledby="social-twitter">
		               <title id="social-twitter">Twitter</title>
		               <use xlink:href="' . plugin_dir_url('simple-social-icons') . 'simple-social-icons/symbol-defs.svg#social-twitter">
		               </use></svg></a></li>';
			 echo $markup;
		  }
          if ( $email ) {
			  $markup = '<li class="ssi-email">
		               <a href="mailto:' . $email . ' " target="_blank">
		               <svg role="img" class="social-email" aria-labelledby="social-email">
		               <title id="social-email">Email</title>
		               <use xlink:href="' . plugin_dir_url('simple-social-icons') . 'simple-social-icons/symbol-defs.svg#social-email">
		               </use></svg></a></li>';
			  echo $markup;
		
		  // Close up list
          echo '</ul></section></div>';
		  }
		  echo '<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-hashtags="ae" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
		  echo '<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
<script type="IN/Share"></script>';
      echo '</div>';
      echo '</section>';
	  }
    }
 }
 
 


