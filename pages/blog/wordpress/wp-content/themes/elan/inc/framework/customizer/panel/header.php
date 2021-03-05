<?php
/**
 * Theme Customizer Header Panel
 *
 * @package Elan
 */

if ( ! function_exists( 'elan_customizer_header_controls_init' ) ) :

    function elan_customizer_header_controls_init() {
        /*--------------------------------------------------------------
        # Panel Header
        --------------------------------------------------------------*/
        Kirki::add_panel( 'elan_header_panel', array(
            'priority'      => 2,
            'title'         => esc_html__( 'Header', 'elan' ),
        ));

        /*--------------------------------------------------------------
        # Sections
        --------------------------------------------------------------*/
        $sections = array(
            'title_tagline'                               => array( esc_html__( 'Site Title & Tagline', 'elan' ), '' ),
            'elan_header_search_section'               => array( esc_html__( 'Header Search', 'elan' ), '' ),

        );

        foreach ( $sections as $section_id => $section ) {
            $section_args = array(
                'title'       => $section[0],
                'description' => $section[1],
                'panel'       => 'elan_header_panel',
            );

            if ( isset( $section[2] ) ) {
                $section_args['type'] = $section[2];
            }

            Kirki::add_section( $section_id, $section_args );
        }

        /*--------------------------------------------------------------
        # Site Title Control
        --------------------------------------------------------------*/
        elan_add_field(
            array(
                'type'          => 'toggle',
                'settings'      => 'elan_header_site_title_visible',
                'section'       => 'title_tagline',
                'label'         => esc_html__( 'Display Site Title', 'elan' ),
                'default'       => '1',
            )
        );

        /*--------------------------------------------------------------
        # Tagline Control
        --------------------------------------------------------------*/
        elan_add_field(
            array(
                'type'              => 'toggle',
                'label'             => esc_html__( 'Display Tagline', 'elan' ),
                'settings'          => 'elan_header_site_tagline_visible',
                'section'           => 'title_tagline',
            )
        );

        /*--------------------------------------------------------------
        # Enable Search Control
        --------------------------------------------------------------*/
        elan_add_field(
            array(
                'type'              => 'toggle',
                'settings'          => 'elan_header_search_enable',
                'section'           => 'elan_header_search_section',
                'label'             => esc_html__( 'Enable', 'elan' ),
                'default'           => '1',
                'partial_refresh'   => array(
                    'elan_header_search_enable'    => array(
                        'selector'                  => '.header-search',
                        'render_callback'           => '__return_false',

                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # Header Search Widgets Column Control
        --------------------------------------------------------------*/
        elan_add_field(
            array(
                'type'          => 'custom',
                'settings'      => 'elan_header_search_custom_blank',
                'label'         => esc_html__( 'Search Input', 'elan' ),
                'description'   => sprintf( __( 'To add Search input, go to %1$s (Dashboard -> Appearance -> Widgets) and add %2$s widget to Search Popup Column 1.', 'elan' ),
                                '<a href="'.admin_url( 'widgets.php' ).'" target="_blank">Widgets</a>',
                                '<strong>Search</strong>'
                ),
                'section'       => 'elan_header_search_section',
            )
        );

        /*--------------------------------------------------------------
        # Header Search Background Control
        --------------------------------------------------------------*/
        elan_add_field(
            array(
                'type'      => 'color',
                'settings'  => 'elan_header_search_bg_color',
                'section'   => 'elan_header_search_section',
                'label'     => esc_html__( 'Background', 'elan' ),
                'default'   => 'rgba(255,255,255,1)',
                'choices'   => array(
                    'alpha' => true,
                ),
                'transport'     => 'postMessage',
                'js_vars'       => array(
                    array(
                        'element'   => array( '.search-popup' ),
                        'function'  => 'css',
                        'property'  => 'background'
                    )
                ),
                'output'        => array(
                    array(
                        'element'   => array( '.search-popup' ),
                        'function'  => 'css',
                        'property'  => 'background'
                    )
                )
            )
        );       
    }
endif;
add_action( 'init', 'elan_customizer_header_controls_init', 999 );
