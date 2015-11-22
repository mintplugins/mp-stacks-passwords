jQuery( document ).ready( function( $ ){
					
	$( '.mp-stacks-passwords-container .mp-stacks-passwords-form' ).on( 'submit', function( event ){
				
		event.preventDefault();
		
		var brick_id = $(this).attr( 'mp-brick-id' ) ? $(this).attr( 'mp-brick-id' ) : false;
		var stack_id = $(this).attr( 'mp-stack-id' ) ? $(this).attr( 'mp-stack-id' ) : false;
		var this_brick_css_string = brick_id ? '#mp-brick-css-' + brick_id : null;
		var this_brick_string = brick_id ? '#mp-brick-' + brick_id : null;
		var this_stack_string = stack_id ? '#mp_stack_' + stack_id : null;
		
		//console.log(this_stack_string);
		
		// Use ajax to check the password
		var postData = {
			action: 'mp_stacks_passwords_unlock',
			mp_stacks_password: $(this).find('.mp-stacks-password').val(),
			mp_stacks_passwords_post_id: brick_id,
			mp_stacks_passwords_stack_id: stack_id,	
			mp_stacks_queried_object_id: $('body').attr('class').match(/\bmp-stacks-queried-object-id-(\d+)\b/)[1]
		}
		
		//Load the bricks that are now unlocked.
		$.ajax({
			type: "POST",
			data: postData,
			dataType:"json",
			url: mp_stacks_frontend_vars.ajaxurl,
			success: function (ajax_response) {
							
				//If the password was successfully entered
				if ( ajax_response.success ){
					
					//Re-Load the unlocked, password protected brick
					if ( ajax_response.brick_css && ajax_response.brick_html){
					
						mp_stacks_load_ajax_brick( ajax_response, brick_id, false, false );
						
					}
					
					//Re-Load the unlocked, password protected stack
					if ( ajax_response.stack_css ){
												
						mp_stacks_load_ajax_stack( ajax_response, stack_id, false, false );
					}
					
					
				}
				//If the password was incorrect
				else{
					
					if ( ajax_response.error ){
						//Tell the user their password was wrong
						if ( this_brick_string ){
							$( this_brick_string +' .message-text' ).html( ajax_response.error_message );
							$( this_brick_string +' .mp-stacks-password' ).val( '' );
						}
						if ( this_stack_string ){
							$( this_stack_string +' .message-text' ).html( ajax_response.error_message );
							$( this_stack_string +' .mp-stacks-password' ).val( '' );
						}
					}
					else{
						console.log( 'Incorrect Formatting in response from Ajax Function' );
						console.log(ajax_response);
					}
				
				}
				
			}
		}).fail(function (data) {
			console.log(data);
		});	
		
		
	});
	
}); 