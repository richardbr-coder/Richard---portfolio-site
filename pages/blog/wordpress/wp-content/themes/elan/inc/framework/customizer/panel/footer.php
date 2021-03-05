<?php
/**
 * Theme Customizer Post Panel
 *
 * @package Elan
 */

if ( ! function_exists( 'elan_customizer_footer_controls_init' ) ) :

    function elan_customizer_footer_controls_init() {
        /*--------------------------------------------------------------
        # Panel
        --------------------------------------------------------------*/
        Kirki::add_panel( 'elan_footer_panel', array(
            'priority'      => 126,
            'title'         => esc_html__( 'Footer', 'elan' ),
        ));

        /*--------------------------------------------------------------
        # Sections
        --------------------------------------------------------------*/
        $sections = array(
            'elan_footer_widgets_section'      => array( esc_html__( 'Widgets', 'elan' ), '' ),
            'elan_footer_bar_section'          => array( esc_html__( 'Footer Bar', 'elan' ), '' ),
        );
        foreach ( $sections as $section_id => $section ) {
            $section_args = array(
                'title'       => $section[0],
                'description' => $section[1],
                'panel'       => 'elan_footer_panel',
            );
            if ( isset( $section[2] ) ) {
                $section_args['type'] = $section[2];
            }
            Kirki::add_section( $section_id, $section_args );
        }

        /*--------------------------------------------------------------
        # Footer Widgets: Enable
        --------------------------------------------------------------*/
        elan_add_field(
            array(
                'type'          => 'toggle',
                'settings'      => 'elan_footer_widget_area_activate',
                'label'         => esc_html__( 'Enable', 'elan' ),
                'description'   => esc_html__( 'Enable it to display Footer Widget Area on all Pages.', 'elan' ),
                'section'       => 'elan_footer_widgets_section',
                'default'       => 1,
                'partial_refresh'   => array(
                    'elan_footer_widget_area_activate'   => array(
                        'selector'                          => '.site-footer .footer-widgets',
                        'render_callback'                   => '__return_false',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # Footer Widgets: Background Overlay Color
        --------------------------------------------------------------*/
        elan_add_field(
            array(
                'type'        => 'color',
                'label'       => esc_html__( 'Background Overlay', 'elan' ),
                'settings'    => 'elan_footer_widget_section_bg_color',
                'section'     => 'elan_footer_widgets_section',
                'default'     => 'rgba(0,0,0,0.01)',
                'choices'     => array(
                    'alpha' => true,
                ),
                'transport' => 'postMessage',
                'js_vars'   => array(
                    array(
                        'element'  => array( '.footer-widgets::before' ),
                        'property' => 'background-color',
                    )
                ),
                'output'   => array(
                    array(
                        'element'  => array( '.footer-widgets::before' ),
                        'property' => 'background-color',
                    )
                ),
            )
        );

        /*--------------------------------------------------------------
        # Footer Widgets: Content Order
        --------------------------------------------------------------*/
        elan_add_field(
            array(
                'type'        => 'sortable',
                'label'       => esc_html__( 'Content Order', 'elan' ),
                'description' => esc_html__( 'Drag & Drop items to re-arrange order of appearance.', 'elan' ),
                'settings'    => 'elan_footer_bar_content_order_list',
                'section'     => 'elan_footer_bar_section',
                'default'     => array( 'footer-bar-text' ),
                'choices'     => array(
                    'footer-bar-text'       => esc_html__( 'Copyright Text', 'elan' ),
                    'footer-bar-menu'       => esc_html__( 'Footer Menu', 'elan' ),
                ),
                'partial_refresh'   => array(
                    'elan_footer_bar_content_order_list'   => array(
                        'selector'                          => '#colophon',
                        'render_callback'                   => '__return_false',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # Footer Widgets: Footer Menu
        --------------------------------------------------------------*/
        elan_add_field(
            array(
                'type'        => 'select',
                'settings'    => 'elan_footer_bar_menu_id',
                'label'       => esc_html__( 'Display a menu', 'elan' ),
                'section'     => 'elan_footer_bar_section',
                'choices'     => elan_get_menus(),
                'active_callback'  => array(
                    array(
                        'setting'  => 'elan_footer_bar_content_order_list',
                        'operator' => 'in',
                        'value'    => array( 'footer-bar-menu' ),
                    ),
                ),
            )
        );
    }
endif;
add_action( 'init', 'elan_customizer_footer_controls_init', 999 );
