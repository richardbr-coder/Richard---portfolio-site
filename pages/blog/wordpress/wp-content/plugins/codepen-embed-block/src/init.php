<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function codepen_block_assets() { 

	wp_register_script(
		'codepen-embed-gutenberg-block-js',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
		null, 
		true // Enqueue the script in the footer.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'codepen-embed-gutenberg-block-js',
		'cgbGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `cgbGlobal` object.
		]
	);

	register_block_type(
		'cp/codepen-embed-gutenberg-block', array(
			'editor_script' => 'codepen-embed-gutenberg-block-js',
		)
	);
}

add_action( 'init', 'codepen_block_assets' );
