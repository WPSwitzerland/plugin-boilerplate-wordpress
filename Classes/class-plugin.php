<?php
/**
 * This file defines the main plugin class inside a specific namespace.
 *
 * @package PLUGIN_KEY
 */

namespace AUTHOR_NAMESPACE\PLUGIN_NAMESPACE;

/**
 * The main plugin class designed as a singleton.
 */
class Plugin {

	/**
	 * The actual plugin instance.
	 *
	 * @var Plugin
	 */
	private static $instance;

	/**
	 * The plugin name
	 *
	 * @var string
	 */
	public static $name = '';

	/**
	 * The plugin prefix
	 *
	 * @var string
	 */
	public static $prefix = '';

	/**
	 * The plugin version
	 *
	 * @var string
	 */
	public static $version = '';

	/**
	 * Name of the main plugin file
	 *
	 * @var string
	 */
	public static $file = '';

	/**
	 * Creates an instance if one isn't already available,
	 * then return the current instance.
	 *
	 * @param  string $file The file from which the class is being instantiated.
	 * @return object       The class instance.
	 */
	public static function get_instance( $file ) {
		if ( ! isset( self::$instance ) && ! (self::$instance instanceof Plugin) ) {
			self::$instance = new Plugin;
			self::$instance->run();

			$data = get_plugin_data( $file );

			self::$instance->name = $data['Name'];
			self::$instance->prefix = 'PLUGIN_PREFIX';
			self::$instance->version = $data['Version'];
			self::$instance->file = $file;
		}
		return self::$instance;
	}

	/**
	 * Non-essential dump function to debug variables.
	 *
	 * @param  mixed   $var The variable to be output.
	 * @param  boolean $die Whether the script should stop immediately after outputting $var.
	 */
	public function dump( $var, $die = false ) {
		echo '<pre>' . print_r( $var, 1 ) . '</pre>';
		if ( $die ) {
			die();
		}
	}

	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 */
	private function run() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
	}

	/**
	 * Load translation files from the indicated directory.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'TEXT_DOMAIN', false, dirname( plugin_basename( $this->file ) ) . '/languages' );
	}
}
