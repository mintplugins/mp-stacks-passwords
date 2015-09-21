<?php 
/**
 * This file contains the function which hooks to a brick's content output
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
 * This function hooks to the brick output. If it is supposed to be a 'feature', then it will output the passwords
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_brick_content_output_passwords($default_content_output, $mp_stacks_content_type, $post_id){
	
	//Set the password flag so we know whether this is Content Type 1 or 2
	global $mp_stacks_password_flags;
	
	//If this is Content-Type 2
	if ( isset( $mp_stacks_password_flags[$post_id] )  && !empty( $mp_stacks_password_flags[$post_id] ) ){
		//Get Passwords Metabox Repeater Array
		$password_protection = mp_core_get_post_meta($post_id, 'mp_stacks_brick_passwords_on', false);
		
		//If this brick is not Password Protected, move on to the next filter and get out of here.
		if ( !$password_protection ){
			return $default_content_output;
		}
		else{
			
			//Check if the password is being passed via ajax at this moment
			if ( 
				(isset( $_POST['mp_stacks_password'] ) && isset( $_POST['mp_stacks_passwords_post_id'] ) )
				||
				(isset( $_SESSION['mp_stacks_password'] ) && isset( $_SESSION['mp_stacks_passwords_post_id'] ) )
			){
				
				if( isset( $_POST['mp_stacks_password'] ) ){
					$entered_password = $_SESSION['mp_stacks_password'] = sanitize_text_field( $_POST['mp_stacks_password'] );
					$password_brick_id = $_SESSION['mp_stacks_passwords_post_id'] = sanitize_text_field( $_POST['mp_stacks_passwords_post_id'] );
				}
				elseif( isset( $_SESSION['mp_stacks_password'] ) ){
					$entered_password = sanitize_text_field( $_SESSION['mp_stacks_password'] );
					$password_brick_id = sanitize_text_field( $_SESSION['mp_stacks_passwords_post_id'] );
				}
				
				//If the password was entered for this brick
				if ( $password_brick_id == $post_id ){
					
					//Get this list of password that will unlock this brick
					$brick_passwords = explode( ',', str_replace( ' ', '', mp_core_get_post_meta( $post_id, 'mp_stacks_brick_passwords' ) ) );	
					
					//If our user's entered password matches any of the passwords allowed for this brick
					if ( in_array( $entered_password, $brick_passwords ) ){
						
						//The ajax-enetered password is correct, move on to the correct Content-Type filters
						return $default_content_output;
							
					}
				}
			}
				
		}
	}
	//If this is Content-Type 1
	if ( !isset( $mp_stacks_password_flags[$post_id] ) || empty( $mp_stacks_password_flags[$post_id] ) ){
		$mp_stacks_password_flags[$post_id] = true;
		
		//Get Passwords Metabox Repeater Array
		$password_protection = mp_core_get_post_meta($post_id, 'mp_stacks_brick_passwords_on', false);
		
		//If this brick is not Password Protected, move on to the next filter and get out of here.
		if ( !$password_protection ){
			return $default_content_output;
		}
		
		//Enqueue Scripts
		wp_enqueue_script( 'mp-stacks-passwords_js', plugins_url( '/js/mp-stacks-passwords.js', dirname( __FILE__ ) ), array( 'jquery' ), MP_STACKS_PASSWORDS_VERSION, true );
		
		//Check if the password is being passed via ajax at this moment
		if ( 
			(isset( $_POST['mp_stacks_password'] ) && isset( $_POST['mp_stacks_passwords_post_id'] ) )
			||
			(isset( $_SESSION['mp_stacks_password'] ) && isset( $_SESSION['mp_stacks_passwords_post_id'] ) )
		){
			
			if( isset( $_POST['mp_stacks_password'] ) ){
				$entered_password = $_SESSION['mp_stacks_password'] = sanitize_text_field( $_POST['mp_stacks_password'] );
				$password_brick_id = $_SESSION['mp_stacks_passwords_post_id'] = sanitize_text_field( $_POST['mp_stacks_passwords_post_id'] );
			}
			elseif( isset( $_SESSION['mp_stacks_password'] ) ){
				$entered_password = sanitize_text_field( $_SESSION['mp_stacks_password'] );
				$password_brick_id = sanitize_text_field( $_SESSION['mp_stacks_passwords_post_id'] );
			}
			
			//If the password was entered for this brick
			if ( $password_brick_id == $post_id ){
				
				//Get this list of password that will unlock this brick
				$brick_passwords = explode( ',', str_replace( ' ', '', mp_core_get_post_meta( $post_id, 'mp_stacks_brick_passwords' ) ) );	
				
				//If our user's entered password matches any of the passwords allowed for this brick
				if ( in_array( $entered_password, $brick_passwords ) ){
					
					//The ajax-enetered password is correct, move on to the correct Content-Type filters
					return $default_content_output;
						
				}
			}
		}
		
		//If we made it this far without returning, this brick is still locked.
		$content_output = '<div class="mp-stacks-passwords-container">';
			
			ob_start();
			
			?>
			<div class="mp-stacks-password-login" style="background-color:rgba(0, 0, 0, 0.58); max-width:350px; margin: 0 auto; padding:20px 20px 35px 20px; box-sizing:border-box;">
				
				<div class="message-text" style="font-size: 20px; color:#fff; margin-bottom:15px;"><?php echo apply_filters( 'mp_stacks_password_message', __( 'This content is locked', 'mp_stacks_passwords' ), $post_id ); ?></div>
				
                <form class="mp-stacks-passwords-form" method="POST" post-id="<?php echo $post_id; ?>">
                    <input class="mp-stacks-password" name="mp-stacks-password" placeholder="<?php echo __( 'Enter Password...', 'mp_stacks_passwords' ); ?>" type="password" style="display:inline-block; width:85%; overflow:hidden; text-align:center;" />          
                    <input type="submit" class="button" value="<?php echo __( 'Unlock', 'mp_stacks_passwords' ); ?>" style="display:inline-block; width:85%; overflow:hidden; margin-top:10px;"/>
				</form>
                
			</div>
			
			<?php
			
			$content_output .= ob_get_clean();
			
		$content_output .= '</div>';
		
		return $content_output;
	
	}
	
}
add_filter('mp_stacks_brick_content_output', 'mp_stacks_brick_content_output_passwords', 99, 3);