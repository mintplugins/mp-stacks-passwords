<?php 
/**
 * This file contains the ajax callback functions involved in the mp stacks + passwords
 *
 * @since 1.0.0
 *
 * @package    MP Stacks Passwords
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2015, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */

/**
 * This function checks a password entered via ajax and returns brick content if correct.
 *
 * @since    1.0.0
 * @link     
 * @see      function_name()
 * @param    void
 * @return   void
 */  
function mp_stacks_passwords_unlock_ajax(){
	
	$stack_id = sanitize_text_field( $_POST['mp_stacks_passwords_stack_id'] );
	$brick_id = sanitize_text_field( $_POST['mp_stacks_passwords_post_id'] );
	$entered_password = sanitize_text_field( $_POST['mp_stacks_password'] );
	
	$return_array = NULL;
	
	//If this user is attempting to unlock a "Brick"
	if ( $brick_id != 0 ){
		
		$brick_passwords = explode( ',', str_replace( ' ', '', mp_core_get_post_meta( $brick_id, 'mp_stacks_brick_passwords' ) ) );	
		
		//If our user's entered password matches any of the passwords allowed for this brick
		if ( in_array( $entered_password, $brick_passwords ) ){
			
			//Create the output for the Brick Ajax
			mp_stacks_brick_ajax( $_POST['mp_stacks_passwords_post_id'] );
				
		}
		//If the password is incorrect
		else{
			
			$return_array['error'] = true;
			$return_array['error_message'] = __( 'Incorrect Password', 'mp_stacks_password' );
			
			echo json_encode( $return_array );
			die();
			
		}
		
	}
	//This user is attempting to unlock an entire "Stack"
	else if( $stack_id != 0 ){
		
		//Get the list of passwords that work to unlock this stack
		$mp_stacks_single_stack_passwords = explode( ',', str_replace( ' ', '', get_option( 'mp_stacks_stack_' . $stack_id . '_passwords' ) ) );
		
		//If our user's entered password matches any of the passwords allowed for this brick
		if ( in_array( $entered_password, $mp_stacks_single_stack_passwords ) ){
		
			//Create the output for the Stack Ajax
			mp_stacks_stack_ajax( $_POST['mp_stacks_passwords_stack_id'] );
				
		}
		//If the password is incorrect
		else{
			
			$return_array['error'] = true;
			$return_array['error_message'] = __( 'Incorrect Password', 'mp_stacks_password' );
			
			echo json_encode( $return_array );
			die();
			
		}
		
	}
	
}
add_action( 'wp_ajax_mp_stacks_passwords_unlock', 'mp_stacks_passwords_unlock_ajax' );
add_action( 'wp_ajax_nopriv_mp_stacks_passwords_unlock', 'mp_stacks_passwords_unlock_ajax' );