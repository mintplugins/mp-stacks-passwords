jQuery( document ).ready( function( $ ){
					
	$( '.mp-stacks-passwords-container .mp-stacks-passwords-form' ).on( 'submit', function( event ){
		
		event.preventDefault();
		
		var brick_id = $(this).attr( 'post-id' );
		var stack_id = $(this).attr( 'stack-id' );
		var this_brick_css_string = $(this).attr( 'post-id' ) ? '#mp-brick-css-' + $(this).attr( 'post-id' ) : null;
		var this_brick_string = $(this).attr( 'post-id' ) ? '#mp-brick-' + $(this).attr( 'post-id' ) : null;
		var this_stack_string = $(this).attr( 'stack-id' ) ? '#mp_stack_' + $(this).attr( 'stack-id' ) : null;
		
		console.log(this_stack_string);
		
		// Use ajax to check the password
		var postData = {
			action: 'mp_stacks_passwords_unlock',
			mp_stacks_password: $(this).find('.mp-stacks-password').val(),
			mp_stacks_passwords_post_id: $(this).attr( 'post-id' ) ? $(this).attr( 'post-id' ) : false,
			mp_stacks_passwords_stack_id: $(this).attr( 'stack-id' ) ? $(this).attr( 'stack-id' ) : false,	
			mp_stacks_queried_object_id: $('body').attr('class').match(/\bmp-stacks-queried-object-id-(\d+)\b/)[1]
		}
		
		//Ajax load more posts
		$.ajax({
			type: "POST",
			data: postData,
			dataType:"json",
			url: mp_stacks_frontend_vars.ajaxurl,
			success: function (response) {
				
				//If the password was successfully entered
				if ( response.success ){
					
					//Put the Brick's CSS into the <head> of this document
					if ( response.brick_css ){
						
						$( this_brick_css_string ).replaceWith( response.brick_css );	
							
					}
					
					//Replace the Brick's HTML 
					if ( response.brick_html ){
						$( this_brick_string ).replaceWith( response.brick_html );
						
						//jQuery Trigger which Add-Ons can use to update themselves when a Brick is updated.
						$( document ).trigger( 'mp_stacks_brick_loaded_via_ajax', [brick_id] );
					}
					
					//Put the Stack's CSS into the <head> of this document
					if ( response.stack_css ){
						$( 'head' ).append( response.stack_css );
					}
					
					//Replace the Stack's HTML 
					if ( response.stack_html ){
						$( this_stack_string ).replaceWith( response.stack_html );
						
						//jQuery Trigger which Add-Ons can use to update themselves when a Brick is updated.
						$( document ).trigger( 'mp_stacks_stack_loaded_via_ajax', [stack_id] );
					}
					
				}
				//If the password was incorrect
				else{
					
					if ( response.error ){
						//Tell the user their password was wrong
						if ( this_brick_string ){
							$( this_brick_string +' .message-text' ).html( response.error_message );
							$( this_brick_string +' .mp-stacks-password' ).val( '' );
						}
						if ( this_stack_string ){
							$( this_stack_string +' .message-text' ).html( response.error_message );
							$( this_stack_string +' .mp-stacks-password' ).val( '' );
						}
					}
					else{
						console.log( 'Incorrect Formatting in response from Ajax Function' );
						console.log(response);
					}
				
				}
				
			}
		}).fail(function (data) {
			console.log(data);
		});	
		
		
	});
	
}); 