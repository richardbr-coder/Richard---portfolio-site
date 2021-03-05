<?php
/**
 * Functions which enhance the theme by hooking into WordPress and Core theme Functions.
 *
 * @package Elan
 */

/*----------------------------------------------------------------------
# Exit if accessed directly
-------------------------------------------------------------------------*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*----------------------------------------------------------------------
# Adds custom classes to the array of body classes.
-------------------------------------------------------------------------*/
if ( !function_exists( 'elan_body_classes' ) ) {
    /**
     * @param array $classes Classes for the body element.
     * @return array
     */
    function elan_body_classes( $classes ) {

        // Adds a class of hfeed to non-singular pages.
        if ( ! is_singular() ) {
            $classes[] = 'hfeed';
        }

        return apply_filters( 'elan_body_classes', $classes );
    }
}
add_filter( 'body_class', 'elan_body_classes' );

/*----------------------------------------------------------------------
# Add a pingback url auto-discovery header for single posts, pages, or attachments.
-------------------------------------------------------------------------*/
if ( !function_exists( 'elan_pingback_header' ) ) {

    function elan_pingback_header() {
        if ( is_singular() && pings_open() ) {
            echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
        }
    }
}
add_action( 'wp_head', 'elan_pingback_header' );

/*----------------------------------------------------------------------
# Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
-------------------------------------------------------------------------*/
if ( !function_exists( 'page_menu_args' ) ) {
    function page_menu_args( $args ) {
        $args['show_home'] = true;
        return $args;
    };
}
add_filter( 'wp_page_menu_args', 'page_menu_args', 10, 1 );

/*----------------------------------------------------------------------
# Prints HTML with meta information for the categories.
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_cat_links' ) ) {

    function elan_cat_links( $before='', $after='') {

        if ( 'post' === get_post_type() ) {

            $cat_sep            = '<span class="item-sep vertical-line"></span>';
            $categories_list    = get_the_category_list( $cat_sep );
            $output             = '';

            if ( $categories_list ) {
                $output .= '<div class="cat-links post-meta-item d-flex flex-wrap align-items-center">';
                $output .= $categories_list;
                $output .= '</div><!-- .cat-links -->';
            }

            // Filter
            $output = apply_filters( 'elan_cat_links', $output );

            if ( ! empty( $output ) ) {
                echo $before . $output . $after;
            }

        }

    }

}

/*----------------------------------------------------------------------
# Prints HTML with meta information for the tags.
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_tags_links' ) ) {

    function elan_tags_links( $before='', $after='' ) {
        if ( 'post' === get_post_type() ) {

            $tag_sep    = '<span class="item-sep ' . esc_attr( get_theme_mod( 'elan_global_tags_separator' , 'comma' ) ) . '"></span>';
            $tags_list  = get_the_tag_list( '', $tag_sep );
            $output     = '';

            if ( $tags_list ) {

                $output .= '<div class="tags-links post-meta-item d-flex flex-wrap align-items-center">';

                $output .= '<span class="pt-icon icon-tags"></span>';
                $output .= '<label>'.esc_html__( 'Tags:', 'elan' ).'</label>';

                $output .= $tags_list;
                $output .= '</div><!-- .tags-links -->';
            }
            // Filter
            $output = apply_filters( 'elan_tags_links', $output );

            if ( ! empty( $output ) ) {
                echo $before . $output . $after;
            }

        }

    }

}

/*----------------------------------------------------------------------
# Prints HTML with meta information for the author.
-------------------------------------------------------------------------*/
if ( !function_exists( 'elan_post_author' ) ) {

    function elan_post_author( $before = '', $after = '' ) {
        $output = '';
        $output .= '<div class="post-author post-meta-item d-flex flex-wrap align-items-center">';
        $output .= '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a>';
        $output .= '</div>';

        // Filter
        $output = apply_filters( 'elan_post_author', $output );

        if ( ! empty( $output ) ) {
            echo $before . $output . $after;
        }
    }
}

/*----------------------------------------------------------------------
# Prints HTML with meta information for the comments.
-------------------------------------------------------------------------*/
if ( !function_exists( 'elan_post_comments' ) ) {

    function elan_post_comments( $before='', $after='') {

        $count      = (int) get_comments_number( get_the_ID() );
        $output     = '';
        $output     .= '<div class="comments-count post-meta-item d-flex flex-wrap align-items-center">';

        $output     .= '<span class="pt-icon icon-comments"></span>';
        $output     .= '<label class="mb-0">'.esc_html__( 'Comments:', 'elan' ).'</label>';

        $output     .= '<a href="' . esc_url( get_comments_link( get_the_ID() ) ) . '">';

        $output     .= '<span class="total-post-comments">';

        $output     .= absint( $count );
        $output     .= '</span>';
        $output     .= '</a>';
        $output     .= '</div>';

        // Filter
        $output = apply_filters( 'elan_post_comments', $output );

        if ( ! empty( $output ) ) {
            echo $before . $output . $after;
        }

    }
}

