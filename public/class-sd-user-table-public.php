<?php

/**
 * The public-facing functionality of the plugin.
 *

 * @since      1.0.0
 *
 * @package    SD_User_Table
 * @subpackage SD_User_Table/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    SD_User_Table
 * @subpackage SD_User_Table/public
 * @author     Sean Daniels <sbd12b@gmail.com>
 */
class SD_User_Table_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sd_user_table    The ID of this plugin.
	 */
	private $sd_user_table;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $sd_user_table       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($sd_user_table, $version)
	{

		$this->sd_user_table = $sd_user_table;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in SD_User_Table_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The SD_User_Table_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->sd_user_table, plugin_dir_url(__FILE__) . 'css/sd-user-table-public.css', array(), $this->version, 'all');
		wp_enqueue_style('Datatables', plugin_dir_url(__FILE__) . 'css/datatables.min.css', array(), 1, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in SD_User_Table_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The SD_User_Table_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->sd_user_table, plugin_dir_url(__FILE__) . 'js/sd-user-table-public.js', array('jquery'), $this->version, false);
		wp_enqueue_script('Datatables', plugin_dir_url(__FILE__) . 'js/datatables.min.js', array('jquery'), '2.1' , false);
	}

	public function get_table_data()
	{
		return get_users();
	}

	public function create_user_table($arr)
	{
		// See if shortcode viewer is logged in
		add_action('init', function () {
			$user_info = wp_get_current_user();
			if ($user_info->ID !== 0) {
				$GLOBALS['sd_userLoggedIn'] = true;
			} else {
				$GLOBALS['sd_userLoggedIn'] = false;
			}
			
		});
		
		// Change Template depending on whether user is logged in
		if ($GLOBALS['sd_userLoggedIn'] === true) {
			include(plugin_dir_path(__FILE__) . 'partials/sd-user-table-public-display.php');
		} else {
			include(plugin_dir_path(__FILE__) . 'partials/sd-user-table-public-display-notuser.php');
		}
	}
}
