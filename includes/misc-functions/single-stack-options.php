<?php 
/**
 * Single Stack Options for the MP Stacks + Passwords Add On
 *
 * @link http://mintplugins.com/doc/
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
 * Make the "Stack Passwords" Field show on the Single Stack Edit Page
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/
 * @param    $stack_id the ID of the Stack we are currently viewing/editing
 * @return   void
 */
function mp_stacks_single_stack_password_option( $stack_id ){
	
	$mp_stacks_single_stack_passwords = get_option( 'mp_stacks_stack_' . $stack_id . '_passwords' );
	$mp_stacks_single_stack_passwords = !empty( $mp_stacks_single_stack_passwords ) ? $mp_stacks_single_stack_passwords : NULL;
	
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="mp_stacks_stack_password"><?php _e('Stack Passwords', 'mp_stacks_passwords' ); ?></label></th>
		<td>
			<input type="text" name="mp_stacks_stack_password" id="mp_stacks_stack_password" size="3" style="width:60%;" value="<?php echo $mp_stacks_single_stack_passwords; ?>" placeholder="<?php echo __( 'password1, password2', 'mp_stacks_passwords' ); ?>"><br />
			<span class="description"><?php _e('If you want to password protect this entire Stack, enter passwords for it here (comma separated). For no password protection, leave blank.'); ?></span>
		</td>
	</tr>
	<?php 
}
add_action( 'mp_stacks_single_edit_page_options_table_bottom', 'mp_stacks_single_stack_password_option');

/**
 * Save the "Stack Passwords" for a single Stack
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/
 * @param    $stack_id the ID of the Stack we are currently updating
 * @return   void
 */
function mp_stacks_single_stack_password_save( $stack_id ){
	
	$mp_stacks_single_stack_passwords = isset( $_POST['mp_stacks_stack_password'] ) ? sanitize_text_field( $_POST['mp_stacks_stack_password'] ) : NULL;
	
	update_option( 'mp_stacks_stack_' . $stack_id . '_passwords', $mp_stacks_single_stack_passwords );
	
}
add_action( 'mp_stacks_update_stack_options', 'mp_stacks_single_stack_password_save' );

/**
 * When outputting a Stack, check if it is password protected and show dialog accordingly
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/
 * @param    $stack_html_output the HTML Output for the Stack in question
 * @param    $stack_id the ID of the Stack we are currently updating
 * @return   $stack_html_output String | If password protected, it is a password dialog. If not, it is a normal Stack's HTML output.
 */
function mp_stacks_single_stack_password_output( $stack_html_output, $stack_id ){
	
	//Check if this Stack is supposed to be password protected
	$mp_stacks_single_stack_passwords = get_option( 'mp_stacks_stack_' . $stack_id . '_passwords' );
	
	//Check if the password is being passed via ajax at this moment
	if ( 
		(isset( $_POST['mp_stacks_password'] ) && isset( $_POST['mp_stacks_passwords_stack_id'] ) )
		||
		(isset( $_SESSION['mp_stacks_password'] ) && isset( $_SESSION['mp_stacks_passwords_stack_id'] ) )
	){
		
		if( isset( $_POST['mp_stacks_password'] ) ){
			$entered_password = $_SESSION['mp_stacks_password'] = sanitize_text_field( $_POST['mp_stacks_password'] );
			$password_stack_id = $_SESSION['mp_stacks_passwords_stack_id'] = sanitize_text_field( $_POST['mp_stacks_passwords_stack_id'] );
		}
		elseif( isset( $_SESSION['mp_stacks_password'] ) ){
			$entered_password = sanitize_text_field( $_SESSION['mp_stacks_password'] );
			$password_stack_id = sanitize_text_field( $_SESSION['mp_stacks_passwords_stack_id'] );
		}
		
		//If the password was entered for this Stack
		if ( $password_stack_id == $stack_id ){
			
			//Set-up the list of password that will unlock this Stack
			$stack_passwords = explode( ',', str_replace( ' ', '', $mp_stacks_single_stack_passwords ) );	
			
			//If our user's entered password matches any of the passwords allowed for this brick
			if ( in_array( $entered_password, $stack_passwords ) ){
				
				//The ajax-enetered password is correct, move on to the normal Stack Output - unlocked now.
				return $stack_html_output;
					
			}
		}
	}
		
	//If this Stack is not password protected
	if ( empty( $mp_stacks_single_stack_passwords ) ){
		//Show the Stack normally.
		return $stack_html_output;
	}
	//If this Stack is password protected
	else{
		
		//Output a password dialog
		$content_output = '<div id="mp_stack_' . $stack_id . '" class="mp-stack">';
			$content_output .= '<div class="mp-stacks-passwords-container">';
				
				ob_start();
				
				?>
				<div class="mp-stacks-password-login" style="background-color:rgba(0, 0, 0, 0.58); width:100%; margin: 0 auto; padding:150px 20px 150px 20px; box-sizing:border-box; text-align:center;">
					
					<div class="message-text" style="font-size: 20px; color:#fff; margin-bottom:15px;"><?php echo apply_filters( 'mp_stacks_password_message', __( 'This content is locked', 'mp_stacks_passwords' ), $stack_id ); ?></div>
					
					<form class="mp-stacks-passwords-form" method="POST" stack-id="<?php echo $stack_id; ?>" style="width:100%; max-width:280px; display: inline-block;">
						<input class="mp-stacks-password" name="mp-stacks-password" placeholder="<?php echo __( 'Enter Password...', 'mp_stacks_passwords' ); ?>" type="password" style="display:inline-block; width:100%; max-width:280px; overflow:hidden; text-align:center;" />          
						<input type="submit" class="button" value="<?php echo __( 'Unlock', 'mp_stacks_passwords' ); ?>" style="display:inline-block; width:100%; max-width:280px; overflow:hidden; margin-top:10px;"/>
					</form>
					
				</div>
				
				<?php
				
				$content_output .= ob_get_clean();
				
			$content_output .= '</div>';
		$content_output .= '</div>';
		
		return $content_output;
		
	}

}
add_filter( 'mp_stacks_html_output', 'mp_stacks_single_stack_password_output', 10, 2 );