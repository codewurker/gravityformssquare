<?php
/**
 * Gravity Forms Square Field Custom File.
 *
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2019, Rocketgenius
 */

if ( ! class_exists( 'GFForms' ) ) {
	die();
}

/**
 * The Square field is a credit card field used specifically by the Square Add-On.
 *
 * @since 1.0.0
 *
 * Class GF_Field_Square_CreditCard
 */
class GF_Field_Square_CreditCard extends GF_Field {

	/**
	 * Field Type
	 *
	 * @since 1.0.0
	 * @var $type string Field type.
	 */
	public $type = 'square_creditcard';

	/**
	 * Returns the scripts to be included for this field type in the form editor.
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	public function get_form_editor_inline_script_on_page_render() {

		// Set Default values.
		$card_details_label = json_encode(
			gf_apply_filters(
				array(
					'gform_card_details',
					rgget( 'id' ),
				),
				esc_html__( 'Card Details', 'gravityformsquare' ),
				rgget( 'id' )
			)
		);
		$card_type_label    = json_encode(
			gf_apply_filters(
				array(
					'gform_card_type',
					rgget( 'id' ),
				),
				esc_html__( 'Card Type', 'gravityformsquare' ),
				rgget( 'id' )
			)
		);
		$cardholder_label   = json_encode(
			gf_apply_filters(
				array(
					'gform_card_name',
					rgget( 'id' ),
				),
				esc_html__( 'Cardholder Name', 'gravityformsquare' ),
				rgget( 'id' )
			)
		);

		$js = sprintf(
			"
			function SetDefaultValues_%s( field ) {
			console.log( field );
				window.fieldId = field.id;
				field.label = '%s';
				field.inputs = [
					new Input( field.id + '.1', %s ),
					new Input( field.id + '.2', %s ),
					new Input( field.id + '.3', %s ),
				];
			}",
			$this->type,
			esc_html__( 'Credit Card', 'gravityformssquare' ),
			$card_details_label,
			$card_type_label,
			$cardholder_label
		) . PHP_EOL;

		// Make sure only one Square field is added to the form.
		$js .= "gform.addFilter('gform_form_editor_can_field_be_added', function(result, type) {
			if (type === 'square_creditcard') {
				if (GetFieldsByType(['square_creditcard']).length > 0) {" .
					sprintf( 'alert(%s);', json_encode( esc_html__( 'Only one Square credit card field can be added to the form', 'gravityformssquare' ) ) )
				. ' result = false;
				}
			}
			
			return result;
		});';

		return $js;
	}

	/**
	 * Get field settings in the form editor.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_form_editor_field_settings() {
		return array(
			'conditional_logic_field_setting',
			'error_message_setting',
			'label_setting',
			'label_placement_setting',
			'admin_label_setting',
			'rules_setting',
			'description_setting',
			'css_class_setting',
			'sub_labels_setting',
			'sub_label_placement_setting',
			'input_placeholders_setting',
		);
	}

	/**
	 * Get form editor button.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_form_editor_button() {
		return array(
			'group' => 'pricing_fields',
			'text'  => $this->get_form_editor_field_title(),
		);
	}

	/**
	 * Get field button title.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_form_editor_field_title() {
		return esc_attr__( 'Square', 'gravityformssquare' );
	}

	/**
	 * Returns the field's form editor description.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_form_editor_field_description() {
		return esc_attr__( 'Allows accepting credit card information to make payments via Square payment gateway.' );
	}

	/**
	 * Returns the field's form editor icon.
	 *
	 * This could be an icon url or a dashicons class.
	 *
	 * @since 1.3
	 *
	 * @return string
	 */
	public function get_form_editor_field_icon() {
		return gf_square()->get_base_url() . '/images/menu-icon.svg';
	}

	/**
	 * Get entry inputs.
	 *
	 * @since 1.0.0
	 *
	 * @return array|null
	 */
	public function get_entry_inputs() {
		$inputs = array();
		if ( ! is_array( $this->inputs ) ) {
			return array();
		}
		foreach ( $this->inputs as $input ) {
			if ( in_array( $input['id'], array( $this->id . '.1', $this->id . '.2', $this->id . '.3' ), true ) ) {
				$inputs[] = $input;
			}
		}

		return $inputs;
	}

