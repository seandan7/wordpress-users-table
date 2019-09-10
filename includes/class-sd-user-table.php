<?php


/**
 * The core plugin class.
 *
 * This is used to define internationalization and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    SD_User_Table
 * @subpackage SD_User_Table/includes
 * @author     Sean Daniels <sbd12b@gmail.com>
 */
class SD_User_Table
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      SD_User_Table_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $sd_user_table    The string used to uniquely identify this plugin.
	 */
	protected $sd_user_table;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('SD_USER_TABLE_VERSION')) {
			$this->version = SD_USER_TABLE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->sd_user_table = 'sd-user-table';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_public_hooks();
		$this->create_shortcode();
		$this->register_shortcode();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - SD_User_Table_Loader. Orchestrates the hooks of the plugin.
	 * - SD_User_Table_i18n. Defines internationalization functionality.
	 * - SD_User_Table_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-sd-user-table-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-sd-user-table-i18n.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-sd-user-table-public.php';

		$this->loader = new SD_User_Table_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the SD_User_Table_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new SD_User_Table_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}


	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new SD_User_Table_Public($this->get_sd_user_table(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_sd_user_table()
	{
		return $this->sd_user_table;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    SD_User_Table_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}

	/**
	 * Create the shortcode 
	 * 
	 * 
	 * @since     1.0.0
	 */
	public function create_shortcode()
	{
		
		ob_start();
		$table_to_show =  new SD_User_Table_Public($this->get_sd_user_table(), $this->get_version());
		$users = $table_to_show->get_table_data();

		// If user logged in
		$table_to_show->create_user_table($users);
		return ob_get_clean();
	}

	/**
	 * Register the shortcode
	 * 
	 * @since     1.0.0
	 * 
	 */
	public function register_shortcode()
	{
		add_shortcode('sd_user_table', array($this, 'create_shortcode'));
	}
}
