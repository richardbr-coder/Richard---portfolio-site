<?php
/**
 * Header Layout 10
 *
 * @package Elan
 */

$enable_site_title      = get_theme_mod( 'elan_header_site_title_visible', true );
$enable_site_tagline    = get_theme_mod( 'elan_header_site_tagline_visible' );
$enable_search          = get_theme_mod( 'elan_header_search_enable', true );
$site_title_col     = 'col-9 col-lg-3';
$menu_col           = 'd-flex flex-wrap justify-content-end align-items-center col-3 col-lg-9';
$menu_class         = 'primary-menu d-flex flex-wrap flex-column flex-lg-row justify-content-end p-0 m-0 ls-none'; ?>

<div class="body-overlay w-100 h-100 opacity-0 invisible transition-5s"></div>

<div class="<?php echo esc_attr( $site_title_col ); ?>">
    <div class="site-branding d-flex flex-wrap align-items-center">

        <?php the_custom_logo(); ?>

        <div class="site-title-wrap">

            <?php $site_title = get_bloginfo( 'name ');

            $site_title_class = array( 'site-title' );

            if ( $enable_site_title !== true ) {
                $site_title_class[] = 'screen-reader-text';
            }

            if ( is_front_page() && is_home() ) : ?>

                <h1 class="<?php echo esc_attr( implode(' ', $site_title_class ) ); ?>"><a class="d-inline-block td-none outline-none" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( $site_title ); ?></a></h1>

            <?php else : ?>

                <p class="<?php echo esc_attr( implode(' ', $site_title_class ) ); ?>"><a class="d-inline-block td-none outline-none" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( $site_title ); ?></a></p>

            <?php endif;

            if ( $enable_site_tagline == true ) :

                $elan_description = get_bloginfo( 'description', 'display' );
                if ( $elan_description || is_customize_preview() ) : ?>

                    <p class="site-description"><?php echo wp_kses_post( $elan_description ); /* WPCS: xss ok. */ ?></p>

                <?php endif;

            endif; ?>

        </div><!-- .site-title-wrap -->
    </div><!-- .site-branding -->
</div><!-- .col -->

<div class="<?php echo esc_attr( $menu_col ); ?>">
    <div class="extended-header d-lg-none d-flex justify-content-end align-items-center">
        <?php get_template_part( 'template-parts/header/header', 'search' ); // Header Search ?>

        <a href="#" class="hamburger-menu cursor-pointer">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </a><!-- .hamburger-menu -->


    </div><!-- .extended-header -->
    <nav class="main-navigation slide-in transition-5s" role="navigation">     

        <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_id' => 'primary-menu', 'container' => 'ul', 'menu_class' => $menu_class ) ); ?>
          <div class="close-navigation d-flex justify-content-center align-items-center position-absolute transition-5s cursor-pointer d-lg-none">
            <a class="pt-icon icon-cross" href="#"></a></div>
    </nav><!-- .main-navigation -->

    <div class="extended-header d-none d-lg-flex justify-content-end align-items-center">
        
        <?php get_template_part( 'template-parts/header/header', 'search' ); // Header Search ?>

    </div><!-- .extended-header -->
</div><!-- .col -->
