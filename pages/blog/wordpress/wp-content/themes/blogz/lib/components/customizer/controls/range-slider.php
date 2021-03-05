<?php
/**
* The range slider Customizer control.
*/

/**
 * Create a range slider control.
 * This control allows you to add responsive settings.
 */
class Blogz_Range_Slider_Control extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'gt-range-slider';

	public $description = '';

	public $sub_description = '';
	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$devices = array( 'desktop','tablet','mobile' );
		foreach ( $devices as $device ) {
			$this->json['choices'][ $device ]['min']  = ( isset( $this->choices[ $device ]['min'] ) ) ? $this->choices[ $device ]['min'] : '0';
			$this->json['choices'][ $device ]['max']  = ( isset( $this->choices[ $device ]['max'] ) ) ? $this->choices[ $device ]['max'] : '100';
			$this->json['choices'][ $device ]['step'] = ( isset( $this->choices[ $device ]['step'] ) ) ? $this->choices[ $device ]['step'] : '1';
			$this->json['choices'][ $device ]['edit'] = ( isset( $this->choices[ $device ]['edit'] ) ) ? $this->choices[ $device ]['edit'] : false;
			$this->json['choices'][ $device ]['unit'] = ( isset( $this->choices[ $device ]['unit'] ) ) ? $this->choices[ $device ]['unit'] : false;
		}

		foreach ( $this->settings as $setting_key => $setting_id ) {
			$this->json[ $setting_key ] = array(
				'link'  => $this->get_link( $setting_key ),
				'value' => $this->value( $setting_key ),
				'default' => isset( $setting_id->default ) ? $setting_id->default : '',
			);
		}

		$this->json[ 'desktop_label' ] = __( 'Desktop','blogz' );
		$this->json[ 'tablet_label' ]  = __( 'Tablet','blogz' );
		$this->json[ 'mobile_label' ]  = __( 'Mobile','blogz' );
		$this->json[ 'reset_label' ]   = __( 'Reset','blogz' );

		$this->json['description'] = $this->description;
		$this->json['sub_description'] = $this->sub_description;
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'gt-range-slider', GT_LIB_URL . '/lib/components/customizer/controls/js/range-slider.js', array( 'customize-base', 'jquery-ui-slider' ), '1.0', true );
		wp_enqueue_style( 'gt-range-slider-css', GT_LIB_URL . '/lib/components/customizer/controls/css/range-slider.css', array(), '1.0' );
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access public
	 */
	public function content_template() {
		?>
		<div class="gt-range-slider-control">
			<div class="gt-range-title-area">
				<# if ( data.label || data.description ) { #>
					<div class="gt-range-title-info">
						<# if ( data.label ) { #>
							<span class="customize-control-title">{{{ data.label }}}</span>
						<# } #>

						<# if ( data.description ) { #>
							<p class="description">{{{ data.description }}}</p>
						<# } #>
					</div>
				<# } #>

				<div class="gt-range-slider-controls">
					<span class="gt-device-controls">
						<# if ( 'undefined' !== typeof ( data.desktop ) ) { #>
							<span class="gt-device-desktop dashicons dashicons-desktop" data-option="desktop" title="{{ data.desktop_label }}"></span>
						<# } #>

						<# if ( 'undefined' !== typeof (data.tablet) ) { #>
							<span class="gt-device-tablet dashicons dashicons-tablet" data-option="tablet" title="{{ data.tablet_label }}"></span>
						<# } #>

						<# if ( 'undefined' !== typeof (data.mobile) ) { #>
							<span class="gt-device-mobile dashicons dashicons-smartphone" data-option="mobile" title="{{ data.mobile_label }}"></span>
						<# } #>
					</span>

					<span title="{{ data.reset_label }}" class="gt-reset dashicons dashicons-image-rotate"></span>
				</div>
			</div>

			<div class="gt-range-slider-areas">
				<# if ( 'undefined' !== typeof ( data.desktop ) ) { #>
					<label class="range-option-area" data-option="desktop" style="display: none;">
						<div class="wrapper <# if ( '' !== data.choices['desktop']['unit'] ) { #>has-unit<# } #>">
							<div class="gt_range_value <# if ( '' == data.choices['desktop']['unit'] && ! data.choices['desktop']['edit'] ) { #>hide-value<# } #>">
								<input <# if ( data.choices['desktop']['edit'] ) { #>style="display:inline-block;"<# } else { #>style="display:none;"<# } #> type="number" step="{{ data.choices['desktop']['step'] }}" class="desktop-range value" value="{{ data.desktop.value }}" min="{{ data.choices['desktop']['min'] }}" max="{{ data.choices['desktop']['max'] }}" {{{ data.desktop.link }}} data-reset_value="{{ data.desktop.default }}" />
								<span <# if ( ! data.choices['desktop']['edit'] ) { #>style="display:inline-block;"<# } else { #>style="display:none;"<# } #> class="value">{{ data.desktop.value }}</span>

								<# if ( data.choices['desktop']['unit'] ) { #>
									<span class="unit">{{ data.choices['desktop']['unit'] }}</span>
								<# } #>
							</div>
							<div class="gt-slider" data-step="{{ data.choices['desktop']['step'] }}" data-min="{{ data.choices['desktop']['min'] }}" data-max="{{ data.choices['desktop']['max'] }}"></div>
						</div>
					</label>
				<# } #>

				<# if ( 'undefined' !== typeof ( data.tablet ) ) { #>
					<label class="range-option-area" data-option="tablet" style="display:none">
						<div class="wrapper <# if ( '' !== data.choices['tablet']['unit'] ) { #>has-unit<# } #>">
							<div class="gt_range_value <# if ( '' == data.choices['tablet']['unit'] && ! data.choices['desktop']['edit'] ) { #>hide-value<# } #>">
								<input <# if ( data.choices['tablet']['edit'] ) { #>style="display:inline-block;"<# } else { #>style="display:none;"<# } #> type="number" step="{{ data.choices['tablet']['step'] }}" class="tablet-range value" value="{{ data.tablet.value }}" min="{{ data.choices['tablet']['min'] }}" max="{{ data.choices['tablet']['max'] }}" {{{ data.tablet.link }}} data-reset_value="{{ data.tablet.default }}" />
								<span <# if ( ! data.choices['tablet']['edit'] ) { #>style="display:inline-block;"<# } else { #>style="display:none;"<# } #> class="value">{{ data.tablet.value }}</span>

								<# if ( data.choices['tablet']['unit'] ) { #>
									<span class="unit">{{ data.choices['tablet']['unit'] }}</span>
								<# } #>
							</div>
							<div class="gt-slider" data-step="{{ data.choices['tablet']['step'] }}" data-min="{{ data.choices['tablet']['min'] }}" data-max="{{ data.choices['tablet']['max'] }}"></div>
						</div>
					</label>
				<# } #>

				<# if ( 'undefined' !== typeof ( data.mobile ) ) { #>
					<label class="range-option-area" data-option="mobile" style="display:none;">
						<div class="wrapper <# if ( '' !== data.choices['mobile']['unit'] ) { #>has-unit<# } #>">
							<div class="gt_range_value <# if ( '' == data.choices['mobile']['unit'] && ! data.choices['desktop']['edit'] ) { #>hide-value<# } #>">
								<input <# if ( data.choices['mobile']['edit'] ) { #>style="display:inline-block;"<# } else { #>style="display:none;"<# } #> type="number" step="{{ data.choices['mobile']['step'] }}" class="mobile-range value" value="{{ data.mobile.value }}" min="{{ data.choices['mobile']['min'] }}" max="{{ data.choices['mobile']['max'] }}" {{{ data.mobile.link }}} data-reset_value="{{ data.mobile.default }}" />
								<span <# if ( ! data.choices['mobile']['edit'] ) { #>style="display:inline-block;"<# } else { #>style="display:none;"<# } #> class="value">{{ data.mobile.value }}</span>

								<# if ( data.choices['mobile']['unit'] ) { #>
									<span class="unit">{{ data.choices['mobile']['unit'] }}</span>
								<# } #>
							</div>
							<div class="gt-slider" data-step="{{ data.choices['mobile']['step'] }}" data-min="{{ data.choices['mobile']['min'] }}" data-max="{{ data.choices['mobile']['max'] }}"></div>
						</div>
					</label>
				<# } #>
			</div>

			<# if ( data.sub_description ) { #>
				<p class="description sub-description">{{{ data.sub_description }}}</p>
			<# } #>
		</div>
		<?php
	}
}
