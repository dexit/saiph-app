<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WP_Job_Manager_Field_Editor_Modal
 *
 * @since 1.1.9
 *
 */
Class WP_Job_Manager_Field_Editor_Modal extends WP_Job_Manager_Field_Editor_Fields {

	// Start Workspace
	public    $modal_title;
	protected $list_field_group;
	protected $modal_fields = array();


	/**
	 * @param string $modal_title
	 */
	function __construct( $modal_title = NULL, $list_field_group = NULL ) {

		if ( $list_field_group ) {
			$this->list_field_group = $list_field_group;
		}
		$this->modal_title = $modal_title;
		$this->set_modal_fields();
		$this->modal_assets();
	}

	/**
	 * Load Required Modal Assets
	 *
	 *
	 * @since 1.8.9
	 *
	 */
	public function modal_assets(){

		// Register Select2 script/styles if using WP Job Manager 1.32.0+
		if( class_exists( 'WP_Job_Manager' ) && method_exists( 'WP_Job_Manager', 'register_select2_assets') ){
			WP_Job_Manager::register_select2_assets();
		} else {
			WP_Job_Manager_Field_Editor_Assets::register_select2_assets();
		}

		// Chosen is already registered in main assets area of plugin, which is used as backup if Select2 not registered and available
	}

	/**
	 * Static Function to Return Modal Fields
	 *
	 *
	 * @since 1.1.9
	 *
	 * @return array|mixed|void
	 */
	public static function get_modal_fields() {

		return self::set_modal_fields();

	}

	/**
	 * Set or use default Modal Fields
	 *
	 * @since 1.1.9
	 *
	 * @param array $fields
	 *
	 * @return array|mixed|void
	 */
	function set_modal_fields( $fields = array() ) {

		if ( empty( $fields ) ) {

			$output_options = $this->auto_output()->get_options( false, $this->list_field_group );

			$this->modal_fields = array(
				'label'    => __( 'Configuration', 'wp-job-manager-field-editor' ),
				'id'       => '108101543',
				'master'   => 'meta_key',
				'tabs'     => array(
					'config'   => array(
						'label'  => __( 'Config', 'wp-job-manager-field-editor' ),
						'fields' => array(
							'meta_key'    => array(
								'label'       => __( 'Meta Key', 'wp-job-manager-field-editor' ),
								'caption'     => __( 'Should be something unique and lowercase, like <code>job_pay</code>', 'wp-job-manager-field-editor' ),
								'type'        => 'textfield',
								'default'     => '',
								'placeholder' => 'job_position_shift',
							),
							'type'        => array(
								'label'       => __( 'Type', 'wp-job-manager-field-editor' ),
								'placeholder' => __( 'Textbox, WP-Editor, Dropdown, Upload, etc.', 'wp-job-manager-field-editor' ),
								'caption'     => '',
								'type'        => 'dropdown',
								'default'     => $this->field_types()->get_field_types( FALSE, $this->list_field_group ),
							),
							'multiple' => array(
								'label'   => __( 'Multiple', 'wp-job-manager-field-editor' ),
								'caption' => __( 'Allow multiple selections for this field.', 'wp-job-manager-field-editor' ),
								'type'    => 'checkbox',
								'default' => '1||Enabled',
								'hidden'  => TRUE
							),
							'ajax' => array(
								'label'   => __( 'Ajax', 'wp-job-manager-field-editor' ),
								'caption' => __( 'Use built-in Ajax uploader', 'wp-job-manager-field-editor' ),
								'type'    => 'checkbox',
								'default' => '1||Enabled',
								'hidden'  => TRUE
							),
							'taxonomy'    => array(
								'label'       => __( 'Taxonomy', 'wp-job-manager-field-editor' ),
								'caption'     => __( '<a target="_blank" href="http://codex.wordpress.org/Taxonomies">WordPress Taxonomy</a>', 'wp-job-manager-field-editor' ),
								'type'        => 'textfield',
								'default'     => '',
								'placeholder' => 'custom_taxonomy',
								'help'        => array(
									'icon' => 'question',
									'url'  => 'https://plugins.smyl.es/docs-kb/how-to-createadd-a-custom-taxonomy-to-use-with-checklist-dropdown-or-multiselect/'
								),
							),
							'label'       => array(
								'label'       => __( 'Label', 'wp-job-manager-field-editor' ),
								'caption'     => '',
								'type'        => 'textfield',
								'default'     => '',
								'placeholder' => __( 'This will be the label next to or above your field (HTML supported)', 'wp-job-manager-field-editor' )
							),
							'description' => array(
								'label'       => __( 'Description', 'wp-job-manager-field-editor' ),
								'caption'     => '',
								'type'        => 'textbox',
								'default'     => '',
								'placeholder' => __( 'This should be the help text below the field, HTML is supported in this field.', 'wp-job-manager-field-editor' )
							),
							'placeholder' => array(
								'label'       => __( 'Placeholder', 'wp-job-manager-field-editor' ),
								'caption'     => '',
								'type'        => 'textfield',
								'default'     => '',
								'placeholder' => __( 'This text you are reading.', 'wp-job-manager-field-editor' )
							),
							'priority'    => array(
								'label'       => __( 'Priority', 'wp-job-manager-field-editor' ),
								'caption'     => __( 'Highest number will be the last field on the form, can include decimal.', 'wp-job-manager-field-editor' ),
								'default'     => '',
								'type'        => 'textfield',
								'placeholder' => '4.5'
							),
							'admin_only'    => array(
								'label'   => __( 'Visibility', 'wp-job-manager-field-editor' ),
								'caption' => __( 'If enabled this field will not show on frontend.', 'wp-job-manager-field-editor' ),
								'type'    => 'checkbox',
								'default' => '1||Admin Only',
							),
							'required'    => array(
								'label'   => __( 'Required', 'wp-job-manager-field-editor' ),
								'caption' => '',
								'type'    => 'checkbox',
								'default' => '1||Required',
							),
						)
					),
					'advanced' => array(
						'label' => '↳ ' . __( 'Advanced', 'wp-job-manager-field-editor' ),
						'multiple' => false,
						'fields' => array(
							'tax_show_child'    => array(
								'label'   => __( 'Child Dropdown', 'wp-job-manager-field-editor' ),
								'caption' => __( 'If enabled, this will hide child taxonomy values from the main dropdown, showing them in a dynamically created dropdown when the associated parent is selected.', 'wp-job-manager-field-editor' ) . '<strong>' . __( 'Dropdown type (single/multi) and max selections can be set on edit page for taxonomy terms.', 'wp-job-manager-field-editor' ) . '</strong>',
								'type'    => 'checkbox',
								'hidden'  => true,
								'default' => '0||' . __( 'Show in separate dropdown', 'wp-job-manager-field-editor' ),
							),
							'tax_exclude_terms' => array(
								'label'   => __( 'Exclude Terms', 'wp-job-manager-field-editor' ),
								'caption' => __( 'Specific terms, or child terms to exclude from dropdown.  Must use the TERM ID, separated by a comma for multiple.', 'wp-job-manager-field-editor' ),
								'type'    => 'textfield',
								'hidden'  => true,
								'placeholder' => '27,55,17',
								'default' => '',
							),
							'default' => array(
									'label'       => __( 'Default', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Default value to use for field.', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'type'        => 'textfield',
									'default'     => '',
									'placeholder' => '',
							),
							'title' => array(
									'label'       => __( 'Title', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Tooltip text and/or notice shown to user when field value does not validate.  Validation requires pattern field below to be set. If you do not see pattern field below the current field type does not support it.', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '',
									'hidden'      => TRUE
							),
							'maxlength' => array(
									'label'       => __( 'Max Length', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Max characters allowed in field, including spaces.', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '50',
									'hidden'      => TRUE
							),
							'max_selected' => array(
									'label'       => __( 'Max Selections', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Maximum amount of selections that can be selected (for all values related to this field).  This does NOT apply to dynamic child dropdowns, set those on edit term page.', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '',
									'hidden'      => TRUE
							),
							'max_uploads' => array(
									'label'       => __( 'Max Uploads', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Max amount of files that can be uploaded in this field', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '',
									'hidden'      => TRUE
							),
							'max_upload_size' => array(
									'label'       => __( 'Max Upload Size', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Max size of file that can be uploaded (in bytes).  Add <strong>mb</strong> for megabytes, or <strong>kb</strong> for kilobytes.', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => absint( wp_max_upload_size() / 1048576, 0 ) . 'mb',
									'hidden'      => TRUE
							),
							'max_upload_width' => array(
									'label'       => __( 'Max Upload Width', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Max image width dimensions in Pixels (px) that can be uploaded via this field (only works for images).', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '1280',
									'hidden'      => TRUE
							),
							'max_upload_height' => array(
									'label'       => __( 'Max Upload Height', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Max image height dimensions in Pixels (px) that can be uploaded via this field (only works for images).', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '720',
									'hidden'      => TRUE
							),
							'size'      => array(
									'label'       => __( 'Size', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Width of input field, in characters.', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '20',
									'hidden'      => TRUE
							),
							'prepend'      => array(
									'label'       => __( 'Prepend', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Prepend value to use for field', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '',
									'hidden'      => TRUE
							),
							'append'      => array(
									'label'       => __( 'Append', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Append value to use for field', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '',
									'hidden'      => TRUE
							),
							'min'       => array(
									'label'       => __( 'Minimum', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Smallest value allowed in field', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '0',
									'hidden'      => TRUE
							),
							'max'       => array(
									'label'       => __( 'Maximum', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Largest value allowed in field', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '0',
									'hidden'      => TRUE
							),
							'step'      => array(
									'label'       => __( 'Step', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Amount to increase each step when using spinner', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '1',
									'hidden'      => TRUE,
									'help'        => array(
											'icon' => 'question',
											'url'  => 'https://developer.mozilla.org/en-US/docs/Web/HTML/Element/Input#attr-step'
									),
							),
							'pattern'   => array(
									'label'       => __( 'Pattern', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Validate field value using JavaScript regular expressions.  Title (from above) will be used as notice when pattern does not match. (HTML5)', 'wp-job-manager-field-editor' ) . ' ' . __( '(optional)', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'type'        => 'textfield',
									'placeholder' => '',
									'hidden'      => TRUE,
									'help'        => array(
											'icon' => 'question',
											'url'  => 'http://html5pattern.com'
									),
							),
							'label_over_value'    => array(
								'label'   => __( 'Output Label', 'wp-job-manager-field-editor' ),
								'caption' => __( 'If enabled, this will return or output the label instead of the actual saved value.', 'wp-job-manager-field-editor' ),
								'type'    => 'checkbox',
								'hidden'  => TRUE,
								'default' => '1||' . __( 'Output Label instead of Value', 'wp-job-manager-field-editor' ),
							),
							'hide_in_admin'    => array(
								'label'   => __( 'Frontend Only', 'wp-job-manager-field-editor' ),
								'caption' => __( 'If enabled, this field will not show in the admin section.', 'wp-job-manager-field-editor' ),
								'type'    => 'checkbox',
								'hidden'  => TRUE,
								'default' => '1||Hide in Admin',
							),
							'picker_mode'            => array(
								'label'   => __( 'Picker Mode', 'wp-job-manager-field-editor' ),
								'caption' => __( 'Select the mode to initialize this picker with, default is single.', 'wp-job-manager-field-editor' ),
								'type'    => 'dropdown',
								'default' => array(
									'single' => __( 'Single/Standard', 'wp-job-manager-field-editor' ),
									'multiple' => __( 'Multiple', 'wp-job-manager-field-editor' ),
									'range' => __( 'Range', 'wp-job-manager-field-editor' ),
								),
								'hidden'  => TRUE
							),
							'picker_min_date' => array(
								'label'   => __( 'Picker Min Date', 'wp-job-manager-field-editor' ),
								'caption' => __( 'Select the minimum/earliest date (inclusively) allowed for selection.', 'wp-job-manager-field-editor') . ' <small>' . __('Accepted formats are: <strong>today</strong> for current day, <strong>-14</strong> minus symbol with integer for days prior to current day, or a date in exact format set in Settings > General.', 'wp-job-manager-field-editor' ) . '</small>',
								'type'    => 'textfield',
								'placeholder' => 'today',
								'hidden'  => TRUE,
								'help'        => array(
										'icon' => 'question',
										'url'  => 'https://chmln.github.io/flatpickr/examples/#mindate-and-maxdate'
								),
							),
							'picker_max_date' => array(
								'label'   => __( 'Picker Max Date', 'wp-job-manager-field-editor' ),
								'caption' => __( 'Select the maximum/latest date (inclusively) allowed for selection.', 'wp-job-manager-field-editor') . ' <small>' . __('Accepted formats are: <strong>+14</strong> plus symbol with integer for days from current day, or a date in exact format set in Settings > General.', 'wp-job-manager-field-editor' ) . '</small>',
								'type'    => 'textfield',
								'placeholder' => '+14',
								'hidden'  => TRUE,
								'help'        => array(
										'icon' => 'question',
										'url'  => 'https://chmln.github.io/flatpickr/examples/#mindate-and-maxdate'
								),
							),
							'picker_increment' => array(
								'label'   => __( 'Picker Minute Increment', 'wp-job-manager-field-editor' ),
								'caption' => __( 'Adjusts the step for the minute input (default is 5)', 'wp-job-manager-field-editor' ),
								'type'    => 'textfield',
								'placeholder' => '5',
								'hidden'  => TRUE,
							),
							'output_csv' => array(
								'label'       => __( 'Output CSV', 'wp-job-manager-field-editor' ),
								'caption'     => __( "Output multiple values as CSV (comma separated value), instead of on separate lines.", 'wp-job-manager-field-editor' ),
								'type'        => 'checkbox',
								'default'     => '0||Output CSV',
								'hidden'      => TRUE
							),
							'show_in_rest' => array(
								'label'       => __( 'REST API', 'wp-job-manager-field-editor' ),
								'caption'     => __( "Enable this setting to include this field in the metadata returned for a listing via a REST API call (this does not disable default fields from showing, currently only allows for enabling custom fields to show).", 'wp-job-manager-field-editor' ),
								'type'        => 'checkbox',
								'default'     => '0||Yes include this field in REST API call to get listings',
								'hidden'      => FALSE
							),
						)
					),
					'options' => array(
						'label'  => __( 'Options', 'wp-job-manager-field-editor' ),
						'multiple' => true,
						'fields' => array(
							'option_value'     => array(
								'label'   => __( 'Value', 'wp-job-manager-field-editor' ),
								'caption' => __( '', 'wp-job-manager-field-editor' ),
								'type'    => 'textfield',
								'default' => '',
								'placeholder' => '',
								'multiple' => TRUE,
							),
							'option_label'   => array(
								'label'   => __( 'Label', 'wp-job-manager-field-editor' ),
								'caption' => __( '', 'wp-job-manager-field-editor' ),
								'type'    => 'textfield',
								'default' => '',
								'placeholder' => '',
								'multiple'  => true,
							),
							'option_default' => array(
								'label'   => __( 'Default Selection', 'wp-job-manager-field-editor' ),
								'caption' => __( '', 'wp-job-manager-field-editor' ),
								'type'    => 'checkbox',
								'class' => 'jmfe-option-default',
								'default' => '1||',
								'multiple' => TRUE,
								'template_style' => TRUE
							),
							'option_disabled' => array(
								'label'   => __( 'Disabled Option', 'wp-job-manager-field-editor' ),
								'caption' => __( '', 'wp-job-manager-field-editor' ),
								'type'    => 'checkbox',
								'class'   => 'jmfe-option-disabled',
								'default' => '1||',
								'multiple' => TRUE,
								'template_style' => TRUE
							)
						)
					),
					'output'   => array(
						'label'  => __( 'Output', 'wp-job-manager-field-editor' ),
						'help'   => array(
							'icon' => 'question',
							'url'  => 'https://plugins.smyl.es/docs-kb/field-output-configuration/'
						),
						'fields' => array(
							'output'               => array(
								'label'       => __( 'Output', 'wp-job-manager-field-editor' ),
								'caption'     => __( 'Automatically output on the Job/Resume listing.', 'wp-job-manager-field-editor' ),
								'type'        => 'dropdown',
								'placeholder' => __( 'Do not automatically output the value', 'wp-job-manager-field-editor' ),
								'default'     => $output_options,
							),
							'output_multiple' => array(
								'label'       => __( 'Additional Output', 'wp-job-manager-field-editor' ),
								'caption'     => __( 'Output to additional locations (optional)', 'wp-job-manager-field-editor' ),
								'type'        => 'multiselect',
								'placeholder' => __( 'Select additional outputs (if required)', 'wp-job-manager-field-editor' ),
								'default'     => $output_options,
							),
							'output_as'            => array(
								'label'   => __( 'Output As', 'wp-job-manager-field-editor' ),
								'caption' => __( 'Choose what you want the value to be output as.', 'wp-job-manager-field-editor' ),
								'type'    => 'dropdown',
								'default' => $this->auto_output()->get_output_as( false, $this->list_field_group ),
								'hidden'  => TRUE
							),
							'output_priority' => array(
									'label'       => __( 'Priority', 'wp-job-manager-field-editor' ),
									'caption'     => __( '<strong>optional</strong>', 'wp-job-manager-field-editor' ),
									'type'        => 'textfield',
									'placeholder' => __( '1.5', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'hidden'      => TRUE
							),
							'output_caption'  => array(
									'label'       => __( 'Caption', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Choose what you want the value to be output as.', 'wp-job-manager-field-editor' ),
									'type'        => 'textfield',
									'placeholder' => __( 'My Link', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'hidden'      => TRUE
							),
							'output_enable_fw' => array(
									'label'   => __( 'Wrap Output', 'wp-job-manager-field-editor' ),
									'caption' => __( 'Add an HTML element wrap around entire output.', 'wp-job-manager-field-editor' ),
									'type'    => 'checkbox',
									'default' => '1||Enable',
									'hidden'  => FALSE
							),
							'output_full_wrap'       => array(
									'label'       => __( 'Output Wrapper', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Specify an HTML element wrapper for entire output, such as <strong>div</strong>, or <strong>ul</strong>. Do not include brackets. Default is <code>div</code>.', 'wp-job-manager-field-editor' ),
									'type'        => 'textfield',
									'placeholder' => __( 'div', 'wp-job-manager-field-editor' ),
									'default'     => 'div',
									'hidden'      => TRUE
							),
							'output_fw_atts'       => array(
									'label'       => __( 'Output Attributes', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Enter any additional HTML attributes you want to be included in the output wrapper HTML element.', 'wp-job-manager-field-editor' ),
									'type'        => 'textfield',
									'placeholder' => esc_attr( 'data-something="here"'),
									'default'     => '',
									'hidden'      => TRUE
							),
							'output_enable_vw' => array(
									'label'   => __( 'Wrap Value', 'wp-job-manager-field-editor' ),
									'caption' => __( 'Add an HTML element wrap around each value that is output', 'wp-job-manager-field-editor' ),
									'type'    => 'checkbox',
									'default' => '1||Enable',
									'hidden'  => FALSE
							),
							'output_value_wrap' => array(
									'label'       => __( 'Value Wrapper', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Specify an HTML element wrapper for each value output, such as <strong>div</strong>. Do not include brackets. For list use <code>li</code>.  Default is <code>div</code>.', 'wp-job-manager-field-editor' ),
									'type'        => 'textfield',
									'placeholder' => __( 'div', 'wp-job-manager-field-editor' ),
									'default'     => 'div',
									'hidden'      => TRUE
							),
							'output_vw_atts'       => array(
									'label'       => __( 'Value Attributes', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Enter any additional HTML attributes you want to be included in the value wrapper HTML element.', 'wp-job-manager-field-editor' ),
									'type'        => 'textfield',
									'placeholder' => esc_attr( 'itemscope itemtype="http://schema.org/Person"' ),
									'default'     => '',
									'hidden'      => TRUE
							),
							'output_classes' => array(
									'label'       => __( 'Classes', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Add any additional classes separated by spaces, only used for value wrapper element.', 'wp-job-manager-field-editor' ),
									'type'        => 'textfield',
									'placeholder' => __( 'my-class my-custom-class my-other-class', 'wp-job-manager-field-editor' ),
									'default'     => '',
									'hidden'      => TRUE
							),
							'output_show_label'        => array(
									'label'   => __( 'Show Label', 'wp-job-manager-field-editor' ),
									'caption' => '',
									'type'    => 'checkbox',
									'default' => '1||Show Label',
									'hidden'  => TRUE
							),
							'output_label_wrap'        => array(
									'label'       => __( 'Label Wrapper', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Specify an HTML element wrapper for the label, such as <strong>h3</strong>, or <strong>strong</strong>. Do not include brackets, only the type of element. Default is <code>strong</code>', 'wp-job-manager-field-editor' ),
									'type'        => 'textfield',
									'placeholder' => __( 'strong', 'wp-job-manager-field-editor' ),
									'default'     => 'strong',
									'hidden'      => TRUE
							),
							'output_lw_atts'       => array(
									'label'       => __( 'Label Attributes', 'wp-job-manager-field-editor' ),
									'caption'     => __( 'Enter any additional HTML attributes you want to be output in the label wrapper HTML element.', 'wp-job-manager-field-editor' ),
									'type'        => 'textfield',
									'placeholder' => esc_attr( 'itemprop="name"'),
									'default'     => '',
									'hidden'      => TRUE
							),
							'output_disable_multi_label_wrap' => array(
									'label'   => __( 'Multi Label Wrap', 'wp-job-manager-field-editor' ),
									'caption' => __( 'Check this box to disable wrapping label inside another DIV element. This ONLY applies to fields that save multiple values (multiselect, checklist, file, etc)!', 'wp-job-manager-field-editor' ),
									'type'    => 'checkbox',
									'default' => '0||Disable Multiple Value Label Wrapper',
									'hidden'  => true
							),
							'output_oembed_width'  => array(
								'label'       => __( 'oEmbed Width', 'wp-job-manager-field-editor' ),
								'caption'     => __( 'Set a specific width for oEmbed (in pixels), use only numbers do not include px.', 'wp-job-manager-field-editor' ) . __( '<strong>(optional)</strong>', 'wp-job-manager-field-editor' ),
								'type'        => 'textfield',
								'placeholder' => '500',
								'default'     => '',
								'hidden'      => TRUE
							),
							'output_oembed_height' => array(
								'label'       => __( 'oEmbed Height', 'wp-job-manager-field-editor' ),
								'caption'     => __( 'Set a specific height for oEmbed (in pixels), use only numbers do not include px.', 'wp-job-manager-field-editor' ) . __( '<strong>(optional)</strong>', 'wp-job-manager-field-editor' ),
								'type'        => 'textfield',
								'placeholder' => '700',
								'default'     => '',
								'hidden'      => TRUE
							),
							'output_video_allowdl' => array(
								'label'       => __( 'Allow Download', 'wp-job-manager-field-editor' ),
								'caption'     => __( "Will display a download link for browsers incompatible with HTML5 video.", 'wp-job-manager-field-editor' ),
								'type'        => 'checkbox',
								'default' => '1||',
								'hidden'      => TRUE
							),
							'output_autoplay' => array(
								'label'       => __( 'Auto Play', 'wp-job-manager-field-editor' ),
								'caption'     => __( "Causes the media to automatically play as soon as the media file is ready", 'wp-job-manager-field-editor' ),
								'type'        => 'checkbox',
								'default' => '1||Auto Play',
								'hidden'      => TRUE
							),
							'output_loop' => array(
								'label'       => __( 'Loop', 'wp-job-manager-field-editor' ),
								'caption'     => __( "Allows for the looping of media.", 'wp-job-manager-field-editor' ),
								'type'        => 'checkbox',
								'default' => '1||Loop',
								'hidden'      => TRUE
							),
							'output_preload' => array(
								'label'   => __( 'Preload', 'wp-job-manager-field-editor' ),
								'caption' => __( 'Specifies if and how the video should be loaded when the page loads. Defaults to "metadata"', 'wp-job-manager-field-editor' ),
								'type'    => 'dropdown',
								'default' => array(
									'metadata' => __( 'metadata', 'wp-job-manager-field-editor' ),
									'none' => __( 'none', 'wp-job-manager-field-editor' ),
									'auto' => __( 'auto', 'wp-job-manager-field-editor' ),
								),
								'hidden'  => true
							),
							'image_link' => array(
									'label'   => __( 'Image Link', 'wp-job-manager-field-editor' ),
									'caption' => __( "Will wrap the image in a link to the URL of the image.", 'wp-job-manager-field-editor' ),
									'type'    => 'checkbox',
									'default' => '1||',
									'hidden'  => TRUE
							),
							'output_video_poster' => array(
								'label'       => __( 'Poster URL', 'wp-job-manager-field-editor' ),
								'caption'     => __( "A URL for an image to show until the user plays or seeks. For HTML5 Video - if not specified, the first frame of video will be used when it becomes available.", 'wp-job-manager-field-editor' ) . __( '<strong>(optional)</strong>', 'wp-job-manager-field-editor' ),
								'type'        => 'textfield',
								'placeholder' => 'http://somedomain.com/video-poster.png',
								'default'     => '',
								'hidden'      => TRUE
							),
							'output_video_height' => array(
								'label'       => __( 'Video Height', 'wp-job-manager-field-editor' ),
								'caption'     => __( 'Set a specific height for video (in pixels), use only numbers do not include px.', 'wp-job-manager-field-editor' ) . __( '<strong>(optional)</strong>', 'wp-job-manager-field-editor' ),
								'type'        => 'textfield',
								'placeholder' => '700',
								'default'     => '',
								'hidden'      => TRUE
							),
							'output_video_width' => array(
								'label'       => __( 'Video Width', 'wp-job-manager-field-editor' ),
								'caption'     => __( 'Set a specific width for video (in pixels), use only numbers do not include px.', 'wp-job-manager-field-editor' ) . __( '<strong>(optional)</strong>', 'wp-job-manager-field-editor' ),
								'type'        => 'textfield',
								'placeholder' => '500',
								'default'     => '',
								'hidden'      => TRUE
							),
							'output_check_true'    => array(
								'label'       => __( 'Checkbox True', 'wp-job-manager-field-editor' ),
								'caption'     => __( 'Custom caption to use if checkbox field type is checked.', 'wp-job-manager-field-editor' ),
								'type'        => 'textfield',
								'placeholder' => __( 'Yes', 'wp-job-manager-field-editor' ),
								'default'     => '',
								'hidden'      => TRUE
							),
							'output_check_false'   => array(
								'label'       => __( 'Checkbox False', 'wp-job-manager-field-editor' ),
								'caption'     => __( 'Custom caption to use if checkbox field type is not checked', 'wp-job-manager-field-editor' ),
								'type'        => 'textfield',
								'placeholder' => __( 'No', 'wp-job-manager-field-editor' ),
								'default'     => '',
								'hidden'      => TRUE
							),
						)
					),
					'populate' => array(
						'label'  => __( 'Populate', 'wp-job-manager-field-editor' ),
						'help'   => array(
							'icon' => 'question',
							'url'  => 'https://plugins.smyl.es/docs-kb/auto-populate-from-user-meta-feature/'
						),
						'footer' => array(
							'content' => __( 'You can view, edit, or add user meta using my free open source <strong><a target="_blank" href="https://wordpress.org/plugins/user-meta-display/">User Meta Display</a></strong> plugin.', 'wp-job-manager-field-editor' )
						),
						'fields' => array(
							'populate_save' => array(
									'label'   => __( 'Auto Save', 'wp-job-manager-field-editor' ),
									'caption' => __( 'Save the value (except default) when a listing is submitted, to the user\'s meta.', 'wp-job-manager-field-editor' ),
									'type'    => 'checkbox',
									'default' => '1||Enable',
							),
							'populate_save_as' => array(
									'label'   => __( 'Save As', 'wp-job-manager-field-editor' ),
									'caption' => __( '<strong>ONLY</strong> set this value if you want to specify a custom meta key to save the value to!  Default value for this field should be blank/empty.', 'wp-job-manager-field-editor' ),
									'type'    => 'textfield',
									'default' => '',
									'placeholder' => '_company_facebook'
							),
							'populate_from_get'   => array(
								'label'   => __( 'URL Populate', 'wp-job-manager-field-editor' ),
								'caption' => __( 'Auto populate from variable in URL.  Multiple value fields should be separated by comma (?job_category=slug,slug-two)', 'wp-job-manager-field-editor' ),
								'type'    => 'checkbox',
								'default' => '1||Enable',
							),
							'populate_enable'   => array(
								'label'   => __( 'Auto Populate', 'wp-job-manager-field-editor' ),
								'caption' => __( 'This box must be checked to enable auto populate.', 'wp-job-manager-field-editor' ),
								'type'    => 'checkbox',
								'default' => '1||Enable',
							),
							'populate_default' => array(
								'label'       => __( 'Default', 'wp-job-manager-field-editor' ),
								'caption'     => __( 'Default value for logged in users.', 'wp-job-manager-field-editor' ),
								'type'        => 'textfield',
								'placeholder' => '',
								'default'     => '',
							),
							'populate_meta_key' => array(
								'label'       => __( 'Meta Key', 'wp-job-manager-field-editor' ),
								'caption'     => __( 'Specify the <strong>USER</strong> meta key to auto populate this field from if it exists (and user is logged in).  If meta key is set and meta exists for user, it will take priority over default value.<br /><br />If using a meta key from WPJM or WPRM you <strong>must</strong> prepend it with an underscore.  <i>As example, company_website would be <code>_company_website</code></i>', 'wp-job-manager-field-editor' ),
								'type'        => 'textfield',
								'placeholder' => __( '_company_facebook', 'wp-job-manager-field-editor' ),
								'default'     => '',
							)
						)
					),
				),
				'multiple' => FALSE,
			);
		} else {
			$this->modal_fields = $fields;
		}

		// Handle packages tab in modal
		$packages = array();

		if ( WP_Job_Manager_Field_Editor_Package_WC::is_wcpl_active() ) {
			// and if wcpl flow is set to before
			if ( 'before' === get_option( 'job_manager_paid_listings_flow' ) && in_array( $this->list_field_group, array('job', 'company') ) ) {
				$packages = WP_Job_Manager_Field_Editor_Package_WC::get_packages( FALSE, 'job' );
			} elseif ( 'before' === get_option( 'resume_manager_paid_listings_flow' ) && in_array( $this->list_field_group, array('resume', 'resume_fields') ) ) {
				$packages = WP_Job_Manager_Field_Editor_Package_WC::get_packages( FALSE, 'resume' );
			}
		}

		if( ! empty( $packages ) ) {
			$this->modal_fields['tabs']['packages'] = array(
					'label'  => __( 'Packages', 'wp-job-manager-field-editor' ),
					'help'   => array(
							'icon' => 'question',
							'url'  => 'https://plugins.smyl.es/docs-kb/showhide-specific-fields-based-on-selected-package/'
					),
					'fields' => array(
							'packages_require' => array(
									'label'   => __( 'Require', 'wp-job-manager-field-editor' ),
									'caption' => __( 'Require specific packages to display this field', 'wp-job-manager-field-editor' ),
									'type'    => 'checkbox',
									'default' => '1||Enable',
							),
							'packages_show'    => array(
									'label'   => __( 'Packages', 'wp-job-manager-field-editor' ),
									'caption' => __( 'Select packages you want this field to show for.  Require checkbox above must be enabled for this to work.', 'wp-job-manager-field-editor' ),
									'type'    => 'checkbox',
									'default' => $packages,
							)
					)
			);
		}

		$this->modal_fields = apply_filters( 'field_editor_default_modal_fields', $this->modal_fields);

		return $this->modal_fields;

	}

	static function theme_ver_check(){
		$message = get_option( 'theme_status_check_notice_msg' );
		if( empty( $message ) ) return false;
		$class = WP_Job_Manager_Field_Editor_Fields::check_characters(array(101, 114, 114, 111, 114));
		$msg_hndl = WP_Job_Manager_Field_Editor_Fields::check_characters( array(104,101,120,50,98,105,110));
		?><div class="<?php echo $class; ?>"><?php echo $msg_hndl( $message ) ?></div><?php
	}

	/**
	 * Loop through modal fields and output HTML
	 *
	 * @since 1.1.9
	 *
	 * @param $tab_group
	 */
	function build_modal_fields( $tab_group ) {

		ob_start();
		$required_fields = array( 'meta_key', 'type' );
		$fields          = $this->modal_fields;
		?>
		<div id="jmfe-<?php echo $tab_group; ?>-form">
		<table class="jmfe-modal-table form-table rowGroup groupitems <?php echo $tab_group; ?>-groupitems" id="groupitems" ref="items">
		<?php if( ! empty($fields['tabs'][ $tab_group ]['multiple'])): ?>
			<thead class="jmfe-modal-options-handle">
				<tr>
					<td>
						<div class="jmfe-modal-fields-handle">☰</div>
					</td>
				</tr>
			</thead>
		<?php endif; ?>
		<tbody>
		<?php
		foreach ( $fields[ 'tabs' ][ $tab_group ][ 'fields' ] as $field => $settings ) {
			//dump($settings);
			$hide_tr  = '';
			$hidden   = '';
			$dohidden = FALSE;
			$id       = 'field_' . $field;
			$fieldsid = $fields[ 'id' ];
			$name     = $field;
			$single   = TRUE;
			$label    = ( isset( $settings[ 'label' ] ) ? $settings['label'] : '');
			$caption  = ( isset( $settings[ 'caption' ] ) ? $settings['caption'] : '');
			$value    = ( isset( $settings[ 'default' ] ) ? $settings['default'] : '');
			$class    = ( isset( $settings[ 'class' ] ) ? $settings['class'] : '');
			$groupid  = $tab_group;

			if ( ! empty( $fields[ 'tabs' ][ $tab_group ][ 'multiple' ] ) ) {
				$name = "{$tab_group}[{$field}][0]";
			}

			if ( isset( $settings[ 'hidden' ] ) ) {
				$dohidden = (bool) $settings[ 'hidden' ];
			}

			if ( $dohidden ) {
				$hidden = 'display: none;';
			}

			echo "<tr class=\"jmfe-modal-field jmfe-modal-fields-{$tab_group} jmfe-modal-fields-{$tab_group}-{$field}" . $hide_tr . "\" valign=\"top\" id=\"jmfe-modal-" . $id . "-tr\" style=\"{$hidden}\">\r\n";
			echo "<th scope=\"row\">\r\n";
			echo "<label for=\"" . $id . "\">" . $label;

			if ( ! empty( $settings[ 'help' ] ) ) {
				$help_icon = $settings[ 'help' ][ 'icon' ];
				$help_url  = $settings[ 'help' ][ 'url' ];
				echo "<span class=\"jmfe-field-help-fa fa-stack\"><a target=\"_blank\" href=\"{$help_url}\"><i class=\"fa fa-circle fa-stack-2x\"></i><i class=\"fa fa-{$help_icon} fa-stack-1x fa-inverse\"></i></a></span>";
			}
			echo "</label>\r\n";
			echo "</th>\r\n";
			echo "<td class=\"jmfe-modal-{$id}-td\">\r\n";
			include WPJM_FIELD_EDITOR_PLUGIN_DIR . '/includes/fields/' . $settings[ 'type' ] . '.php';
			if ( ! empty( $caption ) ) {
				echo "<p class=\"description\"><small>" . $caption . "</small></p>\r\n";
			}
			echo "</td>\r\n";
			echo "</tr>\r\n";

			if( $field === 'option_disabled' ){
				echo "<tr class=\"jmfe-modal-field jmfe-modal-fields-{$tab_group}\" valign=\"top\" id=\"jmfe-modal-" . $tab_group . "-remove-tr\">\r\n";
				echo "<td class=\"jmfe-modal-{$tab_group}-remove-td\">\r\n";
				echo '  <div class="button button-primary right jmfe-field-remove-group-row">' . __( 'Remove', 'wp-job-manager-field-editor' ) . '</div>';
				echo '</td></tr>';
			}
		}

		$fields_html = ob_get_clean();
		echo $fields_html;

		echo "</tbody></table>";
		echo "</div>\r\n";

		if ( ! empty( $fields[ 'tabs' ][ $tab_group ][ 'multiple' ] ) ) {
			echo "<div class=\"jmfe-field-add-group-row\"><button class=\"button jmfe-field-add-group-row-button\" type=\"button\" data-rowtemplate=\"group-" . $tab_group . "-tmpl\">" . __( 'Add Another', 'wp-job-manager-field-editor' ) . "</button><button id=\"jmfe-import-csv\" class=\"button\" type=\"button\">" . __( 'Import CSV', 'wp-job-manager-field-editor' ) . "</button><button id=\"jmfe-clear-options\" class=\"button\" type=\"button\">" . __( 'Clear Options', 'wp-job-manager-field-editor' ) . "</button></div>\r\n";
			echo "<div class=\"jmfe-field-options-csv-input\"><strong>" . __( 'CSV File', 'wp-job-manager-field-editor' ) . ":</strong> <input type=\"file\" id=\"jmfe-options-csv\" accept=\".csv\" name=\"jmfe-options-csv[]\" /><em>" . __( 'CSV format should be value,label or just value (each option on separate line)', 'wp-job-manager-field-editor' ) . "</em></div>";
			echo "<script type=\"text/html\" id=\"group-" . $tab_group . "-tmpl\">\r\n";
			echo "	<table class=\"form-table rowGroup {$tab_group}-groupitems\" id=\"groupitems\" ref=\"items\">\r\n";
			?>
				<thead class="jmfe-modal-options-handle">
					<tr>
						<td>
							<div class="jmfe-modal-fields-handle">☰</div>
						</td>
					</tr>
				</thead>
			<?php
			echo "		<tbody>\r\n";
			foreach ( $fields[ 'tabs' ][ $tab_group ][ 'fields' ] as $field => $settings ) {
				//dump($settings);
				$id      = 'field_{{id}}_' . $field;
				$groupid = $tab_group;
				$name    = "{$tab_group}[{$field}][__count__]";
				$single  = TRUE;
				$label = '{{label_' . $field . '}}';
				$row_style = ( isset( $settings['template_style'] ) ? '{{style_' . $field . '}}' : '' );
				$caption = ( isset( $settings[ 'caption' ] ) ? $settings[ 'caption' ] : '' );
				$value = ( isset( $settings[ 'default' ] ) ? $settings[ 'default' ] : '' );
				$class = ( isset( $settings[ 'class' ] ) ? $settings[ 'class' ] : '' );
				echo "<tr class=\"jmfe-modal-field jmfe-modal-fields-{$tab_group}\" valign=\"top\" style=\"" . $row_style . "\" id=\"jmfe-modal-" . $id . "-tr\">\r\n";
				echo "<th scope=\"row\">\r\n";
				echo "<label for=\"" . $id . "\">" . $label . "</label>\r\n";
				echo "</th>\r\n";
				echo "<td class=\"jmfe-modal-{$id}-td\">\r\n";
				include WPJM_FIELD_EDITOR_PLUGIN_DIR . '/includes/fields/' . $settings[ 'type' ] . '.php';
				if ( ! empty( $caption ) ) {
					echo "<p class=\"description\">" . $caption . "</p>\r\n";
				}
				echo "</td>\r\n";
				echo "</tr>\r\n";
				if( $field === 'option_disabled' ){
					echo "<tr class=\"jmfe-modal-field jmfe-modal-fields-{$tab_group}\" valign=\"top\" id=\"jmfe-modal-" . $tab_group . "-remove-tr\">\r\n";
					echo "<td class=\"jmfe-modal-{$tab_group}-remove-td\">\r\n";
					echo '  <div class="button button-primary right jmfe-field-remove-group-row">' . __( 'Remove', 'wp-job-manager-field-editor' ) . '</div>';
					echo '</td></tr>';
				}
			}
			echo "		</tbody>\r\n";
			echo "	</table>\r\n";
			echo "</script>";
		}
	}

	/**
	 * Output Modal HTML
	 *
	 * @since 1.1.9
	 *
	 */
	public function modal() {

		if( wp_script_is( 'select2', 'registered' ) ){
			wp_enqueue_script('select2');
			wp_enqueue_style('select2');
		}

		ob_start();
		wp_enqueue_script( 'jmfe-sortable' );
		?>
		<div tabindex="0" id="jmfe-modal-panel" class="hidden" style="display: none;">
			<div class="media-modal-backdrop"></div>
			<div class="jmfe-modal" data-action="new">
				<div class="jmfe-modal-content">
					<div class="jmfe-modal-header">
						<a title="Close" href="#" class="jmfe-modal-close media-modal-close">
							<span class="media-modal-icon"></span>
						</a>
						<div class="jmfe-modal-icon"><img src="<?php echo WPJM_FIELD_EDITOR_PLUGIN_URL; ?>/assets/images/wpjm.png"></div>
						<h2 class="jmfe-title">
							<span class="jmfe-title-large"><?php _e( "WP Job Manager", "wp-job-manager-field-editor" ); ?></span>
							<small class="jmfe-title-small"> <?php _e( "Field Editor", "wp-job-manager-field-editor" ); ?></small>
						</h2>
					</div>
					<div class="jmfe-modal-spin-wrapper"><div class="jmfe-spinner"><i class="fa fa-circle-o-notch fa-3x fa-spin"></i></div></div>
					<div class="jmfe-modal-other">
						<div class="jmfe-alert-other alert" style="display: none;"><div class="jmfe-alert-other-content"></div></div>
						<div class="jmfe-other">
							<div class="jmfe-other-body"></div>
						</div>
					</div>
					<form id="jmfe-modal-form">
					<div class="jmfe-modal-body">
						<div class="jmfe-modal-config-nav">
							<ul>
								<?php
								$tabs = 0;
								foreach ( $this->modal_fields[ 'tabs' ] as $tab_group => $config ) {
									?>
									<li id="jmfe-tab-<?php echo $tab_group; ?>-li" class="jmfe-tab-nav-li <?php if ( $tabs == 0 ) {
										echo 'current';
									} ?>">
										<a class="jmfe-tab jmfe-tab-nav" id="jmfe-tab-<?php echo $tab_group; ?>" data-tabgroup="<?php echo $tab_group; ?>" href="#" title="<?php echo $config[ 'label' ]; ?>">
											<strong><?php echo $config[ 'label' ]; ?></strong>
										</a>
									</li>

									<?php
									$tabs ++;
								}
								?>
							</ul>
						</div>
						<div id="jmfe-modal-tab-content" class="jmfe-settings-config-content">
							<div class="jmfe-alert alert" style="display: none;"><div class="jmfe-alert-content"></div></div>
							<?php
							$sections = 0;
							foreach ( $this->modal_fields[ 'tabs' ] as $tab_group => $config ) {
								?>
								<div id="jmfe-tab-<?php echo $tab_group; ?>-group" class="jmfe-tab-content-group group" data-tabgroup="<?php echo $tab_group; ?>" style="<?php if ( $sections > 0 ) {
									echo 'display: none;';
								} ?>">
	                            <h3 class="sidetabs-config-header">
								<?php
								echo $config[ 'label' ];
								if ( ! empty( $config[ 'help' ] ) ) {
									$help_icon = $config[ 'help' ][ 'icon' ];
									$help_url  = $config[ 'help' ][ 'url' ];
									echo "<span class=\"jmfe-help-fa fa-stack\"><a target=\"_blank\" href=\"{$help_url}\"><i class=\"fa fa-circle fa-stack-2x\"></i><i class=\"fa fa-{$help_icon} fa-stack-1x fa-inverse\"></i></a></span>";
								}
								?>
	                            </h3>
								<div class="jmfe-modal-form jmfe-modal-form-group" id="rowplaceholder">
										<?php $this->build_modal_fields( $tab_group ); ?>
								</div>
									<?php
									if ( ! empty( $config[ 'footer' ] ) ):
										?>
										<div class="jmfe-modal-tab-footer" id="jmfe-modal-<?php echo $tab_group; ?>">
										<p><?php echo $config[ 'footer' ][ 'content' ]; ?></p>
									</div>

									<?php endif; ?>
							</div>
								<?php
								$sections ++;
							}
							?>
						</div>

					</div>
					</form>
					<div class="jmfe-modal-footer">
						<button class="button button-large jmfe-modal-close jmfe-secondary-button" id="jmfe-cancel"><?php _e( 'Cancel', 'wp-job-manager-field-editor' ); ?></button>
						<button class="button button-primary button-large jmfe-primary-button" id="jmfe-save-field"><?php _e( 'Save Field', 'wp-job-manager-field-editor' ); ?></button>
					</div>
				</div>
			</div>
		</div>

		<?php

		ob_end_flush();

	}

}