/*----------------------------------------------------------------------
# Prints HTML with meta information for the date.
-------------------------------------------------------------------------*/
if ( !function_exists( 'elan_posted_date' ) ) {

    function elan_posted_date( $before='', $after='' ) {

        $time_string = '<time class="entry-date post-meta-item published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = sprintf(
            '<span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a>',
            _x( 'Posted on', 'Used before publish date.', 'elan' ),
            esc_url( get_month_link(get_the_time('Y'), get_the_time('m')) ),
            $time_string
        );

        $output = '';
        $output .= '<div class="posted-on post-meta-item d-flex flex-wrap align-items-center">';

        $output .= $posted_on;
        $output .= '</div>';

        // Filter
        $output = apply_filters( 'elan_posted_date', $output );

        if ( ! empty( $output ) ) {
            echo $before . $output . $after;
        }
    }
}

/*----------------------------------------------------------------------
# Prints HTML with meta information read more button
-------------------------------------------------------------------------*/
if ( !function_exists( 'elan_read_more' ) ) {
    function elan_read_more( $before='', $after='' ) {

        $output     = '';
        $output     .= '<div class="w-100"><div class="d-inline-block position-relative read-more custom">';
        $output     .= '<a class="d-inline-block td-none transition-35s" href="'.esc_url( get_the_permalink() ).'">' . esc_html__( 'Read More', 'elan' ) . '</a>';
        $output .= '</div></div>';

        // Filter
        $output = apply_filters( 'elan_read_more', $output );

        if ( ! empty( $output ) ) {
            echo $before . $output . $after;
        }
    }
}
/*----------------------------------------------------------------------
# Add Action for the copyright information.
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_footer_copyright_information' ) ) {
    /**
     * Function to show the copyright information
     */
    function elan_footer_copyright_information() {
        printf( '<div class="site-info">%1$s <a href="%2$s">%3$s.</a> %4$s.<span class="sep"> | </span>%5$s <a href="%6$s" rel="designer" target="_blank">Precise Themes</a> |  %8$s <a href="%7$s" target="_blank"> %9$s </a> </div><!-- .site-info -->',
            sprintf('%1$s %2$s',
                esc_html__( 'Copyright &copy;', 'elan' ),
                esc_html( date('Y') )
            ),
            esc_url( home_url( '/' ) ),
            esc_html( get_bloginfo( 'name', 'display' ) ),
            esc_html__( 'All rights reserved','elan' ),
            esc_html__( 'Designed by','elan' ),
            esc_url( 'http://precisethemes.com/' ),
            esc_url('https://wordpress.org/'),
            esc_html__( 'Proudly powered by','elan' ),
            esc_html__( 'Wordpress.org','elan' )
        );
    }
}
add_action( 'elan_footer_copyright', 'elan_footer_copyright_information', 5 );


/*----------------------------------------------------------------------
# Returns sidebar layout
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_get_sidebar_layout' ) ) {
    function elan_get_sidebar_layout( $post_id = '' ) {

        // Global Sidebar Layout
        $global_layout = get_theme_mod( 'elan_sidebar_layout', 'right-sidebar' );

        // Get post ID
        $post_id = $post_id ? $post_id : get_the_ID();

        // Bail if static homepage or blog page
        if ( is_front_page() || is_home() ) {

            // Blog Page ID
            if ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
                $post_id = $page_for_posts;
            }

            // Check meta first to override and return (prevents filters from overriding meta)
            if ( $post_id && $meta = get_post_meta( $post_id, 'elan_sidebar_layout', true ) ) {

                return apply_filters( 'elan_get_sidebar_layout', esc_attr( $meta ) );

            }

        }

        // Bail if single page
        elseif ( is_404() ) {

            $global_layout = 'full-width';
        }

        // Bail if single page
        elseif ( is_page() ) {

            // Check meta first to override and return (prevents filters from overriding meta)
            if ( $post_id && $meta = get_post_meta( $post_id, 'elan_sidebar_layout', true ) ) {

                return apply_filters( 'elan_get_sidebar_layout', esc_attr( $meta ) );

            }
        }

        // Bail if single post
        elseif ( is_single() ) {

            // Check meta first to override and return (prevents filters from overriding meta)
            if ( $post_id && $meta = get_post_meta( $post_id, 'elan_sidebar_layout', true ) ) {

                return apply_filters( 'elan_get_sidebar_layout', esc_attr( $meta ) );

            }
        }

        // Apply filters and return
        return apply_filters( 'elan_get_sidebar_layout', esc_attr( $global_layout ) );

    }
}

/*----------------------------------------------------------------------
# Primary Class
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_has_primary_content_class' ) ) {
    function elan_has_primary_content_class() {

        $sidebar_layout = elan_get_sidebar_layout();

        if ( $sidebar_layout == 'right-sidebar' ) {
            $primary_class = 'order-1';
        }
        elseif ( $sidebar_layout == 'left-sidebar' ) {
            $primary_class = 'order-2';
        }
        else {
            $primary_class = 'full-width';
        }
        // Apply filters and return
        return apply_filters( 'elan_has_primary_content_class', $primary_class );

    }
}

/*----------------------------------------------------------------------
# Secondary Class
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_has_secondary_content_class' ) ) {
    function elan_has_secondary_content_class() {

        $sidebar_layout = elan_get_sidebar_layout();

        if ( $sidebar_layout == 'right-sidebar' ) {
            $secondary_class = 'order-2';
        } elseif ( $sidebar_layout == 'left-sidebar' ) {
            $secondary_class = 'order-1';
        } else {
            $secondary_class = $sidebar_layout;
        }
        // Apply filters and return
        return apply_filters( 'elan_has_secondary_content_class', $secondary_class );

    }
}

/*----------------------------------------------------------------------
# Get menu list
# @return array of menu list with menu id as index and menu name as value
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_get_menus' ) ) {
    /**
     * Get menu list
     * @return array of menu list with menu id as index and menu name as value
     */
    function elan_get_menus() {
        $menu_list = array();
        $nav_menus = wp_get_nav_menus();
        if ( count( $nav_menus ) ) {
            $menu_list[''] = sprintf( '&mdash; %s &mdash;', esc_html__( 'Choose a Menu', 'elan' ) );
            foreach ( $nav_menus as $nav ) {
                $menu_list[ $nav->slug ] = esc_html( $nav->name );
            }
        } else {
            $menu_list = array( '' => esc_html__( 'No Menu set yet', 'elan' ) );
        }
        return $menu_list;
    }
}

