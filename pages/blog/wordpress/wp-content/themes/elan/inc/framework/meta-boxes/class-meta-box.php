<?php
/**
 * Elan function for rendering meta-boxes in single post/page area
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
# Start Class Elan_Post_Global_Meta_Box
-------------------------------------------------------------------------*/
if ( ! class_exists( 'Elan_Post_Global_Meta_Box' ) ) {
    class Elan_Post_Global_Meta_Box {

        private $post_types;

        /**
         * Construct Functions
         */
        public function __construct() {

            // Post types to add the meta-box to
            $this->post_types = array( 'post', 'page' );

            // Loop through post types and add meta-box to corresponding post types
            if ( $this->post_types ) {
                foreach( $this->post_types as $key => $val ) {
                    add_action( 'add_meta_boxes_'. $val, array( $this, 'post_meta' ), 11 );
                }
            }

            // Save meta Box
            add_action( 'save_post', array( $this, 'save_meta_data' ) );

            // Load scripts for the metabox
            add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );

        }

        /**
         * Loads the required media files for the media manager and scripts for media widgets.
         */
        public function load_scripts( $hook ) {

            // Only needed on these admin screens
            if ( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) {
                return;
            }

            // Get global post
            global $post;

            // Return if post is not object
            if ( ! is_object( $post ) ) {
                return;
            }

            $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

            // Enqueue Style
            wp_enqueue_style( 'elan-metabox-style', ELAN_THEME_URI .'/assets/back-end/css/metabox-style' . $min . '.css', false, ELAN_THEME_VERSION, 'all' );

            // Enqueue metabox js
            wp_enqueue_script( 'elan-metabox-script', ELAN_THEME_URI . '/assets/back-end/js/metabox-script' . $min . '.js', array( 'jquery' ), ELAN_THEME_VERSION, true );

        }

        /**
         * Add Meta-Box
         */
        public function post_meta( $post ) {

            // Add meta-box
            $obj = get_post_type_object( $post->post_type );
            add_meta_box(
                'post_meta_fields',
                $obj->labels->singular_name . ' '. esc_html__( 'Settings', 'elan' ),
                array( $this, 'display_meta_box' ),
                $post->post_type,
                'normal',
                'high'
            );
        }

        /**
         * Display Meta-Box Fields
         */
        public function display_meta_box( $post ) {

            // Add nonce for security and authentication.
            wp_nonce_field( basename( __FILE__ ), 'elan_meta_nonce' );

            // Get current post data
            $post_id   = $post->ID;
            $post_type = get_post_type();

            // Get tabs
            $tabs = $this->meta_array( $post );

            // Empty notice
            $empty_notice = '<p>'. esc_html__( 'No meta settings available for this post type or user.', 'elan' ) .'</p>';

            // Make sure tabs aren't empty
            if ( empty( $tabs ) ) {
                echo $empty_notice; return;
            }

            // Store tabs that should display on this specific page in an array for use later
            $active_tabs = array();
            foreach ( $tabs as $tab ) {
                $tab_post_type = isset( $tab['post_type'] ) ? $tab['post_type'] : '';
                if ( ! $tab_post_type ) {
                    $display_tab = true;
                } elseif ( in_array( $post_type, $tab_post_type ) ) {
                    $display_tab = true;
                } else {
                    $display_tab = false;
                }
                if ( $display_tab ) {
                    $active_tabs[] = $tab;
                }
            }

            // No active tabs
            if ( empty( $active_tabs ) ) {
                echo $empty_notice; return;
            } ?>

            <div class="metabox-container">
                <div class="metabox-settings-tabs">
                    <ul class="metabox-tab-nav">

                        <?php
                        // Output tab
                        $tab_count = '';
                        foreach ( $active_tabs as $tab ) {
                            $tab_count++;
                            // Define tab title
                            $tab_title = $tab['title'] ? $tab['title'] : esc_html__( 'Other', 'elan' ); ?>
                            <li class="tab-link" data-tab="setting-tab-<?php echo esc_js( $tab_count ); ?>"><?php echo esc_html( $tab_title ); ?></li>
                        <?php } ?>

                    </ul>

                    <div class="meta-box-wrap">
                        <?php
                        // Output tab sections
                        $section_count = '';

                        foreach ( $active_tabs as $tab ) {

                            $section_count++; ?>

                            <div id="setting-tab-<?php echo esc_attr( $section_count ); ?>" class="setting-tab">
                                <?php // Redirect Link Tab
                                // Loop through sections and store meta output
                                foreach ( $tab['settings'] as $setting ) {
                                    // Vars
                                    $meta_id        = $setting['id'];
                                    $title          = isset( $setting['title'] ) ? $setting['title'] : '';
                                    $description    = isset( $setting['description'] ) ? $setting['description'] : '';
                                    $type           = isset( $setting['type'] ) ? $setting['type'] : 'text';
                                    $default        = isset( $setting['default'] ) ? $setting['default'] : '';
                                    $meta_value     = get_post_meta( $post_id, $meta_id, true );
                                    $meta_value     = $meta_value ? $meta_value : $default; ?>

                                    <?php if( 'radio' == $type ) : $options = isset ( $setting['options'] ) ? $setting['options'] : ''; ?>

                                        <section>
                                            <div class="input-holder">
                                                <?php if( $title ) : ?>
                                                    <div class="input-label">
                                                        <label for="<?php echo esc_attr( $meta_id ); ?>"><?php echo esc_html( $title ); ?></label>
                                                        <?php if ( $description ) : ?>
                                                            <p class="description"><?php echo wp_kses_post( $description ); ?></p>
                                                        <?php endif; ?>
                                                    </div><!-- .input-field -->
                                                <?php endif; ?>

                                                <div class="input-field">
                                                    <div id="specific-page-layout">
                                                        <fieldset>
                                                            <?php foreach ( $options as $option_value => $option_name ) : ?>
                                                                <input type="radio" name="<?php echo esc_attr( $meta_id ); ?>" id="has-<?php echo esc_attr( $option_value ); ?>" value="<?php echo esc_attr( $option_value ); ?>" <?php echo checked( $meta_value, $option_value, false ); ?>>
                                                                <label for="has-<?php echo esc_attr( $option_value ); ?>" class="has-<?php echo esc_attr( $option_value ); ?>"><?php echo esc_html( $option_name ); ?></label>
                                                            <?php endforeach; ?>
                                                        </fieldset>
                                                    </div>
                                                </div><!-- .input-field -->
                                            </div><!-- .input-holder -->
                                        </section>

                                    <?php endif;

                                } ?>

                            </div>

                        <?php } ?>

                    </div>
                </div>

            </div>

        <?php }

        /**
         * Save Meta-Box Values
         */
        public function save_meta_data( $post_id ) {

            // Verify that the nonce is valid.
            if ( ! isset( $_POST['elan_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['elan_meta_nonce'] ), basename( __FILE__ ) ) ) {
                return;
            }

            // If this is an autosave, our form has not been submitted, so we don't want to do anything.
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }

            // Check the user's permissions.
            if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

                if ( ! current_user_can( 'edit_page', $post_id ) ) {
                    return;
                }

            } else {

                if ( ! current_user_can( 'edit_post', $post_id ) ) {
                    return;
                }
            }

            /* OK, it's safe for us to save the data now. Now we can loop through fields */

            // Check reset field
            $reset = isset( $_POST['metabox-value-reset'] ) ? sanitize_text_field( $_POST['metabox-value-reset'] ) : '';

            // Get array of settings to save
            $tabs = $this->meta_array();
            $settings = array();
            foreach( $tabs as $tab ) {
                foreach ( $tab['settings'] as $setting ) {
                    $settings[] = $setting;
                }
            }

            // Loop through settings and validate
            foreach ( $settings as $setting ) {

                // Vars
                $value = '';
                $id    = $setting['id'];
                $type  = isset ( $setting['type'] ) ? $setting['type'] : 'text';

                // Make sure field exists and if so validate the data
                if ( isset( $_POST[$id] ) ) {


                    // Validate radio
                    if ( 'radio' == $type ) {
                        if ( 'default-sidebar' != $_POST[$id] ) {
                            $value = sanitize_text_field( $_POST[$id] );
                        }
                    }

                    // All else
                    else {
                        $value = sanitize_text_field( $_POST[$id] );
                    }

                    // Update meta if value exists
                    if ( $value ) {
                        update_post_meta( $post_id, $id, $value );
                    }

                    // Otherwise cleanup stuff
                    else {
                        delete_post_meta( $post_id, $id );
                    }
                }

            }

        }

        /**
         * Settings Array
         */
        private function meta_array( $post = null ) {

            // Get global post
            global $post;

            $obj = get_post_type_object( $post->post_type );

            if ( $obj->name == 'post' ) {
                $post_img_type_link 	= admin_url( 'customize.php?autofocus[section]=elan_post_thumb_settings_section' );
            }
            else {
                $post_img_type_link 	= admin_url( 'customize.php?autofocus[section]=elan_page_thumb_settings_section' );
            }

            // Prefix
            $prefix = 'elan_';

            // Define array
            $array = array();

            // Default variable
            $default = esc_html__( 'Default', 'elan' );

            // Sidebar Layout Tab
            $array['sidebar']  = array(
                'title'     => esc_html__( 'Sidebar Layout', 'elan' ),
                'settings'  => array(
                    'sidebar_layout'    =>array(
                        'title'         => esc_html__( 'Sidebar Layout', 'elan' ),
                        'description'   => esc_html__( 'Default value is inherit from single post or page settings.', 'elan' ),
                        'id'            => $prefix . 'sidebar_layout',
                        'type'          => 'radio',
                        'options'       => elan_content_layouts( array( 'default-sidebar' => $default )),
                        'default'       => 'default-sidebar',
                    ),
                ),
            );

            // Featured Image Type
            $array['featured_img_type']  = array(
                'title'             => esc_html__( 'Featured Image Type', 'elan' ),
                'settings'          => array(
                    'subtitle'      => array(
                        'title'         => esc_html__( 'Image Type', 'elan' ),
                        'description'   => sprintf( __( 'Select unique featured image type you want to display on Single %1$s listing. To change default value go to %2$s which applies to all Single %1$s listing.', 'elan' ),
                            $obj->labels->singular_name,
                            '<a href="'.$post_img_type_link.'" target="_blank">Thumbnail Settings</a>'

                        ),
                        'id'            => $prefix . 'featured_img_type',
                        'type'          => 'radio',
                        'default'       => 'default-img',
                        'options'       => array(
                            'default-img' 		=> esc_html__( 'Default', 'elan' ),
                            'portrait-img'      => esc_html__( 'Portrait Image', 'elan' ),
                            'square-img'        => esc_html__( 'Square Image', 'elan' ),
                            'landscape-img'     => esc_html__( 'Landscape Image', 'elan' ),
                            'full-width-img'    => esc_html__( 'Full Width', 'elan' ),
                        ),
                    ),
                ),
            );
            // Apply filter & return settings array
            return apply_filters( 'elan_metabox_array', $array, $post );
        }
    }

    // Class needed only in the admin
    if ( is_admin() ) {

        new Elan_Post_Global_Meta_Box;
    }
}
