<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Elan
 */

get_header();

$row_class              = array( 'row' );
$primary_class          = array( 'content-area' );
$primary_class[]        = 'text-left';

if ( elan_has_secondary_content_class() != 'full-width' ) {
    $row_class[]    = 'have-sidebar';
}

if ( elan_has_primary_content_class() ) {
    $primary_class[] = elan_has_primary_content_class();
}

/**
 * Hook - elan_action_before_main_content
 */
do_action( 'elan_action_before_main_content' ); ?>

    <div class="outer-container have-mt">
        <div class="container-fluid">
            <div class="<?php echo esc_attr( implode( ' ', $row_class ) ); ?>">
                <div class="col-12 d-flex flex-wrap">
                    <div id="primary" class="<?php echo esc_attr( implode( ' ', $primary_class ) ); ?>">
                        <main id="main" class="site-main" role="main">
                            <section class="error-404 not-found">
                                <div class="page-content">
                                    <div class="entry-content">

                                        <h1 class="page-title"><?php echo esc_html__( 'Oops! That page can&rsquo;t be found.', 'elan' ); ?></h1>

                                        <p class="error-description"><?php echo esc_html__( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'elan' ); ?></p>

                                    </div><!-- .entry-content -->

                                    <div class="404-search-wrap mt-5 mb-5">
                                        <?php get_search_form(); ?>
                                    </div><!-- .404-search-wrap -->

                                </div><!-- .page-content -->
                            </section><!-- .error-404 -->
                        </main><!-- #main -->
                    </div><!-- #primary -->

                    <?php
                    /**
                     * Hook - elan_action_sidebar.
                     *
                     * @hooked: elan_add_sidebar - 10
                     */
                    do_action( 'elan_action_sidebar' ); ?>

                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container-fluid -->
    </div><!-- .outer-container -->

<?php

/**
 * Hook - elan_action_after_main_content
 *
 * @hooked: elan_action_after_widget - 10
 */
do_action( 'elan_action_after_main_content' );

get_footer();
