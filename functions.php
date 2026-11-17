<?php
add_action( 'after_setup_theme', 'cosw240_bio_setup' );

function cosw240_bio_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/bio-page.css' );
}

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

add_action( 'wp_enqueue_scripts', 'cosw240_enqueue_bio_styles' );

function cosw240_enqueue_bio_styles() {
	if ( ! is_page_template( 'bio-page' ) ) {
		return;
	}

	wp_enqueue_style(
		'cosw240-bio-page',
		get_theme_file_uri( 'assets/css/bio-page.css' ),
		array(),
		filemtime( get_theme_file_path( 'assets/css/bio-page.css' ) )
	);
}
?>