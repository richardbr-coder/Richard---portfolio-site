<?php
/**
 * Template part for displaying posts on Search page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Elan
 */

$url_link                   = get_the_permalink();
$post_elements              = array( 'post-cats', 'post-title', 'post-excerpt' );
$post_content_class         = array( 'post-content d-flex flex-wrap' );

if ( !has_post_thumbnail() ) {
	$post_content_class[]   = 'w-100';
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-col w-100 text-left' ); ?>>
    <div class="post-content-wrap d-flex flex-wrap align-items-center justify-content-between">
        <h5 class="post-type w-100"><?php echo esc_html(get_post_type()); ?></h5>

        <?php if ( has_post_thumbnail() ) { // Featured Image ?>

            <div class="post-thumbnail-wrap" data-aos="fade-up" data-aos-once="true">
                <figure class="post-thumbnail d-block">
                    <a class="post-thumbnail-link d-block" href="<?php echo esc_url( $url_link ); ?>">

                        <?php the_post_thumbnail( 'elan-768-portrait', array(
                            'alt' => the_title_attribute( array(
                                'echo' => false,
                            ) ),
                        ) ); ?>

                    </a><!-- .post-thumbnail-link -->
                </figure><!-- .post-thumbnail -->

                <?php if( is_sticky() ) {
                    echo '<span class="sticky-icon position-absolute d-flex justify-content-center align-items-center"><i class="fas fa-thumbtack"></i></span>';
                } ?>

            </div><!-- .post-thumbnail-wrap -->

        <?php } ?>

        <div class="<?php echo esc_attr( implode( ' ', $post_content_class ) ); ?>" data-aos="fade-up" data-aos-once="true" data-aos-delay="150">

            <?php if ( !empty( $post_elements ) ) :

                foreach ( $post_elements as $header_key => $header_element ) :

                    if ( $header_element == 'post-cats' ) :

                        elan_cat_links();

                    elseif ( $header_element == 'post-title' ) :

                        the_title( '<h2 class="entry-title w-100 td-none"><a class="d-block transition-35s" href="' . esc_url( $url_link ) . '" rel="bookmark">', '</a></h2>' );

                    elseif ( $header_element == 'post-excerpt' ) : ?>

                        <div class="entry-content w-100">
                            <p class="mb-0"><?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), 30, '' ) ); ?></p>
                        </div><!-- .entry-content -->

                    <?php

                    endif;

                endforeach;

            endif; ?>

        </div><!-- .post-content -->

    </div><!-- .post-content-wrap -->
</article><!-- #post-<?php the_ID(); ?> -->
