<?php
/**
 * Theme Customizer Post Panel
 *
 * @package Elan
 */

if ( ! function_exists( 'elan_customizer_blog_controls_init' ) ) :

    function elan_customizer_blog_controls_init() {
        /*--------------------------------------------------------------
        # Panel
        --------------------------------------------------------------*/
        Kirki::add_panel( 'elan_archive_panel', array(
            'priority'      => 122,
            'title'         => esc_html__( 'Archive/Blog Settings', 'elan' ),
        ));

        /*--------------------------------------------------------------
        # Sections
        --------------------------------------------------------------*/
		$sections = array('elan_archive_header_section'              => array( esc_html__( 'Page Header', 'elan' ), '' ) );
		$sections['elan_archive_thumbnail_section']                  = array( esc_html__( 'Thumbnail Setting', 'elan' ), '' );

        foreach ($sections as $section_id => $section) {
            $section_args = array(
                'title'         => $section[0],
                'description'   => $section[1],
                'panel'         => 'elan_archive_panel',
            );

            if (isset($section[2])) {
                $section_args['type'] = $section[2];
            }
            Kirki::add_section($section_id, $section_args);
        }

		/*--------------------------------------------------------------
        # Archive Page Header Enable
        --------------------------------------------------------------*/
		elan_add_field(
			array(
				'type'        => 'select',
				'label'       => esc_html__( 'Activate', 'elan' ),
				'description' => esc_html__( 'Enable/Disable page header sections for the archive pages.','elan' ),
				'settings'    => 'elan_archive_header_enable',
				'section'     => 'elan_archive_header_section',
				'default'     => 'disable',
				'choices'     => array(
					'enable'      	=> esc_html__( 'Enable', 'elan' ),
					'disable'		=> esc_html__( 'Disable', 'elan' ),
				),
			)
		);

        /*--------------------------------------------------------------
        # Default Thumbnail: Type
        --------------------------------------------------------------*/
        elan_add_field(
            array(
                'type'        => 'select',
                'label'       => esc_html__( 'Default Thumbnail: Type', 'elan' ),
                'description' => esc_html__( 'Select default thumbnail image for posts. It will set the "Featured Image Type" while creating new post for the blog or archive pages.', 'elan' ),
                'settings'    => 'elan_archive_default_thumb_type',
                'section'     => 'elan_archive_thumbnail_section',
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
add_action( 'init', 'elan_customizer_blog_controls_init', 999 );
