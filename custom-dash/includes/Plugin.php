<?php
/**
 * Main plugin class. Iinitialises hooks and filters as well as setting up
 * middleware used throughout the plugin.
 * Any plugin-wide housekeeping processes may be placed here.
 *
 * @package ias-wp-customdash
 * @since   1.0.0
 */

declare( strict_types = 1 );

namespace Imarun\CustomDash;
use Imarun\CustomDash\Admin\Settings;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * @since   1.0.0
 * @package Imarun\CustomDash
 * @author  Arun Sharma <dextorlobo@gmail.com>
 */
class Plugin {

	private $text_or_logo;
	private $logo_text;
	private $logo_url;
	private $logo_width;
	private $logo_height;
	private $login_header_url;

	/**
	 * Plugin constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// admin hooks.
		if ( is_admin() ) {
			add_action( 'after_setup_theme', array ( $this, 'cd_register_settings' ) );
			add_action( 'admin_enqueue_scripts', array ( $this, 'cd_enqueue_admin_script' ) );
		}

		// front-end hooks.
		add_action( 'login_head', array ( $this, 'cd_login_logo_css' ) );
		add_filter( 'login_headertext', array ( $this, 'cd_login_header_text' ) );
		add_filter( 'login_headerurl', array ( $this, 'cd_login_header_url' ) );
	}

	/**
	 * Registering settings pages
	 * 
	 * @since 1.0.0
	 */
	public function cd_register_settings() {
		new Settings();
	}

	/**
	 * Enqueue a script in the WordPress admin only on settings_page_wp_cd_general page.
	 *
	 * @param string $hook Hook suffix for the current admin page.
	 * @since 1.0.0
	 */
	public function cd_enqueue_admin_script( $hook ) {
		if ( 'settings_page_wp_cd_general' == $hook ) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_media();
			wp_enqueue_script( 'ias-custom-script', plugin_dir_url( __FILE__ ) . 'assets/custom-script.js', array( 'jquery' ), IAS_CD_WP_PLUGIN_VERSION, true );
		}
	}

	/**
	 * Custom WordPress admin login logo css.
	 * 
	 * @since 1.0.0
	 */
	public function cd_login_logo_css() {
		$options                = get_option( 'wp_cd_general_options' );
		$this->text_or_logo     = ( isset( $options['wp_cd_general_text_or_logo'] ) && ! empty( $options['wp_cd_general_text_or_logo'] ) ) ? $options['wp_cd_general_text_or_logo'] : '';
		$this->logo_text        = ( isset( $options['wp_cd_general_text_logo'] ) && ! empty( $options['wp_cd_general_text_logo'] ) ) ? $options['wp_cd_general_text_logo'] : '';
		$this->logo_url         = ( isset( $options['wp_cd_general_login_logo'] ) && ! empty( $options['wp_cd_general_login_logo'] ) ) ? $options['wp_cd_general_login_logo'] : '';
		$this->logo_height      = ( isset( $options['wp_cd_general_logo_height'] ) && ! empty( $options['wp_cd_general_logo_height'] ) ) ? $options['wp_cd_general_logo_height'] . 'px' : '84px';
		$this->logo_width       = ( isset( $options['wp_cd_general_logo_width'] ) && ! empty( $options['wp_cd_general_logo_width'] ) ) ? $options['wp_cd_general_logo_width'] . 'px' : '84px';
		$this->login_header_url = ( isset( $options['wp_cd_general_login_header_url'] ) && ! empty( $options['wp_cd_general_login_header_url'] ) ) ? $options['wp_cd_general_login_header_url'] : '';

		if ( empty( $this->text_or_logo ) ) {
			return;
		}

		$this->logo_height = apply_filters( 'cd_cusotm_logo_height', $this->logo_height );
		$this->logo_width  = apply_filters( 'cd_cusotm_logo_width', $this->logo_width );

		$text_indent = '-9999px;';

		if ( $this->text_or_logo == 'text' ) {
			$this->logo_url = 'none';
			$text_indent    = '0';
		}

		if ( ! empty( $this->logo_url ) ) {
			echo '<style type="text/css"> h1 a { 
				background-image:url( ' . esc_attr( $this->logo_url ) . ' ) !important;
				height:' . esc_attr( $this->logo_height ) . ' !important;
				width:' . esc_attr( $this->logo_width ) . ' !important;
				background-size:100% !important;
				line-height:inherit !important;
				text-indent: ' . esc_attr( $text_indent ) . ' !important;
			}</style>';
		}
	}

	/**
	 * Login screen header text.
	 * 
	 * @since 1.0.0
	 */
	public function cd_login_header_text( $login_header_text ) {
		if ( $this->text_or_logo == 'text' && ! empty( $this->logo_text ) ) {
			return $this->logo_text;
		}

		return $login_header_text;
	}

	/**
	 * Login screen header url.
	 * 
	 * @since 1.0.0
	 */
	public function cd_login_header_url( $login_header_url ) {
		if ( $this->login_header_url ) {
			return $this->login_header_url;
		}

		return $login_header_url;
	}
}
