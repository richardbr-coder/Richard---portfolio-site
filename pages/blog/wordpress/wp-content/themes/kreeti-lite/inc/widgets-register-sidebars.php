<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kreeti_lite_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Main Sidebar', 'kreeti-lite'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets for main sidebar.', 'kreeti-lite'),
        'before_widget' => '<div id="%1$s" class="widget kreeti-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span class="heading-line-before"></span>',
        'after_title' => '<span class="heading-line-after"></span></h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Off Canvas', 'kreeti-lite'),
        'id'            => 'express-off-canvas-panel',
        'description'   => esc_html__('Add widgets for off-canvas section.', 'kreeti-lite'),
        'before_widget' => '<div id="%1$s" class="widget kreeti-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span class="heading-line-before"></span>',
        'after_title' => '<span class="heading-line-after"></span></h2>',
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer First Section', 'kreeti-lite'),
        'id' => 'footer-first-widgets-section',
        'description' => esc_html__('Displays items on footer first column.', 'kreeti-lite'),
        'before_widget' => '<div id="%1$s" class="widget kreeti-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span class="heading-line-before"></span>',
        'after_title' => '<span class="heading-line-after"></span></h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Second Section', 'kreeti-lite'),
        'id' => 'footer-second-widgets-section',
        'description' => esc_html__('Displays items on footer second column.', 'kreeti-lite'),
        'before_widget' => '<div id="%1$s" class="widget kreeti-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span class="heading-line-before"></span>',
        'after_title' => '<span class="heading-line-after"></span></h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Third Section', 'kreeti-lite'),
        'id' => 'footer-third-widgets-section',
        'description' => esc_html__('Displays items on footer third column.', 'kreeti-lite'),
        'before_widget' => '<div id="%1$s" class="widget kreeti-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span class="heading-line-before"></span>',
        'after_title' => '<span class="heading-line-after"></span></h2>',
    ));


}

add_action('widgets_init', 'kreeti_lite_widgets_init');