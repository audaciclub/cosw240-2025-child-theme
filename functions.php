<?php
/**
 * COSW240 child theme functions and Audaci foundation assets.
 */

// COSW240: preserve Bio Page setup and editor stylesheet.
add_action( 'after_setup_theme', 'cosw240_bio_setup' );
function cosw240_bio_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/bio-page.css' );
}

// COSW240: preserve the metadata binding used by templates/bio-page.html.
add_action( 'init', 'cosw240_register_bio_title' );
function cosw240_register_bio_title() {
	add_post_type_support( 'page', 'custom-fields' );
	register_post_meta(
		'page',
		'cosw240_bio_title',
		array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
}

// COSW240: preserve conditional loading of Bio Page styles.
add_action( 'wp_enqueue_scripts', 'cosw240_enqueue_bio_styles' );
function cosw240_enqueue_bio_styles() {
	if ( ! is_page_template( 'bio-page' ) ) {
		return;
	}
	$relative_path = 'assets/css/bio-page.css';
	$path = get_theme_file_path( $relative_path );
	if ( ! file_exists( $path ) ) {
		return;
	}
	wp_enqueue_style(
		'cosw240-bio-page',
		get_theme_file_uri( $relative_path ),
		array( 'audaci-foundation' ),
		filemtime( $path )
	);
}

// Audaci: enqueue the child theme's foundational CSS on the front end.
add_action( 'wp_enqueue_scripts', 'audaci_enqueue_foundation', 20 );
function audaci_enqueue_foundation() {
	$relative_path = 'style.css';
	$path = get_stylesheet_directory() . '/' . $relative_path;
	wp_enqueue_style(
		'audaci-foundation',
		get_stylesheet_directory_uri() . '/' . $relative_path,
		array(),
		file_exists( $path ) ? filemtime( $path ) : wp_get_theme()->get( 'Version' )
	);
}
