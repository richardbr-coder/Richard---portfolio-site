<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Elan
 */
?>

</div><!-- #content -->


<div class="footer-separator"></div>


<footer class="site-footer" role="contentinfo">

    <?php
    /**
     * Hook - elan_action_footer.
     *
     * @hooked elan_add_footer_widgets - 10
     * @hooked elan_add_footer_bar - 20
     */
    do_action( 'elan_action_footer' );
    ?>

</footer><!-- .site-footer -->
</div><!-- #page -->

<div class="back-to-top d-none d-lg-flex align-items-center">
    <div class="bt-text">
        <?php echo esc_html__( 'Back to Top', 'elan' ); ?>
    </div><!-- .bt-text -->

    <span class="d-block pt-icon icon-arrow-right"></span>
</div><!-- .back-to-top -->

<?php wp_footer(); ?>

</body>
</html>
