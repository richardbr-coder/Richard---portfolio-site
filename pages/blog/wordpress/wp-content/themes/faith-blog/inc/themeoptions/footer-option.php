<?php
$wp_customize->add_section(
	'footer_sections',
	array(
		'priority'       => 1,
		'panel'          => 'faith-blog',
		'title'          => __( 'Footer Sections', 'faith-blog' ),
		'capability'     => 'edit_theme_options',
	)
);
$wp_customize->add_setting(
	'transparent_footer_bg',
	array(
		'default' => false,
		'transport'            => 'refresh', // Options: refresh or postMessage.
		'capability'           => 'edit_theme_options',
		'sanitize_callback'    => 'faith_blog_sanitize_checkbox'
	)
);
$wp_customize->add_control(
	'transparent_footer_bg',
	array(
		'label'       => __( 'Transparent Footer Background', 'faith-blog' ),
		'section'     => 'header_sections',
		'type'        => 'checkbox',
	)
);
$wp_customize->add_setting(
	'footer_column',
	array(
		'transport'            => 'refresh',
		'capability'           => 'edit_theme_options',
		'sanitize_callback'     => 'faith_blog_sanitize_radio',
		'default'     => 'four',
	)
);

$wp_customize->add_control(
	'footer_column',
	array(
		'label'       => __( 'Footer Column', 'faith-blog' ),
		'section'     => 'footer_sections',
		'type'        => 'radio',
		'choices' => array(
			'two' => __( '2 Column', 'faith-blog' ),
			'three' => __( '3 Column', 'faith-blog' ),
			'four' => __( '4 Column', 'faith-blog' ),
		),
	)
);

$wp_customize->add_section( 'footer_copyright', array(
	'title'       => __( 'Footer Copyright' , 'faith-blog' ),
	'priority'    => 10,
	'panel' => 'faith-blog',
) );

if (class_exists('Fbdacr_Init')) :
	$wp_customize->add_setting(
		'copyright_text',
		array(
			'transport'            => 'refresh', // Options: refresh or postMessage.
			'capability'           => 'edit_theme_options',
			'sanitize_callback'     => 'wp_kses_post',
		)
	);
	// Control: Name.
	$wp_customize->add_control(
		'copyright_text',
		array(
			'label'       => __( 'Copyright Text', 'faith-blog' ),
			'section'     => 'footer_copyright',
			'type'        => 'textarea',
		)
	);
endif;
/** Important Links */
$wp_customize->add_setting( 'faith_blog_footer_copyright',
    array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    )
);

$footer_copyright = '<p class="one-click-demo-import">';
$footer_copyright .= sprintf( __( 'Download Demo Data + Footer Copyright Text Editor + Author Widget Plugin: %1$sClick here.%2$s', 'faith-blog' ),  '<a href="' . esc_url( 'https://theimran.com/themes/wordpress-free-themes/faith-blog-wordpress-theme/' ) . '" target="_blank">', '</a>' );
$footer_copyright .= '</p><p>';
$footer_copyright .= __( 'After Activate this plugin you will be able to Edit/Delete footer copyright text, import demo content in 1-click and Display Author Widget In Sidebar.', 'faith-blog' );;
$footer_copyright .= '</p>';
$wp_customize->add_control( new Faith_Blog_Note_Control( $wp_customize,
    'faith_blog_footer_copyright', 
        array(
            'section'     => 'footer_copyright',
            'description' => $footer_copyright
        )
    )
);