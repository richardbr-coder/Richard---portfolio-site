<?php
/**
 * Functions hooked to custom hook
 *
 * @package Elan
 */

/*----------------------------------------------------------------------
# Header
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_add_header' ) ) :

    /**
     * Header Layout
     *
     * @since 0.1.0
     */
    function elan_add_header() { ?>

        <div class="nav-bar bg-white nav-bar-setting transition-35s">
            <div class="outer-container site-header-container overflow-visible">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <?php get_template_part( 'template-parts/header/header-layout', '10' ); ?>
                    </div><!-- .row -->
                </div><!-- .container-fluid -->
            </div><!-- .outer-container -->
        </div><!-- .nav-bar -->

    <?php }

endif;
add_action( 'elan_action_header', 'elan_add_header', 20 );


/*----------------------------------------------------------------------
# Sidebar hook
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_add_sidebar' ) ) :

    /**
     * Add Sidebar
     *
     * @since 0.1.0
     */
    function elan_add_sidebar() {

        get_sidebar(); // sidebar area

    }

endif;

add_action( 'elan_action_sidebar', 'elan_add_sidebar', 10 );


/*----------------------------------------------------------------------
# Footer widget hook / Footer bar hook
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_add_footer_widgets' ) ) :

    /**
     * Add footer widgets
     *
     * @since 0.1.0
     */
    function elan_add_footer_widgets() {

        get_template_part( 'template-parts/footer/footer', 'widget' ); // Footer Widget Area

    }

endif;

if ( ! function_exists( 'elan_add_footer_bar' ) ) :

    /**
     * Add footer bar
     *
     * @since 0.1.0
     */
    function elan_add_footer_bar() {

        get_template_part( 'template-parts/footer/footer', 'bar' ); // Footer Bar

    }

endif;

add_action( 'elan_action_footer', 'elan_add_footer_widgets', 10 );
add_action( 'elan_action_footer', 'elan_add_footer_bar', 20 );


/*----------------------------------------------------------------------
# Post navigation hook
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_add_posts_pagination' ) ) :

    /**
     * Add custom posts pagination
     *
     * @since 0.1.0
     */
    function elan_add_posts_pagination() {

	    the_posts_pagination();

    }

endif;

add_action( 'elan_action_posts_pagination', 'elan_add_posts_pagination', 10 );

/*----------------------------------------------------------------------
# Before Widgets/ Page header hook / Breadcrumbs hook
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_action_page_header' ) ) :

	/**
	 * Add Page Header
	 *
	 * @since 0.1.0
	 */
	function elan_action_page_header() {

		$page_header    = get_theme_mod( 'elan_archive_header_enable', 'disable' );

		// Bail if static homepage or blog page or is singular pages
		if ( is_front_page() || is_home() || is_singular() || $page_header == 'disable' ) { return; }
		?>
		<div class="page-header archive-header cs-dark">
			<div class="outer-container">
				<div class="container-fluid">
					<div class="row">
						<div class="page-header-items col-12 col-md-10 col-lg-6 d-flex flex-wrap align-items-center text-left">

							<?php

							elan_archive_get_title( '<h1 class="page-title w-100">', '</h1>' );
							the_archive_description( '<div class="archive-description w-100">', '</div>' );

							?>

						</div><!-- .col -->
					</div><!-- .row -->
				</div><!-- .container-fluid -->
			</div><!-- .outer-container -->
		</div><!-- .page-header -->
	<?php
	}

endif;

add_action( 'elan_action_before_main_content', 'elan_action_page_header', 10 );
