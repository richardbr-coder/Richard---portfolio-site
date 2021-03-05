<?php
/**
 * Template part for displaying post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Elan
 */
$header_elements            = array( 'posted-date', 'post-author', 'post-cats', 'post-title' );
$header_class               = array( 'entry-header d-flex flex-wrap' );
$header_element_class       = array( 'header-elements entry-header d-flex flex-wrap align-items-center text-left' );
$featured_img_meta_value    = get_post_meta( get_the_ID(), 'elan_featured_img_type', true );
$default_thumb_type         = get_theme_mod( 'elan_post_default_thumb_type', 'portrait-img' );
$featured_img_type          = ( $featured_img_meta_value && $featured_img_meta_value != 'default-img' ) ? $featured_img_meta_value : $default_thumb_type;

if ( $featured_img_type == 'landscape-img' ) {
    $thumbnail_size = 'elan-1600-900';
    $header_element_class[] = 'w-100';
} elseif ( $featured_img_type == 'full-width-img' ) {
    $thumbnail_size = 'elan-1280-548';
    $header_element_class[] = 'w-100';
} elseif ($featured_img_type == 'portrait-img') {
    $thumbnail_size = 'elan-768-portrait';
    $header_class[] = 'align-items-end';
} elseif ($featured_img_type == 'square-img') {
    $thumbnail_size = 'elan-768-square';
    $header_class[] = 'align-items-end';
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'have-' . $featured_img_type ); ?>>
    <header class="<?php echo esc_attr( implode( ' ', $header_class ) ); ?>">

        <?php if ( has_post_thumbnail() && ( $featured_img_type !== 'full-width-img' ) ) : ?>

            <figure class="post-featured-image">

                <?php the_post_thumbnail( $thumbnail_size, array(
                    'alt' => the_title_attribute( array(
                        'echo' => false,
                    ) ),
                ) ); ?>

            </figure><!-- .post-featured-image -->

        <?php endif; ?>

        <div class="<?php echo esc_attr( implode( ' ', $header_element_class ) ); ?>">

            <?php if ( !empty( $header_elements ) ) :

                foreach ( $header_elements as $header_key => $header_element ) :

                    if ( $header_element == 'post-title' ) :

                        the_title( '<h1 class="entry-title w-100">', '</h1>' );

                    elseif ( $header_element == 'post-cats' ) :

                        elan_cat_links();

                    elseif ( $header_element == 'post-author' ) :

                        elan_post_author();

                    elseif ( $header_element == 'posted-date' ) :

                        elan_posted_date();

                    elseif ( $header_element == 'post-comments' ) :

                        elan_post_comments();

                    endif;

                endforeach;

            endif; ?>

        </div><!-- .header-elements -->
    </header><!-- .entry-header -->

    <div class="entry-content text-left">

        <?php the_content();

        wp_link_pages( array(
            'before'      => '<div class="page-links d-flex flex-wrap align-items-center">' . esc_html__( 'Pages:', 'elan' ),
            'after'       => '</div>',
            'link_before' => '<span class="page-number">',
            'link_after'  => '</span>',
        ) );

        if ( get_edit_post_link() ) :

            edit_post_link(
                sprintf(
                    wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                        __( 'Edit <span class="screen-reader-text">%s</span>', 'elan' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                ),
                '<span class="edit-link">',
                '</span>'
            );

        endif; ?>

    </div><!-- .entry-content -->

    <footer class="entry-footer d-flex flex-wrap align-items-center text-left">

        <?php elan_tags_links(); ?>

    </footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->

<div class="after-footer-content">

    <?php
    the_post_navigation( array(
        'prev_text' => '<span aria-hidden="true" class="meta-nav d-inline-block">'. esc_html__( 'Previous Post', 'elan' ) . '</span>
                <div class="post-nav-content transition-5s">
                    <h2 class="entry-title m-0">%title</h2>
                </div>
                
                <span class="screen-reader-text">' . esc_html__( 'Previous Post', 'elan' ) . '</span>' ,

        'next_text' => '<span aria-hidden="true" class="meta-nav d-inline-block">'. esc_html__( 'Next Post', 'elan' ) . '</span>
                <div class="post-nav-content transition-5s">
                    <h2 class="entry-title m-0">%title</h2>
                </div>
                
                <span class="screen-reader-text">' . esc_html__( 'Next Post', 'elan' ) . '</span>' ,
    ) );

    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
        comments_template();

    endif; ?>

</div><!-- .after-footer-content -->
