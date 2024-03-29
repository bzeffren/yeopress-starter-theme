<?php
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
function theme_enqueue_scripts(){

	wp_register_script('modernizr', get_bloginfo('template_url') . '/js/modernizr.js');
	wp_enqueue_script('modernizr');

	wp_register_script('require', get_bloginfo('template_url') . '/js/vendor/requirejs/require.js', array(), false, true);
	wp_enqueue_script('require');

	wp_register_script('global', get_bloginfo('template_url') . '/js/global.js', array('require'), false, true);
	wp_enqueue_script('global');
	//get_bloginfo('template_url') . '/node_modules/grunt-contrib-livereload/tasks/livereload.js?snipver=1'
wp_register_script('livereload', 'http://localhost:35729/livereload.js?snipver=1', null, false, true);
wp_enqueue_script('livereload'); //keep this at the bottom
// this code creates a variable for your template assets path for use with require.js
$WP_DIRECTORY = array( 'path' => get_stylesheet_directory_uri() . '/js' );
wp_localize_script( 'require', 'directory', $WP_DIRECTORY );


// ADD DATA ATTRIBUTE TO ENQUEUE SCRIPT
add_filter('clean_url','requirejs_script',10,2);

function requirejs_script( $url ) {
      if ( // comment the following line out add 'defer' to all scripts
	  FALSE === strpos( $url, 'require.js' )
	  )
	  { // not our file
	      return $url;
	  }
	  // Must be a ', not "!
	  return "$url' data-main='".get_template_directory_uri()."/js/global'";
}

	wp_enqueue_style('global', get_bloginfo('template_url') . '/css/global.css');
}

//Add Featured Image Support
add_theme_support('post-thumbnails');

// Clean up the <head>
function removeHeadLinks() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'removeHeadLinks');
remove_action('wp_head', 'wp_generator');

function register_menus() {
	register_nav_menus(
		array(
			'main-nav' => 'Main Navigation',
			'secondary-nav' => 'Secondary Navigation',
			'sidebar-menu' => 'Sidebar Menu'
		)
	);
}
add_action( 'init', 'register_menus' );

function register_widgets(){

	register_sidebar( array(
		'name' => __( 'Sidebar' ),
		'id' => 'main-sidebar',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}//end register_widgets()
add_action( 'widgets_init', 'register_widgets' );
