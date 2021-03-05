<?php
/**
 * Theme Breadcrumb Section.
 *
 * @package Elan
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Bail if static homepage or blog page or search page or 404 error page
if ( is_front_page() || is_home() || is_search() || is_404() ) {
    return;
}

if ( ! function_exists( 'elan_breadcrumb' ) ) {
    require ELAN_THEME_DIR . '/inc/libraries/breadcrumb-trail/breadcrumbs.php';
} ?>

<div class="outer-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div id="breadcrumb">

                    <?php $breadcrumb_args = array(
                        'delimiter'   => get_theme_mod( 'elan_breadcrumb_delimiter', '/' ),
                        'show_browse' => false,
                    );

                    elan_breadcrumb( $breadcrumb_args ); ?>

                </div><!-- #breadcrumb -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container-fluid -->
</div><!-- .outer-container -->
