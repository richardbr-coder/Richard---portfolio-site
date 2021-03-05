<?php
/**
 * Upsell customizer section.
 *
 * @since  1.0.8
 * @access public
 */
// Exit if it get loaded before WP_class Customize_Section class
if ( ! class_exists( 'WP_Customize_Section' ) ) {
    return;
}
 class Elan_Anchor_Customize_Section extends WP_Customize_Section {
        /**
        * The control type.
        *
        * @access public
        * @var string
        */
        public $type = 'anchor';
        public $url  = '';
        public $id = '';
        /**
         * JSON.
         */
        public function json() {
            $json        = parent::json();
            $json['url'] = $this->url;
            $json['id']  = $this->id;
            return $json;
        }

        public function render(){}
        /**
         * Render template
         *
         * @access protected
         */
        public function render_template() {
            ?>
            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
                <h3>
                    <a href="{{{ data.url }}}" target="_blank" style="display: block; justify-content: space-between; align-items: center; padding: 10px 10px 10px 20px; background: #008ec2; text-align: center; text-decoration: none; color: #fff; ">{{ data.title }} <span class="dashicons dashicons-arrow-right-alt"></span> </a>
                </h3>    
            </li>
            <?php
        }
    }