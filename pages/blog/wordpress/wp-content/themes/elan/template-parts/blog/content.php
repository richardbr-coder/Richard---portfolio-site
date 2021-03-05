<?php
/**
 * Template part for displaying posts on archive page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Elan
 */

$url_link                       = get_the_permalink();
$featured_img_meta_value        = get_post_meta( get_the_ID(), 'elan_featured_img_type', true );
$default_thumb_type             = get_theme_mod( 'elan_archive_default_thumb_type', 'portrait-img' );
$featured_img_type              = ( $featured_img_meta_value && $featured_img_meta_value != 'default-img' ) ? $featured_img_meta_value : $default_thumb_type;
$post_elements                  = array( 'post-cats','post-title', 'post-excerpt' );
$excerpt_length                 = '15';
$excerpt_length_landscape       = '30';

$post_class     = array( 'post-col text-left' );
$post_class[]   = $featured_img_type;

if ( $featured_img_type != 'full-width-img' ) {
    $post_class[] = 'thumb-align-left';
}

if ( $featured_img_type == 'landscape-img' ) {
    $thumbnail_size = 'elan-768-landscape';
} elseif ( $featured_img_type == 'full-width-img' ) {
    $thumbnail_size = 'elan-1280-548';
    $excerpt_length = $excerpt_length_landscape;
} elseif ( $featured_img_type == 'square-img' ) {
    $thumbnail_size = 'elan-768-square';
} else {
    $thumbnail_size = 'elan-768-portrait';
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
    <div class="post-content-wrap d-flex flex-wrap justify-content-between align-items-stretch">
        <div class="post-thumbnail-wrap" data-aos="fade-up" data-aos-once="true">
            <figure class="post-thumbnail d-block">
                <a class="post-thumbnail-link d-block h-100" href="<?php echo esc_url( $url_link ); ?>">

                    <?php if ( has_post_thumbnail() ) {

                        the_post_thumbnail( $thumbnail_size, array(
                            'class' => 'primary-thumbnail object-fit-cover',
                            'alt'   => the_title_attribute( array(
                                    'echo' => false
                                )
                            ),
                        ) );

                    } else {

                        $img_src = ELAN_THEME_URI . '/assets/front-end/images/'.$thumbnail_size.'.svg';
                        echo '<img src="'.esc_url( $img_src ).'" alt="'.the_title_attribute( array( 'echo' => false ) ).'">';

                   } ?>

                </a><!-- .post-thumbnail-link -->
            </figure><!-- .post-thumbnail -->

         <?php if ( is_sticky() ) { echo '<span class="sticky-icon position-absolute d-flex justify-content-center align-items-center"><i class="dashicons dashicons-admin-post"></i></span>'; } ?>

        </div><!-- .post-thumbnail-wrap -->

        <div class="post-content d-flex align-items-end">
            <div class="post-content-holder d-flex flex-wrap justify-content-start align-items-center" data-aos="fade-up" data-aos-once="true" data-aos-delay="200">

                <?php if ( !empty( $post_elements ) ) :

                    foreach ( $post_elements as $header_key => $header_element ) :

                        if ( $header_element == 'post-cats' ) :

                            elan_cat_links();

                        elseif ( $header_element == 'post-title' ) :

                            the_title( '<h2 class="entry-title w-100 td-none"><a class="d-block transition-35s" href="' . esc_url( $url_link ) . '" rel="bookmark">', '</a></h2>' );

                        elseif ( $header_element == 'posted-date' ) :

                            elan_posted_date();

                        elseif ( $header_element == 'post-excerpt' && $excerpt_length > 0 ) : ?>

                            <div class="entry-content w-100">
                                <p class="mb-0"><?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), $excerpt_length, '' ) ); ?></p>
                            </div><!-- .entry-content -->

                        <?php

                        endif;

                    endforeach;

                endif; ?>

            </div><!-- .post-content-holder -->
        </div><!-- .post-content -->
    </div><!-- .post-content-wrap -->
</article><!-- #post-<?php the_ID(); ?> -->
