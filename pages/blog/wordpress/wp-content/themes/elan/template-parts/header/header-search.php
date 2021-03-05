<?php
/**
 * Header Search
 *
 * @package Elan
 */

$search_enabled             = get_theme_mod( 'elan_header_search_enable', true );

if ( $search_enabled == true ) : ?>

    <div class="header-search d-flex align-items-center cursor-pointer">
        <button class="pt-icon icon-search"></button>
    </div><!-- .header-search -->

    <div class="search-popup d-flex align-items-center fixed-top overflow-y-auto w-100 h-100 opacity-0 invisible transition-5s">        

        <div class="outer-container my-auto">
            <div class="container position-relative">
                <div class="row align-items-center justify-lg-content-center">

                    <div class="col-12 offset-lg-1 col-lg-10 my-4">
                        <div class="search-popup-widgets">

                            <?php
                            if ( is_active_sidebar( 'header_search_sidebar_1' ) ) {
                                dynamic_sidebar( 'header_search_sidebar_1' );
                            } else {
                                printf( __( 'No widgets found! <a href="%s" target="_blank">Add Widget </a>', 'elan'), esc_url( admin_url( 'widgets.php' ) ) );
                            };
                            ?>

                        </div><!-- .search-popup-widgets -->
                    </div><!-- .col -->

                </div><!-- .row -->
            </div><!-- .container-fluid -->
            <div class="search-close">
                <button class="pt-icon icon-cross"></button>
            </div><!-- .search-close -->
        </div><!-- .outer-container -->
    </div><!-- .search-popup -->

<?php endif;
