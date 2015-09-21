<?php
/**
 * This file contains the function keeps the MP Stacks Passwords plugin up to date.
 *
 * @since 1.0.0
 *
 * @package    MP Stacks Passwords
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2014, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */
 
/**
 * Check for updates for the MP Stacks Passwords Plugin by creating a new instance of the MP_CORE_Plugin_Updater class.
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
 if (!function_exists('mp_stacks_passwords_update')){
	function mp_stacks_passwords_update() {
		$args = array(
			'software_name' => 'MP Stacks Passwords', //<- The exact name of this Plugin. Make sure it matches the title in your mp_stacks-passwords, passwords, and the WP.org stacks-passwords
			'software_api_url' => 'http://mintplugins.com',//The URL where Passwords and mp_stacks-passwords are installed and checked
			'software_filename' => 'mp-stacks-passwords.php',
			'software_licensed' => false, //<-Boolean
		);
		
		//Since this is a plugin, call the Plugin Updater class
		$mp_stacks_passwords_plugin_updater = new MP_CORE_Plugin_Updater($args);
	}
 }
add_action( 'admin_init', 'mp_stacks_passwords_update' );
