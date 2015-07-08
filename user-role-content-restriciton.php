<?php
/*
Plugin Name: User Role Content Restriction
Version: 0.1-alpha
Description: An extension of theAverageDev Restricted Content plugin to restrict content on a user role base.
Author: Luca Tumedei
Author URI: http://theaveragedev.com
Plugin URI: http://theaveragedev.com
Text Domain: urcr
Domain Path: /languages
*/

function urcr_autoload( $class ) {
	if ( strpos( $class, 'urcr_' ) === 0 ) {
		require 'src/' . str_replace( 'urcr_', '', $class ) . '.php';
	}
}
spl_autoload_register( 'urcr_autoload' );


function urcr_load() {
	urcr_Plugin::instance()
	           ->hooks();
}
add_action( 'plugins_loaded', 'urcr_load' );

register_activation_hook( __FILE__, array( 'urcr_Plugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'urcr_Plugin', 'deactivate' ) );
