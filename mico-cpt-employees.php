<?php
/**
 * MICO CPT Employees
 *
 * @package 	MICO_CPT_Employees
 * @author  	Malthe Milthers <malthe@milthers.dk>
 * @license 	GPL
 * @link 		MICO, http://www.mico.dk
 *
 * @wordpress-plugin
 * Plugin Name: 	MICO CPT Employees
 * Plugin URI:		@TODO
 * Description: 	Registeres a translation ready Custom Post Type: "Employees".
 * Version: 		1.0.0
 * Author: 			Malthe Milthers
 * Author URI: 		http://www.malthemilthers.com
 * Text Domain: 	mico-cpt-employees
 * License: 		GPL
 * GitHub URI:		@TODO
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The plugin class
 */

class MICO_CPT_Employees {

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file and the name of the main plugin folder. 
	 *
	 * @since    1.0.0
	 * @var      string
	 */
	protected $plugin_slug = 'mico-cpt-employees';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 * @var      object
	 */
	protected static $instance = null;


	/**
	 * This class is only ment to be used once. 
	 * It basically works as a namespace.
	 *
	 * this insures that we can't call an instance of this class.
	 *
	 * @since  1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		
		// Event post type: Register post type
		add_action( 'init', array( $this, 'register_post_type' ) );
	}

	/**
	 * Return the instance of this class.
	 *
	 * @since 		1.0.0 
	 * @return		object		A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( self::$instance == null ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		$domain = $this->plugin_slug;

		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		$fullpath = dirname( basename( plugins_url() ) ) . '/' . basename(dirname(__FILE__))  . '/languages/';
	
		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, $fullpath );		
	
	}

	/**
	 * Register post types
	 *
	 * @since  1.0.0
	 */
	public function register_post_type() {

		if ( !post_type_exists( 'employee' ) ) :
			$labels = array(
				'name'                => _x( 'Employees', 'Post Type General Name', $this->plugin_slug ),
				'singular_name'       => _x( 'Employee', 'Post Type Singular Name', $this->plugin_slug ),
				'menu_name'           => __( 'Employees', $this->plugin_slug ),
				'parent_item_colon'   => __( 'Parent Employee:', $this->plugin_slug ),
				'all_items'           => __( 'All Employees', $this->plugin_slug ),
				'view_item'           => __( 'View Employee', $this->plugin_slug ),
				'add_new_item'        => __( 'Add New Employee', $this->plugin_slug ),
				'add_new'             => __( 'Add New', $this->plugin_slug ),
				'edit_item'           => __( 'Edit Employee', $this->plugin_slug ),
				'update_item'         => __( 'Update Employee', $this->plugin_slug ),
				'search_items'        => __( 'Search Employees', $this->plugin_slug ),
				'not_found'           => __( 'Not found', $this->plugin_slug ),
				'not_found_in_trash'  => __( 'Not found in Trash', $this->plugin_slug ),
			);
			$rewrite = array(
				'slug'                => _x( 'employee', 'URL slug', $this->plugin_slug ),
				'with_front'          => true,
				'pages'               => true,
				'feeds'               => true,
			);
			$args = array(
				'description'         => __( 'A list of employees', $this->plugin_slug ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => null,
				'menu_icon'           => 'dashicons-businessman',
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'rewrite'             => $rewrite,
				'capability_type'     => 'post',
			);
			register_post_type( 'employee', $args );

		endif;
	}

} // End of the MICO_CPT Class.

/*
 * Run the one and only instance of the plugins main class.
 */
add_action( 'plugins_loaded', array( 'MICO_CPT_Employees', 'get_instance' ) );