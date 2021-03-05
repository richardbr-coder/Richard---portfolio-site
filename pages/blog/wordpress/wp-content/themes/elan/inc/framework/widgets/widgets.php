<?php
/**
 * Sample implementation of the Custom widgets and sidebar feature
 *
 * @package Elan
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

// Register Sidebars
function elan_widgets_init() {

    // Register Default Sidebar
    register_sidebar( array(
        'name'          => esc_html__('Sidebar', 'elan'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'elan'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    /* ---------------------------------------------
    # Header Search Widget Areas
     ---------------------------------------------*/
    $header_search  = get_theme_mod( 'elan_header_search_enable', true );

    if ( true == $header_search ) {

        register_sidebar( array(
            'name'          => esc_html__('Search Popup Column 1', 'elan'),
            'id'            => 'header_search_sidebar_1',
            'description'   => esc_html__('Add widgets here.', 'elan'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }


    /* ---------------------------------------------
    # Footer Widget Areas
    ---------------------------------------------*/
    $activate_footer_widget_area    = get_theme_mod( 'elan_footer_widget_area_activate', true );

    if ( true == $activate_footer_widget_area ) {

        for ($i = 1; $i <= 4; $i++) {

            register_sidebar( array(
                'name'          => sprintf( esc_html__('Footer Widgets Column %d', 'elan'), $i),
                'id'            => 'footer_sidebar_' . $i,
                'description'   => esc_html__('Add widgets here.', 'elan'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ));
        }
    }
}
add_action( 'widgets_init', 'elan_widgets_init' );