/*----------------------------------------------------------------------
# Returns array of content layouts for page or page.
-------------------------------------------------------------------------*/
if ( ! function_exists( 'elan_content_layouts' ) ) :

    function elan_content_layouts( $output = array() ) {

        $output['left-sidebar']     = esc_html__( 'Left Sidebar', 'elan' );
        $output['full-width']       = esc_html__( 'Full Width', 'elan' );
        $output['right-sidebar']    = esc_html__( 'Right Sidebar', 'elan' );
        return $output;
    }

endif;

/*----------------------------------------------------------------------
# Display the archive title based on the queried object.
-------------------------------------------------------------------------*/
if ( !function_exists( 'elan_archive_get_title' ) ) {
	function elan_archive_get_title( $before = '', $after = '' ) {
		if ( is_category() ) {
			$title = sprintf( '<label>%1$s</label> %2$s',
				esc_html__( 'Category','elan' ),
				single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$title = sprintf( '<label>%1$s</label> %2$s',
				esc_html__( 'Tag','elan' ),
				single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$title = sprintf( '<label>%1$s</label> %2$s',
				esc_html__( 'Author','elan' ),
				get_the_author() );
		} elseif ( is_year() ) {
			$title = sprintf( '<label>%1$s</label> %2$s',
				esc_html__( 'Year','elan' ),
				get_the_date( _x( 'Y', 'yearly archives date format', 'elan' ) ) );
		} elseif ( is_month() ) {
			$title = sprintf( '<label>%1$s</label> %2$s',
				esc_html__( 'Month','elan' ),
				get_the_date( _x( 'F Y', 'monthly archives date format', 'elan' ) ) );
		} elseif ( is_day() ) {
			$title = sprintf( '<label>%1$s</label> %2$s',
				esc_html__( 'Day','elan' ),
				get_the_date( _x( 'F j, Y', 'daily archives date format', 'elan' ) ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = _x( 'Asides', 'post format archive title', 'elan' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = _x( 'Galleries', 'post format archive title', 'elan' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = _x( 'Images', 'post format archive title', 'elan' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = _x( 'Videos', 'post format archive title', 'elan' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = _x( 'Quotes', 'post format archive title', 'elan' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = _x( 'Links', 'post format archive title', 'elan' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = _x( 'Statuses', 'post format archive title', 'elan' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = _x( 'Audio', 'post format archive title', 'elan' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = _x( 'Chats', 'post format archive title', 'elan' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = sprintf( '<label>%1$s</label> %2$s',
				esc_html__( 'Archives','elan' ),
				post_type_archive_title( '', false ) );
		} elseif ( is_tax() ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
			$title = sprintf( '<label>%1$s</label> %2$s',
				$tax->labels->singular_name,
				single_term_title( '', false ) );
		} else {
			$title = esc_html__( 'Archives', 'elan' );
		}

		/**
		 * Filter the archive title.
		 *
		 * @param string $title Archive title to be displayed.
		 */
		$title = apply_filters( 'get_the_archive_title', $title );

		if ( ! empty( $title ) ) {
			echo $before . $title . $after;
		}
	}
}
