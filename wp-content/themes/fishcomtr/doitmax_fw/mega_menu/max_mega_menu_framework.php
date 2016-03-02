<?php
/**
 * Max_MegaMenu Functions
 *
 * @package  Maxframe / MegaMenu
 * @author   doitmax
 * @link     http://doitmax.de
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	die;
}

// Don't duplicate me!
if( ! class_exists( 'Maxframe_MegaMenu_Framework' ) ) {

    /**
     * Main Maxframe_MegaMenu_Framework Class
     *
     * @since       4.0.0
     */
    class Maxframe_MegaMenu_Framework {

        public static $_version = '1.0.0';
        public static $_name;

        public static $_url;
        public static $_urls;
        public static $_dir;
        public static $_dirs;

        public static $_classes;

        function __construct() {

        	$this->init();

        	add_action( 'maxframe_init', 			array( $this, 'include_functions' ) );

        	add_action( 'admin_enqueue_scripts', 	array( $this, 'register_scripts' ) );
        	add_action( 'admin_enqueue_scripts',	array( $this, 'register_stylesheets' ) );

        	do_action( 'maxframe_init' );

        } // end __construct()

		static function init() {

			// Windows-proof constants: replace backward by forward slashes. Thanks to: @peterbouwmeester
			self::$_dir     = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
			$wp_content_dir = trailingslashit( str_replace( '\\', '/', WP_CONTENT_DIR ) );
			$relative_url   = str_replace( $wp_content_dir, '', self::$_dir );
			$wp_content_url = ( is_ssl() ? str_replace( 'http://', 'https://', WP_CONTENT_URL ) : WP_CONTENT_URL );
			self::$_url     = trailingslashit( $wp_content_url ) . $relative_url;

			self::$_urls = array(
				'parent'	=> MAX_FW_DIR . '/',
				'child' 	=> get_stylesheet_directory() . '/',
				'framework'	=> self::$_url . 'framework',
			);

			self::$_urls['admin-js'] = self::$_urls['parent'] . 'admin/js';
			self::$_urls['admin-css'] = self::$_urls['parent'] . 'admin/css';

			self::$_dirs = array(
				'parent' 	=> get_template_directory() . '/',
				'child' 	=> get_stylesheet_directory() . '/',
				'framework' => self::$_dir . 'framework',
			);

        } // end init()


        public function include_functions() {


			// Load functions

			require_once( MAX_FW_PATH . 'mega_menu/max_mega_menu.php' );

			self::$_classes['menus'] = new Maxframe_MegaMenu();


        } // end include_functions()

		/**
		 * Register megamenu javascript assets
		 *
		 * @return void
		 *
		 * @since  3.4
		 */
		function register_scripts() {

			// scripts
			wp_enqueue_media();
			wp_register_script( 'max-megamenu', self:: $_urls['admin-js'] . '/mega-menu.js', array( 'jquery' ), '1.0.0', true );
			wp_enqueue_script( 'max-megamenu' );
		}

		/**
		 * Enqueue megamenu stylesheets
		 *
		 * @return void
		 *
		 * @since  3.4
		 */
		function register_stylesheets() {

			wp_enqueue_style( 'max-megamenu', self::$_urls['admin-css'] . '/mega-menu.css', false, '1.0' );

		}



	}

	$maxcore = new Maxframe_MegaMenu_Framework();

}

?>