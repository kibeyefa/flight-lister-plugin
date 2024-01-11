<?php
/*
Plugin Name: Flight Lister
Plugin URI: https://dev-kibeyefa.pantheonsite.io/flight-lister/
Description: Lists flight data from Aviation stack
Version: 1.0.0
Author: Koboju Kibeyefa
Author URI: https://dev-kibeyefa.pantheonsite.io

	Copyright 2023 Koboju Kibeyefa

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if( !defined( 'FLIGHT_LISTER_VER' ) )
	define( 'FLIGHT_LISTER_VER', '1.0.0' );

// Start up the engine
class Flight_Lister
{

	/**
	 * Static property to hold our singleton instance
	 *
	 */
	static $instance = false;

	/**
	 * This is our constructor
	 *
	 * @return void
	 */
	private function __construct() {
		add_action('admin_menu', array($this, 'Flight_Lister_Admin_Settings_Page'));
		add_action('admin_init', array($this, 'Flight_lister_settings'));

		add_action('wp_enqueue_scripts', array($this, 'front_scripts'));

		add_action('wp_ajax_test_ajax_action', array($this, 'flight_scrapper'));
		add_action('wp_ajax_nopriv_test_ajax_action', array($this, 'flight_scrapper'));
	
		// do_action( '$hook_name:string', $arg:mixed )
	}

	/**
	 * If an instance exists, this returns it.  If not, it creates one and
	 * returns it.
	 *
	 * @return Flight_Lister
	 */

	public static function getInstance() {
		if ( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}

	/**
	 * Admin styles
	 *
	 * @return void
	 */

	public function admin_scripts() {

	}


	/**
	 * call front-end CSS
	 *
	 * @return void
	 */

	public function front_scripts() {
		wp_enqueue_script(
			'ajax-script',
			plugins_url( '/lib/js/app.js', __FILE__ ),
			array( 'jquery' ),
			'1.0.,0',
			array(
				'in_footer' => true,
			)
		);
		wp_register_style('frontend-css', plugins_url('/lib/css/frontend.css', __FILE__));
		wp_enqueue_style( 'frontend-css' );
		wp_localize_script( 'ajax-script', 'flight_obj', array( 'ajax_url' => admin_url('admin-ajax.php'), 'wp_content_url' => content_url()));
	}

	/**
	 * undocumented function summary
	 *
	 * Undocumented function long description
	 **/
	public function Flight_lister_settings()
	{
		add_settings_section('flight_lister_section', null, null, 'flight-lister-settings-page', );
		
		add_settings_field('aviation_stack_api_key', 'Aviation stack API Key:', array($this, 'Flight_Lister_Settings_Form'), 'flight-lister-settings-page', 'flight_lister_section');

		add_settings_field('flight_lister_color', 'Flight Lister default Color:', array($this, 'Light_Lister_Color_Settings_Input'), 'flight-lister-settings-page', 'flight_lister_section');

		register_setting('flight-lister-plugin', 'aviation_stack_api_key', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));
		
		register_setting('flight-lister-color-setting', 'flight_lister_color', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));
	}

	public function Flight_Lister_Admin_Settings_Page(){
		add_options_page('Flight Lister Settings', 'Flight Lister', 'manage_options', 'flight-lister-settings-page', array($this, 'Flight_Lister_Settings_Page_HTML'));
	}

	public function Flight_Lister_Settings_Form(){
		?>
		<input type="text" name="aviation_stack_api_key", 
			value="<?php echo esc_attr(get_option('aviation_stack_api_key', '')) ?>">
		<?php
	}

	public function Light_Lister_Color_Settings_Input(){
		?>
		<input type="color" name="flight_lister_color" id="" value="<?php echo esc_attr(get_option('flight_lister_color', '')) ?>">
		<?php
	}

	public function Flight_Lister_Settings_Page_HTML(){
		?>
		<div class="wrap">
			<h1>Flight Lister Settings</h1>
			<form action="options.php" method="post">
				<?php 
					settings_fields( 'flight-lister-plugin' );
					settings_fields('flight-lister-color-setting');
					do_settings_sections('flight-lister-settings-page');
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	// Scraping Logic goes here
	public function flight_scrapper(){
		echo json_encode("Hello world");
		wp_die();
	}

/// end class
}


// Instantiate our class
$Flight_Lister = Flight_Lister::getInstance();


include 'index.php';