	/**
	 * Get the value in entry details.
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $value The field value.
	 * @param string       $currency The entry currency code.
	 * @param bool|false   $use_text When processing choice based fields should the choice text be returned instead of
	 *       the value.
	 * @param string       $format The format requested for the location the merge is being used. Possible values: html, text
	 *           or url.
	 * @param string       $media The location where the value will be displayed. Possible values: screen or email.
	 *
	 * @return string
	 */
	public function get_value_entry_detail( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {

		if ( is_array( $value ) ) {
			$card_number     = trim( rgget( $this->id . '.1', $value ) );
			$card_type       = trim( rgget( $this->id . '.2', $value ) );
			$cardholder_name = trim( rgget( $this->id . '.3', $value ) );
			$separator       = $format === 'html' ? '<br/>' : "\n";

			$value = empty( $card_number ) ? '' : $card_type . $separator . $card_number . $separator . $cardholder_name;

			return $value;
		} else {
			return '';
		}
	}

	/**
	 * Used to determine the required validation result.
	 *
	 * @since 1.0.0
	 *
	 * @param int $form_id The ID of the form currently being processed.
	 *
	 * @return bool
	 */
	public function is_value_submission_empty( $form_id ) {
		// check only the cardholder name.
		$cardholder_name_input = GFFormsModel::get_input( $this, $this->id . '.3' );
		$hide_cardholder_name  = rgar( $cardholder_name_input, 'isHidden' );
		$cardholder_name       = sanitize_text_field( rgpost( 'input_' . $this->id . '_3' ) );

		if ( ! $hide_cardholder_name && empty( $cardholder_name ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Get submission value.
	 *
	 * @since 1.0.0
	 *
	 * @param array $field_values Field values.
	 * @param bool  $get_from_post_global_var True if get from global $_POST.
	 *
	 * @return array|string
	 */
	public function get_value_submission( $field_values, $get_from_post_global_var = true ) {

		if ( $get_from_post_global_var ) {
			$value[ $this->id . '.1' ] = $this->get_input_value_submission( 'input_' . $this->id . '_1', rgar( $this->inputs[0], 'name' ), $field_values, true );
			$value[ $this->id . '.2' ] = $this->get_input_value_submission( 'input_' . $this->id . '_2', rgar( $this->inputs[1], 'name' ), $field_values, true );
			$value[ $this->id . '.3' ] = $this->get_input_value_submission( 'input_' . $this->id . '_3', rgar( $this->inputs[2], 'name' ), $field_values, true );
		} else {
			$value = $this->get_input_value_submission( 'input_' . $this->id, $this->inputName, $field_values, $get_from_post_global_var );
		}

		return $value;
	}


	/**
	 * Get field input.
	 *
	 * @since 1.0.0
	 *
	 * @param array      $form The Form Object currently being processed.
	 * @param array      $value The field value. From default/dynamic population, $_POST, or a resumed incomplete submission.
	 * @param null|array $entry Null or the Entry Object currently being edited.
	 *
	 * @return string
	 */
	public function get_field_input( $form, $value = array(), $entry = null ) {
		// Decide where are we.
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();
		$is_admin        = $is_entry_detail || $is_form_editor;

		$form_id  = $form['id'];
		$id       = intval( $this->id );
		$field_id = $is_entry_detail || $is_form_editor || $form_id === 0 ? "input_$id" : 'input_' . $form_id . "_$id";

		$disabled_text = $is_form_editor ? "disabled='disabled'" : '';
		$class_suffix  = $is_entry_detail ? '_admin' : '';

		$form_type_class           = 'single-element';
		$form_sub_label_placement  = rgar( $form, 'subLabelPlacement' );
		$field_sub_label_placement = $this->subLabelPlacement;
		$is_sub_label_above        = $field_sub_label_placement === 'above' || ( empty( $field_sub_label_placement ) && $form_sub_label_placement === 'above' );
		$sub_label_class_attribute = $field_sub_label_placement === 'hidden_label' ? "class='hidden_sub_label screen-reader-text'" : " class='gform-field-label gform-field-label--type-sub'";

		$card_details_input     = GFFormsModel::get_input( $this, $this->id . '.1' );
		$card_details_sub_label = rgar( $card_details_input, 'customLabel' ) !== '' ? $card_details_input['customLabel'] : esc_html__( 'Card Details', 'gravityformssquare' );
		$card_details_sub_label = gf_apply_filters(
			array(
				'gform_card_details',
				$form_id,
				$this->id,
			),
			$card_details_sub_label,
			$form_id
		);

		$cardholder_name_input     = GFFormsModel::get_input( $this, $this->id . '.3' );
		$cardholder_name_sub_label = rgar( $cardholder_name_input, 'customLabel' ) !== '' ? $cardholder_name_input['customLabel'] : esc_html__( 'Cardholder Name', 'gravityformssquare' );


		$cardholder_name_sub_label  = gf_apply_filters(
			array(
				'gform_card_name',
				$form_id,
				$this->id,
			),
			$cardholder_name_sub_label,
			$form_id
		);
		$cardholder_name_placeholder = $this->get_input_placeholder_value( $cardholder_name_input );
 		$cardholder_name_placeholder_attribute = $cardholder_name_placeholder ? 'placeholder="' . $cardholder_name_placeholder . '"' : 'placeholder="' . esc_attr__( 'Cardholder Name', 'gravityformssquare') . '"';
		$labels = $this->get_multi_elements_custom_labels();

		if ( $is_admin ) {
			// If we are in the form editor, display a placeholder field.
			$cc_input = '<div class="ginput_complex ' . esc_attr( $class_suffix ) . esc_attr( $form_type_class ) . ' ginput_container ginput_container_creditcard ginput_container_square_creditcard">';

			$holder_name_label = sprintf(
				'<label for="%1$s_3" id="%1$s_3_label" %2$s>%3$s</label>',
				esc_attr( $field_id ),
				$sub_label_class_attribute,
				$cardholder_name_sub_label
			);

			$holder_name_input = sprintf(
				'<div class="sq-input-container holder-container">%s<input type="text" class="ginput_full " name="input_%s.3" id="%s_3" value="" %s %s>%s</div>',
				$is_sub_label_above ? $holder_name_label : '',
				esc_attr( $id ),
				esc_attr( $field_id ),
				$disabled_text,
				$cardholder_name_placeholder_attribute,
				$is_sub_label_above ? '' : $holder_name_label
			);

			$details_label = sprintf(
				'<label for="%1$s_1" id="%1$s_1_label" %2$s>%3$s</label>',
				esc_attr( $field_id ),
				$sub_label_class_attribute,
				$card_details_sub_label
			);

			$details_input = sprintf(
				'<div class="cc-group">				
					<input id="%s_1" %s type="text" placeholder="%s" class="cc-cardnumber">
				</div>',
				esc_attr( $field_id ),
				$disabled_text,
				esc_attr__( 'Card Number', 'gravityformssquare' )
			);


			// Decide where to show labels ( above or below input ).
			$cc_input .= $holder_name_input . $details_input;

			$cc_input .= '</div>';
			return $cc_input;
		} else {
			// Make sure Square is connected before showing the field.
			$square_connected = gf_square()->square_api_ready();
			// Make sure there is a feed configured.
			$has_feed = gf_square()->has_feed( $form_id );

			// Display an error if square is not connected.
			if ( ! $square_connected ) {
				$card_error = sprintf(
					'<div class="gfield_description validation_message gfield_validation_message">%s</div>',
					esc_html__( 'Please check your Square settings.', 'gravityformssquare' )
				);
				return $card_error;
			} elseif ( ! $has_feed ) {
				$card_error = sprintf(
					'<div class="gfield_description validation_message gfield_validation_message">%s</div>',
					esc_html__( 'Please create a Square feed.', 'gravityformssquare' )
				);
				return $card_error;
			} elseif ( ! GFCommon::is_ssl() ) {
				$card_error = sprintf(
					'<div class="gfield_description gfield_validation_message gfield_creditcard_warning_message">%s</div>',
					esc_html__( 'Please enable SSL to use Square.', 'gravityformssquare' )
				);
				return $card_error;
			}

			// Generate field markup.
			$cardholder_name = '';
			if ( ! empty( $value ) ) {
				$cardholder_name = esc_attr( rgget( $this->id . '.3', $value ) );
			}

			$square_input = sprintf(
				"<div id='%s_1' class='square-single-form'></div>",
				esc_attr( $field_id )
			);

			$square_input_label = sprintf(
				"<label for='%1\$s_1' id='%1\$s_1_label' %2\$s>%3\$s</label>",
				esc_attr( $field_id ),
				$sub_label_class_attribute,
				$card_details_sub_label
			);

			$holder_label = sprintf(
				"<label for='%1\$s_3' id='%1\$s_3_label' %2\$s>%3\$s</label>",
				esc_attr( $field_id ),
				$sub_label_class_attribute,
				$cardholder_name_sub_label
			);

			$holder_input = sprintf(
				"<div class='sq-input-container sq-cardholder-container'>%s<input class='sq-input' type='text' name='input_%s.3' id='%s_3' value='%s' %s>%s</div>",
				$is_sub_label_above ? $holder_label : '',
				esc_attr( $id ),
				esc_attr( $field_id ),
				esc_attr( $cardholder_name ),
				$cardholder_name_placeholder_attribute,
				$is_sub_label_above ? '' : $holder_label
			);

			if ( $is_sub_label_above ) {
				$details_field = $square_input_label . $square_input;
			} else {
				$details_field = $square_input . $square_input_label;
			}

			$cc_input = sprintf(
				"<div class='ginput_complex%1\$s ginput_container ginput_container_square_card gform-grid-row %5\$s'  id='%2\$s' >
					<div class='ginput_full gform-grid-col' id='%2\$s_1_container'>
						%3\$s
					</div>
					<div class='ginput_full gform-grid-col' id='%2\$s_3_container'>
						%4\$s
					</div>
				</div>",
				esc_attr( $class_suffix ),
				esc_attr( $field_id ),
				$holder_input,
				$details_field,
				esc_attr( $form_type_class )
			);

			return $cc_input;

		}
	}

	/**
	 * Returns the field markup; including field label, description, validation, and the form editor admin buttons.
	 *
	 * The {FIELD} placeholder will be replaced in GFFormDisplay::get_field_content with the markup returned by
	 * GF_Field::get_field_input().
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $value The field value. From default/dynamic population, $_POST, or a resumed incomplete
	 *     submission.
	 * @param bool         $force_frontend_label Should the frontend label be displayed in the admin even if an admin label is
	 *             configured.
	 * @param array        $form The Form Object currently being processed.
	 *
	 * @return string
	 */
	public function get_field_content( $value, $force_frontend_label, $form ) {
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();
		$is_admin        = $is_entry_detail || $is_form_editor;

		$field_content = parent::get_field_content( $value, $force_frontend_label, $form );

		return $field_content;
	}

	/**
	 * Returns the HTML tag for the field container.
	 *
	 * @since 1.1
	 *
	 * @param array $form The current Form object.
	 *
	 * @return string
	 */
	public function get_field_container_tag( $form ) {
		return GFCommon::is_legacy_markup_enabled( $form ) ? 'div' : 'fieldset';
	}

	/**
	 * Get field label class.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_field_label_class() {
		return 'gfield_label gfield_label_before_complex gform-field-label';
	}

	/**
	 * Outputs the markup of the form type field setting.
	 *
	 * @since 1.3
	 * @depecated 1.4 Multi element is no longer supported by square.
	 *
	 * @param $position
	 *
	 * @return void
	 */
	public static function payment_form_type_settings( $position ) {

		if ( $position === 0 ) {
			?>
			<li class="square_payment_form_type field_setting">
			<span class="section_label">
				<?php esc_html_e( 'Field Style', 'gravityformssquare' ); ?>
			</span>
				<ul>
					<li>
						<input type="radio" name="square_payment_form_type" class="square-form-type" id="square_payment_form_single_type" value="single"/>
						<label for="square_payment_form_single_type"
							   class="inline"><?php esc_html_e( 'Simplified', 'gravityformssquare' ); ?></label>
					</li>
					<li>
						<input type="radio" name="square_payment_form_type" class="square-form-type" id="square_payment_form_multi_type" value="multi"/>
						<label for="square_payment_form_multi_type"
							   class="inline"><?php esc_html_e( 'Traditional', 'gravityformssquare' ); ?></label>
					</li>
				</ul>
			</li>
		<?php
		}
	}

	/**
	 * Checks if the selected square payment form type is single element or not.
	 *
	 * @since 1.3
	 * @depecated 1.7
	 *
	 * @return bool
	 */
	private function is_single_element() {
		return true;
	}

	/**
	 * Gets placeholder values for multi-element form inputs
	 *
	 * @since 1.3
	 * @depecated 1.4 Multi element is no longer supported by square.
	 *
	 * @return array List of multi element inputs placeholders
	 */
	public function get_multi_elements_placeholders() {

		list( $number_input, $expiration_input, $cvv_input, $postalcode_input ) = $this->get_multi_elements_inputs();

			$number_placeholder     = $this->get_input_placeholder_value( $number_input );
			$expiration_placeholder = $this->get_input_placeholder_value( $expiration_input );
			$cvv_placeholder        = $this->get_input_placeholder_value( $cvv_input );
			$postalcode_placeholder = $this->get_input_placeholder_value( $postalcode_input );

			return array(
				'number'     => $number_placeholder ? $number_placeholder : __( 'Card Number', 'gravityformssquare' ),
				'expiration' => $expiration_placeholder ? $expiration_placeholder : __( 'MM/YY', 'gravityformssquare' ),
				'cvv'        => $cvv_placeholder ? $cvv_placeholder : __( 'CVV', 'gravityformssquare' ),
				'postalcode' => $postalcode_placeholder ? $postalcode_placeholder : __( 'Postal Code', 'gravityformssquare' ),
			);
	}

	/**
	 * Gets multi element sub label values.
	 *
	 * @since 1.3
	 * @depecated 1.4 Multi element is no longer supported by square.
	 *
	 * @return array List of sub label values.
	 */
	public function get_multi_elements_custom_labels() {

		list( $number_input, $expiration_input, $cvv_input, $postalcode_input ) = $this->get_multi_elements_inputs();

		return array(
			'number'     => ! rgempty( 'customLabel', $number_input ) ? $number_input['customLabel'] : esc_html__( 'Card Number', 'gravityformssquare' ),
			'expiration' => ! rgempty( 'customLabel', $expiration_input ) ? $expiration_input['customLabel'] : esc_html__( 'Expires', 'gravityformssquare' ),
			'cvv'        => ! rgempty( 'customLabel', $cvv_input ) ? $cvv_input['customLabel'] : esc_html__( 'CVV / CVC', 'gravityformssquare' ),
			'postalcode' => ! rgempty( 'customLabel', $postalcode_input ) ? $postalcode_input['customLabel'] : esc_html__( 'Postal Code', 'gravityformssquare' ),
		);
	}

	/**
	 * Gets multi element inputs.
	 *
	 * @since 1.3
	 * @depecated 1.4 Multi element is no longer supported by square.
	 *
	 * @return array List of multi element inputs.
	 */
	private function get_multi_elements_inputs() {
		$number_input     = GFFormsModel::get_input( $this, $this->id . '.4' );
		$expiration_input = GFFormsModel::get_input( $this, $this->id . '.5' );
		$cvv_input        = GFFormsModel::get_input( $this, $this->id . '.6' );
		$postalcode_input = GFFormsModel::get_input( $this, $this->id . '.7' );

		return array( $number_input, $expiration_input, $cvv_input, $postalcode_input );
	}

}

GF_Fields::register( new GF_Field_Square_CreditCard() );
