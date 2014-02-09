<?php

/* REDESIGN, WP FUNCTIONS FILE */

add_action('after_setup_theme', 'redesign_theme_setup');

function redesign_theme_setup() {

//CONTENT WIDTH
if ( ! isset( $content_width ) ) $content_width = 490;

//THEME SUPPORT
add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

add_theme_support('post-thumbnails');

add_theme_support('automatic-feed-links');

add_editor_style( 'editor-style.css' );

//CUSTOM BACKGROUND
$defaults = array(
	'default-color'          => '000000',
	'default-image' => get_template_directory_uri() . '/img/background.png',
	'wp-head-callback'       => '_custom_background_cb',
	'admin-head-callback'    => '',
	'admin-preview-callback' => ''
);
add_theme_support( 'custom-background', $defaults );

//CUSTOM HEADER
$defaults = array(
	'random-default'         => false,
	'width'                  => '',
	'height'                 => '',
	'flex-height'            => true,
	'flex-width'             => true,
	'default-text-color'     => 777777,
	'header-text'            => true,
	'uploads'                => true,
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
	'default-image'		 => '',
);
add_theme_support( 'custom-header', $defaults );

//ADD NAVIGATION
add_action( 'init', 'redesign_register_menus' );

//ADD SIDEBARS
add_action( 'widgets_init', 'redesign_register_sidebars' );

//ENQUE STYLESHEETS AND SCRIPTS
add_action( 'wp_enqueue_scripts', 'redesign_load_scripts' );

}

//FUNCTIONS

//MENU NAVIGATION
function redesign_register_menus() {
  register_nav_menus(
    array(
      'top-menu' => __( 'Top Menu' ),
      'primary-menu' => __( 'Primary Menu' )
    )
  );
}

//WIDGET AREAS
function redesign_register_sidebars() {
	register_sidebar( array(
		'name' => __( 'Top', 'redesign' ),
		'id' => __( 'banner-1' ),
		'description' => __( 'A top banner widget area', 'redesign' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Main sidebar', 'redesign' ),
		'id' => __( 'sidebar-1' ),
		'description' => __( 'First sidebar widget area', 'redesign' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Extra sidebar', 'redesign' ),
		'id' => __( 'sidebar-2' ),
		'description' => __( 'Second sidebar widget area', 'redesign' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => __( 'Bottom', 'redesign' ),
		'id' => __( 'footer-1' ),
		'description' => __( 'Footer widget area', 'redesign' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
}

//SCRIPTS THREADED COMMENTS
function redesign_load_scripts() {

	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() )
		wp_enqueue_script( 'comment-reply' );
}

?>