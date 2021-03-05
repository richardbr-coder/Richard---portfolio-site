<?php
/**
 * Theme Customizer
 *
 * @package Elan
 */

/*--------------------------------------------------------------
# Configuration for Kirki Toolkit
--------------------------------------------------------------*/
function elan_kirki_configuration() {
    return array( 'url_path'     => ELAN_THEME_URI . '/inc/libraries/kirki/' );
}
add_filter( 'kirki/config', 'elan_kirki_configuration' );

/*--------------------------------------------------------------
# Disable the telemetry module in your theme
--------------------------------------------------------------*/
add_filter( 'kirki_telemetry', '__return_false' );

/*--------------------------------------------------------------
# Elan Kirki Config
--------------------------------------------------------------*/
Kirki::add_config( 'elan-pro_config', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'theme_mod',
) );

/**
 * A proxy function. Automatically passes-on the config-id.
 *
 * @param array $args The field arguments.
 */
function elan_add_field( $args ) {
    Kirki::add_field( 'elan-pro_config', $args );
}

// Panels
require ELAN_THEME_DIR . '/inc/framework/customizer/panel/header.php';
require ELAN_THEME_DIR . '/inc/framework/customizer/panel/archive.php';
require ELAN_THEME_DIR . '/inc/framework/customizer/panel/post.php';
require ELAN_THEME_DIR . '/inc/framework/customizer/panel/page.php';
require ELAN_THEME_DIR . '/inc/framework/customizer/panel/sidebar.php';
require ELAN_THEME_DIR . '/inc/framework/customizer/panel/footer.php';
require ELAN_THEME_DIR . '/inc/framework/customizer/custom-control/upsell.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function elan_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

    // Remove
    $wp_customize->remove_control( 'display_header_text' );
    $wp_customize->remove_control( 'header_textcolor' ); 
    $wp_customize->register_control_type( 'Elan_Anchor_Customize_Section'  );  
   
   
    $wp_customize->add_section( new Elan_Anchor_Customize_Section( $wp_customize, 'elan-premium_addons_section', array(
        'title'    => esc_html__('Get Elan Pro', 'elan'),
        'priority' => 0,
        'url'      => esc_url('https://precisethemes.com/wordpress-theme/elan-pro/', 'elan')
    ) ));   

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'elan_customize_partial_blogname',
        ) );
        $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'elan_customize_partial_blogdescription',
        ) );
    }
}
add_action( 'customize_register', 'elan_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function elan_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function elan_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function elan_customize_preview_js() {

    $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    wp_enqueue_script( 'elan-customizer-preview', ELAN_THEME_URI . '/assets/back-end/js/customizer-preview'. $min .'.js', array( 'customize-preview', 'customize-base' ), false, true );
}
add_action( 'customize_preview_init', 'elan_customize_preview_js' );

/**
 * Load customizer style
 */
function elan_customize_controls_enqueue_scripts() {

    $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    wp_enqueue_style( 'elan-customizer-style', ELAN_THEME_URI . '/assets/back-end/css/customizer-style'. $min .'.css', false, ELAN_THEME_VERSION, 'all' );
    wp_enqueue_script( 'elan-customizer-custom-controls', ELAN_THEME_URI . '/assets/back-end/js/customizer-custom-control.js' );
}
add_action( 'customize_controls_enqueue_scripts', 'elan_customize_controls_enqueue_scripts' );
