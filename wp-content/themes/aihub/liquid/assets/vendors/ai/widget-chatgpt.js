jQuery( document ).ready( function ( $ ) {

	// Request
	$( '.lqd-chatgpt--form' ).on( 'submit', function ( e ) {

		let wrapper = $( this ).parent(); // select .lqd-dall-e
		let messages = wrapper.find('.lqd-chatgpt--results-messages');
		let options = JSON.parse($( this ).attr( 'data-options' ));

		messages.append( '<div class="lqd-chatgpt--results-message">' + $( '.lqd-chatgpt #prompt' ).val() + '</div>' );
		messages.append( '<div class="lqd-chatgpt--loader rounded-inherit relative"><div class="lds-ripple"><div></div><div></div></div><div class="text">' + options.label_typing + '</div></div>' );
		messages.animate({ scrollTop: messages.prop("scrollHeight")}, 200);
		wrapper.addClass('loading');
		wrapper.removeClass( 'error-login' );
		wrapper.removeClass( 'error-limit' );
		wrapper.removeClass( 'success' );

		//images.empty();

		$.ajax( {
			url: liquidTheme.uris.ajax,
			type: 'POST',
			data: {
				action: 'liquid_ai_chat',
				prompt: $( '.lqd-chatgpt #prompt' ).val(),
				l: options.l,
				security: $( '.lqd-chatgpt #security' ).val()
			},
			success: function ( data ) {
				wrapper.removeClass( 'loading' );
				$( '.lqd-chatgpt--loader' ).remove();
				$( '.lqd-chatgpt #prompt' ).val("");
				$( '.lqd-chatgpt #prompt' ).focus();
				if ( data.error === true ) {
					add_log( data.message );
					if ( data.reason ) {
						if ( data.reason === 'login' ){
							wrapper.addClass( 'error-login' );
						} else if (data.reason === 'limit') {
							wrapper.addClass( 'error-limit' );
						}
					} else {
						alert( data.message );
					}
				} else {
					wrapper.addClass( 'success' );
					messages.append(data.output);
					messages.animate({ scrollTop: messages.prop("scrollHeight")}, 200);
				}
			}
		} );
		e.preventDefault();
	} );

	// Tags
	// $( document ).on( 'click', '.lqd-dall-e--tags .lqd-dall-e--tag', function ( e ) {
	// 	$( '.lqd-dall-e--form #prompt' ).val( $( this ).attr( 'data-prompt' ) );
	// } );

	// Logging actions
	function add_log( message ) {
		$.ajax( {
			url: liquidTheme.uris.ajax,
			type: 'POST',
			data: {
				action: 'liquid_ai_add_log',
				log: get_log_time() + message,
			},
			success: function ( data ) {
				//console.log(data.message);
			}
		} );
	}

	function get_log_time() {
		let date = new Date().toLocaleString();
		return '[' + date + '] - ';
	}

} );