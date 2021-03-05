<?php
/**
 * Theme Customizer Global Panel
 *
 * @package Elan
 */

if ( ! function_exists( 'elan_customizer_sidebar_controls_init' ) ) :

    function elan_customizer_sidebar_controls_init() {
        /*--------------------------------------------------------------
        # Panel
        --------------------------------------------------------------*/
        Kirki::add_panel( 'elan_sidebar_settings_panel', array(
            'priority'  =>  122,
            'title'     =>  esc_html__( 'Sidebar Settings', 'elan' ),
        ));

        /*--------------------------------------------------------------
        # Sections
        --------------------------------------------------------------*/
	    $sections['elan_sidebar_section']             = array( esc_html__( 'Sidebar', 'elan' ), '' );

        foreach ( $sections as $section_id => $section ) {
            $section_args = array(
                'title'       => $section[0],
                'description' => $section[1],
                'panel'       => 'elan_sidebar_settings_panel',
            );
            if ( isset( $section[2] ) ) {
                $section_args['type'] = $section[2];
            }
            Kirki::add_section( $section_id, $section_args );
        }

        /*--------------------------------------------------------------
        # Sidebar Layout
        --------------------------------------------------------------*/
        elan_add_field(
            array(
                'type'        => 'radio-image',
                'settings'    => 'elan_sidebar_layout',
                'label'       => esc_html__( 'Layout', 'elan' ),
                'description' => esc_html__( 'This sidebar will be reflected in whole site blog, archives, categories, tags, authors and search result page.', 'elan' ),
                'section'     => 'elan_sidebar_section',
                'default'     => 'right-sidebar',
                'choices'     => array(
                    'full-width'        => ELAN_THEME_URI . '/assets/back-end/images/sidebar/no-sidebar.svg',
                    'left-sidebar'      => ELAN_THEME_URI . '/assets/back-end/images/sidebar/left-sidebar.svg',
                    'right-sidebar'     => ELAN_THEME_URI . '/assets/back-end/images/sidebar/right-sidebar.svg',
                ),
            )
        );
	}

endif;
add_action( 'init', 'elan_customizer_sidebar_controls_init', 999 );
