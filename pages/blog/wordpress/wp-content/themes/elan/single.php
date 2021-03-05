<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Elan
 */

get_header();

$row_class          = array( 'row' );
$primary_class      = array( 'content-area' );

if ( elan_has_secondary_content_class() != 'full-width' ) {
	$row_class[]    = 'have-sidebar';
}

if ( elan_has_primary_content_class() ) {
	$primary_class[] = elan_has_primary_content_class();
}

$primary_class[]    = 'have-' . elan_get_sidebar_layout();

while ( have_posts() ) : the_post();

    /**
    * Hook - elan_action_before_main_content
    */
    do_action( 'elan_action_before_main_content' ); ?>

    <div class="outer-container have-mt">
        <div class="container-fluid">
            <div class="<?php echo esc_attr( implode( ' ', $row_class ) ); ?>">

                <?php
                $featured_img_meta_value    = get_post_meta( get_the_ID(), 'elan_featured_img_type', true );
                $default_thumb_type         = get_theme_mod( 'elan_post_default_thumb_type', 'portrait-img' );
                $featured_img_type          = ( $featured_img_meta_value && $featured_img_meta_value != 'default-img' ) ? $featured_img_meta_value : $default_thumb_type;

                if ( $featured_img_type == 'full-width-img' ) : ?>

                    <figure class="post-featured-image full-width w-100">

                        <?php the_post_thumbnail( 'elan-1280-548', array(
                            'alt' => the_title_attribute( array(
                                'echo' => false,
                            ) ),
                        ) ); ?>

                    </figure><!-- .post-featured-image -->

                <?php endif; ?>

                <div class="col-12 d-flex flex-wrap">
                    <div id="primary" class="<?php echo esc_attr( implode( ' ', $primary_class ) ); ?>">
                        <main id="main" class="site-main" role="main">

                            <?php

                            /*
                             * Include the Post-Type-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                             */
                            get_template_part( 'template-parts/post/content', get_post_format() ); ?>

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

    endwhile; // End of the loop.

get_footer();
