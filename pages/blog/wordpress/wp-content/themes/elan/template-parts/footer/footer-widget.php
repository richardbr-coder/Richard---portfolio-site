<?php
/**
 * Footer Widget Section.
 *
 * @package Elan
 */

if ( ( is_active_sidebar( 'footer_sidebar_1' ) || is_active_sidebar( 'footer_sidebar_2' ) || is_active_sidebar( 'footer_sidebar_3' ) || is_active_sidebar( 'footer_sidebar_4' ) ) ) :
    $footer_widget_layout   = 'footer-layout-8';
    $footer_widgets_class   = array( 'footer-widgets' );
    $footer_widgets_class[] = 'cs-light';  ?>

    <div class="<?php echo esc_attr( implode( ' ', $footer_widgets_class ) ); ?>">
        <div class="outer-container">
            <div class="container-fluid">
                <div class="row">
                    <?php get_template_part( 'template-parts/footer/widget-area/col', 4 ); ?>
                </div><!-- .row -->
            </div><!-- .outer-container -->
        </div><!-- .container-fluid -->
    </div><!-- .footer-widgets -->

<?php endif;