<?php
require_once( 'inc/walker-bootstrap-class.php' );
require_once( 'inc/widget-text.php' );
require_once( 'inc/walker-comments.php' );

if ( ! defined( 'VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'VERSION', '1.0.0' );
}
require_once( 'inc/widget.php' );
require_once( 'inc/mywidget.php' );
require_once( 'inc/ajax-load.php' );

add_action( 'wp_enqueue_scripts', 'promodise_style' );
add_action( 'after_setup_theme', 'promodise_theme_settings' );
add_action( 'widgets_init', 'my_register_widget' );

function promodise_style() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/plugins/bootstrap/css/bootstrap.css', '', VERSION );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/plugins/fontawesome/css/all.css', '', VERSION );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/plugins/animate-css/animate.css', '', VERSION );
	wp_enqueue_style( 'icofont', get_template_directory_uri() . '/plugins/icofont/icofont.css', '', VERSION );
	wp_enqueue_style( 'css', get_template_directory_uri() . '/css/style.css', '', VERSION );
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/plugins/jquery/jquery.min.js', array(), VERSION, true );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), VERSION, true );
	wp_enqueue_script( 'bootstrap-poper', get_template_directory_uri() . '/plugins/bootstrap/js/popper.min.js', array( 'jquery' ), VERSION, true );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/plugins/bootstrap/js/bootstrap.min.js', array( 'jquery' ), VERSION, true );
	wp_enqueue_script( 'wow', get_template_directory_uri() . '/plugins/counterup/wow.min.js', array( 'jquery' ), VERSION, true );
	wp_enqueue_script( 'jquery.easing', get_template_directory_uri() . '/plugins/counterup/jquery.easing.1.3.js', array( 'jquery' ), VERSION, true );
	wp_enqueue_script( 'jquery.waypoints', get_template_directory_uri() . '/plugins/counterup/jquery.waypoints.js', array( 'jquery' ), VERSION, true );
	wp_enqueue_script( 'jquery.counterup', get_template_directory_uri() . '/plugins/counterup/jquery.counterup.min.js', array( 'jquery' ), VERSION, true );
//    wp_enqueue_script('google-map', get_template_directory_uri() . '/plugins/google-map/gmap3.min.js', array('jquery'), VERSION, true);
//    wp_enqueue_script('google-map-key', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBG1HJy3lXyMorlojT7HtHaT-GyMtESnnk', array('jquery'), VERSION, true);

	if ( is_page( 15 ) ) {
        wp_enqueue_script('google-map-key', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBG1HJy3lXyMorlojT7HtHaT-GyMtESnnk', array('jquery'), VERSION, true);
		wp_enqueue_script( 'google-map-key-2', 'https://maps.google.com/maps/api/js?libraries=geometry&v=3.41&key=AIzaSyBf86ERXMsj_Tj2mXWAS9GATz9H8ulGxbg&language=en&ver=5.7.1', array( 'jquery' ), VERSION, true );
	}

	wp_localize_script('custom-js', 'ajax_links', array(
		'url' => admin_url('admin-ajax.php'),
	));

	wp_enqueue_script( 'contact', get_template_directory_uri() . '/plugins/form/contact.js', array( 'jquery' ), VERSION, true );
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), VERSION, true );
}

function promodise_theme_settings() {
	add_theme_support( 'title-tag' );
	add_theme_support(
		'custom-logo',
		array(
			'height'               => 50,
			'width'                => 130,
			'flex-width'           => false, // true - чтобы логотип подстраивался под ширину
			'flex-height'          => false, // true - чтобы логотип подстраивался под высоту
			'header-text'          => 'dddddddd',
			'unlink-homepage-logo' => true,
		)
	);
	add_theme_support( 'post-thumbnails' );
}

register_nav_menus( [
	'header'       => 'Header Menu',
	'footer_left'  => 'Footer Left Column',
	'footer_right' => 'Header Right Column',
] );

function my_register_widget() {
	register_widget( 'promodise_widget_text' );
	register_widget( 'download_widget' );
}




?>
