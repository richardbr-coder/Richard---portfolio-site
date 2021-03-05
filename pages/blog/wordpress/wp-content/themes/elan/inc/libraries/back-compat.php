<?php
/**
 * Elan back compat functionality
 *
 * Prevents Elan from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package Elan
 */

/**
 * Prevent switching to Elan on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Elan
 */
function elan_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'elan_upgrade_notice' );
}
add_action( 'after_switch_theme', 'elan_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Elan on WordPress versions prior to 4.7.
 *
 * @since Elan
 *
 * @global string $wp_version WordPress version.
 */
function elan_upgrade_notice() {
	$message = sprintf( __( 'Elan requires at least WordPress version 4.7 or later and PHP version 5.4.0 or later. You are running WordPress version %1$s and PHP version %2$s. Please upgrade and try again.', 'elan' ), $GLOBALS['wp_version'], PHP_VERSION );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since Elan
 *
 * @global string $wp_version WordPress version.
 */
function elan_customize() {
	wp_die(
		sprintf(
			__( 'Elan requires at least WordPress version 4.7 or later and PHP version 5.4.0 or later. You are running WordPress version %1$s and PHP version %2$s. Please upgrade and try again.', 'elan' ),
			$GLOBALS['wp_version'],
            PHP_VERSION
		),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'elan_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since Elan
 *
 * @global string $wp_version WordPress version.
 */
function elan_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Elan requires at least WordPress version 4.7 or later and PHP version 5.4.0 or later. You are running WordPress version %1$s and PHP version %2$s. Please upgrade and try again.', 'elan' ), $GLOBALS['wp_version'], PHP_VERSION ) );
	}
}
add_action( 'template_redirect', 'elan_preview' );
