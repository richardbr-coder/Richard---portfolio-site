<?php
/**
 * Elan functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Elan
 */

/**
 * Elan only works in WordPress 4.7 or later and PHP 5.4.0 or later.
 */
if ( ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) || ( version_compare( PHP_VERSION, '5.4.0', '<' ) ) ){
    require get_template_directory() . '/inc/libraries/back-compat.php';
    return;
}

/**
 * Define constants
 */
$elan_theme_options  = wp_get_theme();
$elan_theme_name     = $elan_theme_options->get( 'Name' );
$elan_theme_author   = $elan_theme_options->get( 'Author' );
$elan_theme_desc     = $elan_theme_options->get( 'Description' );
$elan_theme_version  = $elan_theme_options->get( 'Version' );

define( 'ELAN_THEME_NAME', $elan_theme_name );
define( 'ELAN_THEME_AUTHOR', $elan_theme_author );
define( 'ELAN_THEME_DESC', $elan_theme_desc );
define( 'ELAN_THEME_VERSION', $elan_theme_version );
define( 'ELAN_THEME_URI', get_template_directory_uri() );
define( 'ELAN_THEME_DIR', get_template_directory() );

/*--------------------------------------------------------------
# Sets up and registers support
--------------------------------------------------------------*/
if ( ! function_exists( 'elan_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function elan_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Elan, use a find and replace
         * to change 'elan' to the name of your theme in all the template files.
         */
        load_theme_textdomain( 'elan', ELAN_THEME_DIR . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

	    /* Portrait Thumbnail */
        add_image_size( 'elan-768-portrait', 768, 1024, true );

        /* Square Thumbnail */
        add_image_size( 'elan-768-square', 768, 768, true );

        /* Landscape Thumbnail */
        add_image_size( 'elan-768-landscape', 768, 432, true );
        add_image_size( 'elan-1600-900', 1600, 900, true );

	    /* Wider Thumbnail ) */
        add_image_size( 'elan-1280-548', 1280, 548, true );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary-menu' => esc_html__( 'Primary', 'elan' ),
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support( 'custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ) );
    }
endif;
add_action( 'after_setup_theme', 'elan_setup' );

/*--------------------------------------------------------------
# Set content width
--------------------------------------------------------------*/
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function elan_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters( 'elan_content_width', 640 );
}
add_action( 'after_setup_theme', 'elan_content_width', 0 );

/*--------------------------------------------------------------
# function for google fonts
--------------------------------------------------------------*/
if ( ! function_exists('elan_google_fonts_url') ) :

    /**
     * Return fonts URL.
     *
     * @return string Fonts URL.
     */
    function elan_google_fonts_url(){

        $fonts_url = '';
        $fonts     = array();
        $subsets   = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Barlow Semi Condensed, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'elan' ) ) {
            $fonts[] = 'Roboto:400,500,700';
        }

        /* translators: If there are characters in your language that are not supported by Barlow, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== _x( 'on', 'Libre Baskerville font: on or off', 'elan' ) ) {
            $fonts[] = 'Libre Baskerville:400,700';
        }

        /* translators: If there are characters in your language that are not supported by Barlow, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== _x( 'on', 'Work Sans font: on or off', 'elan' ) ) {
            $fonts[] = 'Work Sans:400,500,700';
        }

        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                'family' => rawurlencode( implode( '|', $fonts ) ),
                'subset' => rawurlencode( $subsets ),
            ), 'https://fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }
endif;

/*--------------------------------------------------------------
# Front-End Enqueue scripts and styles.
--------------------------------------------------------------*/
function elan_scripts() {

    $fonts_url = elan_google_fonts_url();

    if (!empty($fonts_url)) {
        wp_enqueue_style('elan-google-fonts', $fonts_url, array(), null);
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

	$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Enqueue Style
    wp_enqueue_style('bootstrap', ELAN_THEME_URI . '/assets/front-end/css/bootstrap'. $min .'.css', false, '4.1.3', 'all');
    wp_enqueue_style('aos', ELAN_THEME_URI . '/assets/front-end/css/aos'. $min .'.css', false, '', 'all');
    wp_enqueue_style('magnific-popup', ELAN_THEME_URI . '/assets/front-end/css/magnific-popup'. $min .'.css', false, '1.1.0', 'all');
    wp_enqueue_style('elan-custom-fonts-style', ELAN_THEME_URI . '/assets/front-end/css/custom-fonts'. $min .'.css', false, ELAN_THEME_VERSION, 'all');
    wp_enqueue_style('elan-style', get_stylesheet_uri());

    // Enqueue Script
    wp_enqueue_script( 'aos', ELAN_THEME_URI . '/assets/front-end/js/aos'. $min .'.js', array( 'jquery' ), ELAN_THEME_VERSION, true );
    wp_enqueue_script('jquery.magnific-popup', ELAN_THEME_URI . '/assets/front-end/js/jquery.magnific-popup'. $min .'.js', array('jquery'), '1.1.0', true);
    wp_enqueue_script('ResizeSensor', ELAN_THEME_URI . '/assets/front-end/js/ResizeSensor'. $min .'.js', array('jquery'), ELAN_THEME_VERSION, true);
    wp_enqueue_script('elan-custom-script', ELAN_THEME_URI . '/assets/front-end/js/custom'. $min .'.js', array('jquery'), ELAN_THEME_VERSION, true);
}
add_action( 'wp_enqueue_scripts', 'elan_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function elan_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
        /(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'elan_skip_link_focus_fix' );

/**
 * Load template functions.
 */
require ELAN_THEME_DIR . '/inc/helpers/template-functions.php';

/**
 * Load themes custom hooks.
 */
require ELAN_THEME_DIR . '/inc/helpers/theme-hooks.php';

/**
 * Load kirki library in theme
 */
require ELAN_THEME_DIR . '/inc/libraries/kirki/kirki.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
    require ELAN_THEME_DIR . '/inc/libraries/jetpack.php';
}

/**
 * Customizer options.
 */
require ELAN_THEME_DIR . '/inc/framework/customizer/customizer.php';

/**
 * Load theme meta box
 */
require ELAN_THEME_DIR . '/inc/framework/meta-boxes/class-meta-box.php';

/**
 * Include theme widgets ultimate bundles.
 */
require ELAN_THEME_DIR . '/inc/framework/widgets/widgets.php';
