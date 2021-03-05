<?php
/**
 * Footer Bar Section.
 *
 * @package Elan
 */

$content_order_lists    = get_theme_mod( 'elan_footer_bar_content_order_list', array( 'footer-bar-text' ) );

if ( ! empty( $content_order_lists ) ) :
    $footer_bar_class   = array( 'footer-bar cs-dark' );
    $footer_row_class   = array( 'row flex-wrap align-items-center justify-content-center justify-content-lg-between' );
    ?>

    <div class="footer-bar-separator"></div>

    <div id="colophon" class="<?php echo esc_attr( implode( ' ', $footer_bar_class ) ); ?>" role="contentinfo">
        <div class="outer-container footer-outer-container">
            <div class="container-fluid">
                <div class="<?php echo esc_attr( implode( ' ', $footer_row_class ) ); ?>">

                    <?php foreach ( $content_order_lists as $key => $content_order )  :

                        $footer_content_order = $key + 1;

                        if ( $content_order == 'footer-bar-text' ) { ?>

                            <div class="footer-copyright order-3 order-lg-<?php echo esc_attr( $footer_content_order )?> mt-3 mb-2 mb-lg-0 mt-lg-0">
                                <?php do_action( 'elan_footer_copyright' ); ?>
                            </div><!-- .footer-copyright -->

                        <?php } elseif ( $content_order == 'footer-bar-menu' ) {

                            $menu_id = get_theme_mod( 'elan_footer_bar_menu_id' );

                            $nav_menu 	= ( empty( $menu_id ) ? false : wp_get_nav_menu_object( $menu_id ) ); ?>

                            <div class="footer-bar-menu order-2 order-lg-<?php echo esc_attr( $footer_content_order ); ?> mt-3 mt-lg-0">

                                <?php if ( $nav_menu ) {

                                    wp_nav_menu(array(
                                        'menu'          => $nav_menu,
                                        'menu_id'       => 'footer-bar-nav',
                                        'container'     => 'ul',
                                        'menu_class'    => 'd-flex flex-wrap justify-content-center align-items-center p-0 m-0 ls-none',
                                        'depth'         => 1
                                    ));
                                } else {
                                    $menus_link = admin_url('nav-menus.php');
                                    printf( __( '<p class="m-0">Menu not found! Assign a <a href="%s" target="_blank">Menu</a> & choose menu to display in footer bar from ( Appearance - > Customize -> Footer - > Footer Bar and Choose a Menu from dropdown lists. )</p>', 'elan' ), esc_url( $menus_link ) );

                                } ?>

                            </div><!-- .footer-menu -->

                        <?php }

                    endforeach; ?>

                </div><!-- .row -->
            </div><!-- .container-fluid -->
        </div><!-- .outer-container -->
    </div><!-- .footer-bar -->

<?php endif;
