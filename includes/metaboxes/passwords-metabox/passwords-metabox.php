<?php
/**
 * This page contains the functions to make a metabox for Passwords
 *
 * @link http://mintplugins.com/doc/metabox-class/
 * @since 1.0.0
 *
 * @package    MP Stacks Passwords
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2015, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 
/**
 * Function which creates new Meta Box
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/metabox-class/
 * @see      MP_CORE_Metabox
 * @return   void
 */
function mp_stacks_passwords_create_meta_box(){	

	//Array which stores all info about the new metabox
	$mp_stacks_passwords_add_meta_box = array(
		'metabox_id' => 'mp_stacks_passwords_metabox', 
		'metabox_title' => __( 'Password Settings', 'mp_stacks'), 
		'metabox_posttype' => 'mp_brick', 
		'metabox_context' => 'side', 
		'metabox_priority' => 'low' ,
		'metabox_load_content_when_opened' => true
	);
	
	
	//Array which stores all info about the options within the metabox
	$mp_stacks_passwords_items_array = array(
		array(
			'field_id'  => 'mp_stacks_brick_passwords_on',
			'field_title'  =>  __('Password Protect this Brick','mp_stacks_passwords' ),
			'field_description'  => __( 'Check this if you want to Password Protect this Brick.','mp_stacks_passwords' ),
			'field_value'  => '',
			'field_type'  => 'checkbox',
		),
		array(
			'field_id'  => 'mp_stacks_brick_passwords',
			'field_title'  =>  __('Passwords','mp_stacks_passwords' ),
			'field_description'  => __( 'Enter the passwords that will unlock this brick (comma separated)','mp_stacks_passwords' ),
			'field_placeholder'  => __( 'Password1, Password2', 'mp_stacks_passwords' ),
			'field_value'  => '',
			'field_type'  => 'textarea',
		)
	);
	
	
	//Custom filter to allow for add-on plugins to hook in their own data for add_meta_box array
	$mp_stacks_passwords_add_meta_box = has_filter('mp_stacks_passwords_meta_box_array') ? apply_filters( 'mp_stacks_passwords_meta_box_array', $mp_stacks_passwords_add_meta_box) : $mp_stacks_passwords_add_meta_box;
	
	//Custom filter to allow for add on plugins to hook in their own extra fields 
	$mp_stacks_passwords_items_array = has_filter('mp_stacks_passwords_items_array') ? apply_filters( 'mp_stacks_passwords_items_array', $mp_stacks_passwords_items_array) : $mp_stacks_passwords_items_array;
	
	//Create Metabox class
	global $mp_stacks_passwords_meta_box;
	$mp_stacks_passwords_meta_box = new MP_CORE_Metabox($mp_stacks_passwords_add_meta_box, $mp_stacks_passwords_items_array);
}
add_action('mp_brick_ajax_metabox', 'mp_stacks_passwords_create_meta_box');
add_action('wp_ajax_mp_stacks_passwords_metabox', 'mp_stacks_passwords_create_meta_box');