<?php
/**
 * Theme Customizer Post Panel
 *
 * @package Elan
 */

if ( ! function_exists( 'elan_customizer_post_controls_init' ) ) :

    function elan_customizer_post_controls_init() {
        /*--------------------------------------------------------------
        # Post Panel
        --------------------------------------------------------------*/
        Kirki::add_panel('elan_post_panel', array(
            'priority' => 122,
            'title' => esc_html__('Single Post Settings', 'elan'),
        ));

        /*--------------------------------------------------------------
        # Sections
        --------------------------------------------------------------*/
        $sections = array('elan_post_thumb_settings_section' => array(esc_html__('Thumbnail Settings', 'elan'), ''));

        foreach ($sections as $section_id => $section) {
            $section_args = array(
                'title' => $section[0],
                'description' => $section[1],
                'panel' => 'elan_post_panel',
            );

            if (isset($section[2])) {
                $section_args['type'] = $section[2];
            }
            Kirki::add_section($section_id, $section_args);
        }

        /*--------------------------------------------------------------
        # Default Thumbnail: Type
        --------------------------------------------------------------*/
        elan_add_field(
            array(
                'type'        => 'select',
                'label'       => esc_html__( 'Default Thumbnail: Type', 'elan' ),
                'description' => esc_html__( 'Select default thumbnail image for post. It will set the "Featured Image Type" while creating new post.', 'elan' ),
                'settings'    => 'elan_post_default_thumb_type',
                'section'     => 'elan_post_thumb_settings_section',
                'default'     => 'portrait-img',
                'choices'     => array(
                    'portrait-img'      => esc_html__( 'Portrait Image', 'elan' ),
                    'square-img'        => esc_html__( 'Square Image', 'elan' ),
                    'landscape-img'     => esc_html__( 'Landscape Image', 'elan' ),
                    'full-width-img'    => esc_html__( 'Wide Image', 'elan' ),
                ),
            )
        );

    }
endif;
add_action( 'init', 'elan_customizer_post_controls_init', 999 );