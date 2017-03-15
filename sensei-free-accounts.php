<?php
/*
	Plugin Name: Sensei Free Accounts Manager
	Description: Create accounts as a gift for new users
	Version: 0.5.9
	Author: Alejandro Orta
	Author URI: http://alejandro-orta.es/
*/

include dirname(__FILE__). '/templates/email-template.php';

include dirname(__FILE__). '/class/main-class.php';

// Plugin URL
if (!defined( 'SENSEI_FREE_ACCOUNTS_URL' ) ) {
	$plugin_url = plugin_dir_url( __FILE__ );

	if ( is_ssl() ) {
		$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
	}

	define( 'SENSEI_FREE_ACCOUNTS_URL', $plugin_url );
}

class SenseiFreeAccounts {
	function __construct() {
		add_action( 'admin_menu', array( $this, 'create_new_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_custom_admin_assets' ));
	}

	public function load_custom_admin_assets( $hook ) {
		if( $hook == 'toplevel_page_free_accounts_manager' ) {
			wp_register_style( 'jquery_tags_css', SENSEI_FREE_ACCOUNTS_URL.'assets/jquery_tags/jquery.tagsinput.min.css', false );
			wp_register_script( 'jquery_tags_js', SENSEI_FREE_ACCOUNTS_URL.'assets/jquery_tags/jquery.tagsinput.min.js', array( 'jquery' ) );

			wp_enqueue_script( 'jquery_tags_js' );
			wp_enqueue_style( 'jquery_tags_css' );
		}
	}

	public function create_new_admin_menu() {
		add_menu_page( 'Free Accounts Manager', 'Free Accounts Manager', 'manage_options', 'free_accounts_manager', array( $this, 'dashboard_page' ), 'dashicons-tickets-alt', 6 );
	}

	public function dashboard_page() {
		include dirname(__FILE__). '/templates/dashboard.php';
	}
}

add_action( 'init', function() {
	$ls_subs_reports = new SenseiFreeAccounts();
} );
