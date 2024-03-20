<?php
/**
 * Settings class.
 *
 * @package ias-wp-customdash
 * @since   1.0.0
 */

declare( strict_types = 1 );

namespace Imarun\CustomDash\Admin;

class Settings {

	/**
	 * Settings constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		/**
		 * Register our wp_cd_general_settings_init to the admin_init action hook.
		 */
		add_action( 'admin_init', array( $this, 'wp_cd_general_settings_init' ) );

		/**
		 * Register our wp_cd_general_options_page to the admin_menu action hook.
		 */
		add_action( 'admin_menu', array( $this, 'wp_cd_general_options_page' ) );

		$plugin = 'custom-dash/custom-dash.php';
		add_filter( "plugin_action_links_$plugin", array( $this, 'wp_cd_settings_link' ) );
	}
	
	/**
	 * custom option and settings
	 */
	public function wp_cd_general_settings_init() {
		// Register a new setting for "wp_cd_general" page.
		register_setting( 'wp_cd_general', 'wp_cd_general_options' );
	
		// Register a new section in the "wp_cd_general" page.
		add_settings_section(
			'wp_cd_general_section_developers',
			__( 'Custom settings', 'wp_cd_general' ), array( $this, 'wp_cd_general_section_developers_callback' ),
			'wp_cd_general'
		);

		// Register a new field in the "wp_cd_general_section_developers" section, inside the "wp_cd_general" page.
		add_settings_field(
			'wp_cd_general_text_or_logo', // As of WP 4.6 this value is used only internally.
			// Use $args' label_for to populate the id inside the callback.
			__( 'Text Or Logo', 'wp_cd_general' ),
			array( $this, 'wp_cd_general_text_or_logo_cb' ),
			'wp_cd_general',
			'wp_cd_general_section_developers',
			array(
				'label_for' => 'wp_cd_general_text_or_logo',
				'class'     => 'wp_cd_general_row regular-text',
			)
		);

		// Register a new field in the "wp_cd_general_section_developers" section, inside the "wp_cd_general" page.
		add_settings_field(
			'wp_cd_general_text_logo', // As of WP 4.6 this value is used only internally.
			// Use $args' label_for to populate the id inside the callback.
			__( 'Text Logo', 'wp_cd_general' ),
			array( $this, 'wp_cd_general_text_logo_cb' ),
			'wp_cd_general',
			'wp_cd_general_section_developers',
			array(
				'label_for' => 'wp_cd_general_text_logo',
				'class'     => 'wp_cd_general_row regular-text',
			)
		);

		// Register a new field in the "wp_cd_general_section_developers" section, inside the "wp_cd_general" page.
		add_settings_field(
			'wp_cd_general_login_logo', // As of WP 4.6 this value is used only internally.
			// Use $args' label_for to populate the id inside the callback.
			__( 'Image Logo', 'wp_cd_general' ),
			array( $this, 'wp_cd_general_login_logo_cb' ),
			'wp_cd_general',
			'wp_cd_general_section_developers',
			array(
				'label_for' => 'wp_cd_general_login_logo',
				'class'     => 'wp_cd_general_row regular-text',
			)
		);

		// Register a new field in the "wp_cd_general_section_developers" section, inside the "wp_cd_general" page.
		add_settings_field(
			'wp_cd_general_logo_height', // As of WP 4.6 this value is used only internally.
			// Use $args' label_for to populate the id inside the callback.
			__( 'Logo Heigth', 'wp_cd_general' ),
			array( $this, 'wp_cd_general_logo_height_cb' ),
			'wp_cd_general',
			'wp_cd_general_section_developers',
			array(
				'label_for' => 'wp_cd_general_logo_height',
				'class'     => 'wp_cd_general_row regular-text',
			)
		);

		// Register a new field in the "wp_cd_general_section_developers" section, inside the "wp_cd_general" page.
		add_settings_field(
			'wp_cd_general_logo_width', // As of WP 4.6 this value is used only internally.
			// Use $args' label_for to populate the id inside the callback.
			__( 'Logo Width', 'wp_cd_general' ),
			array( $this, 'wp_cd_general_logo_width_cb' ),
			'wp_cd_general',
			'wp_cd_general_section_developers',
			array(
				'label_for' => 'wp_cd_general_logo_width',
				'class'     => 'wp_cd_general_row regular-text',
			)
		);

		// Register a new field in the "wp_cd_general_section_developers" section, inside the "wp_cd_general" page.
		add_settings_field(
			'wp_cd_general_login_header_url', // As of WP 4.6 this value is used only internally.
			// Use $args' label_for to populate the id inside the callback.
			__( 'Logo URL', 'wp_cd_general' ),
			array( $this, 'wp_cd_general_login_header_url_cb' ),
			'wp_cd_general',
			'wp_cd_general_section_developers',
			array(
				'label_for' => 'wp_cd_general_login_header_url',
				'class'     => 'wp_cd_general_row regular-text',
			)
		);
	}

	/**
	 * Page heading section callback function.
	 *
	 * @param array $args  The settings array, defining title, id, callback.
	 */
	public function wp_cd_general_section_developers_callback( $args ) {
		?>
		<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Login sreen logo settings', 'wp_cd_general' ); ?></p>
		<?php
	}

	/**
	 * Text or logo callback function.
	 *
	 * @param array $args
	 */
	public function wp_cd_general_text_or_logo_cb( $args ) {
		// Get the value of the setting we've registered with register_setting()
		$options = get_option( 'wp_cd_general_options' );
		$options[ $args['label_for'] ] = $options[ $args['label_for'] ] ?? "";
		?>
		<label><input type="radio" class="<?php echo esc_attr( $args['class'] ); ?>" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="wp_cd_general_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="text" <?php checked( 'text', $options[ $args['label_for'] ] ); ?> />Text</label><br />
		<label><input type="radio" class="<?php echo esc_attr( $args['class'] ); ?>" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="wp_cd_general_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="logo" <?php checked( 'logo', $options[ $args['label_for'] ] ); ?> />Image</label><br />  
		<p class="description" id="tagline-description">Selete type of logo to display on login screen</p>
		<?php
	}

	/**
	 * Text logo callback function.
	 *
	 * @param array $args
	 */
	public function wp_cd_general_text_logo_cb( $args ) {
		// Get the value of the setting we've registered with register_setting()
		$options = get_option( 'wp_cd_general_options' );
		$options[ $args['label_for'] ] = $options[ $args['label_for'] ] ?? "";
		?>
		<input type='text' class="<?php echo esc_attr( $args['class'] ); ?>" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="wp_cd_general_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $options[ $args['label_for'] ] ) ?>">
		<p class="description" id="tagline-description">Enter your text for logo</p>
		<?php
	}

	/**
	 * Login logo callback function.
	 *
	 * @param array $args
	 */
	public function wp_cd_general_login_logo_cb( $args ) {
		// Get the value of the setting we've registered with register_setting()
		$options = get_option( 'wp_cd_general_options' );
		$options[ $args['label_for'] ] = $options[ $args['label_for'] ] ?? "";
		?>
		<input type='text' class="<?php echo esc_attr( $args['class'] ); ?>" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="wp_cd_general_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $options[ $args['label_for'] ] ) ?>">
		<input type="button" name="cd-upload-btn" id="cd_upload_btn" class="button-secondary" value="Upload Logo">
		<p class="description" id="tagline-description">Upload a logo image</p>
		<?php
	}

	/**
	 * Logo height callback function.
	 *
	 * @param array $args
	 */
	public function wp_cd_general_logo_height_cb( $args ) {
		// Get the value of the setting we've registered with register_setting()
		$options = get_option( 'wp_cd_general_options' );
		$options[ $args['label_for'] ] = $options[ $args['label_for'] ] ?? "";
		?>
		<input type='text' class="<?php echo esc_attr( $args['class'] ); ?>" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="wp_cd_general_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $options[ $args['label_for'] ] ) ?>">
		<p class="description" id="tagline-description">Enter logo height (px)</p>
		<?php
	}

	/**
	 * Logo width callback function.
	 *
	 * @param array $args
	 */
	public function wp_cd_general_logo_width_cb( $args ) {
		// Get the value of the setting we've registered with register_setting()
		$options = get_option( 'wp_cd_general_options' );
		$options[ $args['label_for'] ] = $options[ $args['label_for'] ] ?? "";
		?>
		<input type='text' class="<?php echo esc_attr( $args['class'] ); ?>" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="wp_cd_general_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $options[ $args['label_for'] ] ) ?>">
		<p class="description" id="tagline-description">Enter logo width (px)</p>
		<?php
	}

	/**
	 * Login header url callback function.
	 *
	 * @param array $args
	 */
	public function wp_cd_general_login_header_url_cb( $args ) {
		// Get the value of the setting we've registered with register_setting()
		$options = get_option( 'wp_cd_general_options' );
		$options[ $args['label_for'] ] = $options[ $args['label_for'] ] ?? "";
		?>
		<input type='text' class="<?php echo esc_attr( $args['class'] ); ?>" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="wp_cd_general_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $options[ $args['label_for'] ] ) ?>">
		<p class="description" id="tagline-description">Enter logo URL</p>
		<?php
	}

	/**
	 * Add the top level menu page.
	 */
	public function wp_cd_general_options_page() {
		add_submenu_page(
			'options-general.php',
			'Custom Dash Settings',
			'Custom Dash',
			'manage_options',
			'wp_cd_general',
			array( $this, 'wp_cd_general_options_page_html' )
		);
	}

	/**
	 * Top level menu callback function
	 */
	public function wp_cd_general_options_page_html() {
		// check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
	
		// show error/update messages
		settings_errors( 'wp_cd_general_messages' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				// output security fields for the registered setting "wp_cd_general"
				settings_fields( 'wp_cd_general' );
				// output setting sections and their fields
				// (sections are registered for "wp_cd_general", each field is registered to a specific section)
				do_settings_sections( 'wp_cd_general' );
				// output save settings button
				submit_button( 'Save Settings' );
				?>
			</form>
		</div>
		<?php
	}

	public function wp_cd_settings_link($links) {
		$settings_link = '<a href="options-general.php?page=wp_cd_general">Settings</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}
}
