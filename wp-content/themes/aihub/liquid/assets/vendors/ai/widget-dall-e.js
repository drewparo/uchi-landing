jQuery( document ).ready( function ( $ ) {

	// Request
	$( '.lqd-dall-e--form' ).on( 'submit', function ( e ) {

		let wrapper = $( this ).parent(); // select .lqd-dall-e
		let images = wrapper.find('.lqd-dall-e--results-images');
		let options = JSON.parse($( this ).attr( 'data-options' ));
		var fileInput = $('.lqd-dall-e #image');

		wrapper.addClass('loading');
		wrapper.removeClass( 'error-login' );
		wrapper.removeClass( 'error-limit' );
		wrapper.removeClass( 'success' );
		images.empty();

        form_data = new FormData();
		if ( fileInput.length ) {
			form_data.append('image', fileInput.prop('files')[0]);
		} else {
			form_data.append('image', '');
		}
        form_data.append('action', 'liquid_ai_dall_e');
        form_data.append('prompt', $( '.lqd-dall-e #prompt' ).val());
        form_data.append('n', options.n);
        form_data.append('l', options.l);
        form_data.append('size', options.size);
        form_data.append('type', $( '.lqd-dall-e [name="type"]:checked' ).val() ?? 'dall-e');
        form_data.append('security', $( '.lqd-dall-e #security' ).val());

		$.ajax( {
			url: liquidTheme.uris.ajax,
			type: 'POST',
			contentType: false,
            processData: false,
			data: form_data,
			success: function ( data ) {
				wrapper.removeClass( 'loading' );
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
					images.append(data.output);
				}
			}
		} );
		e.preventDefault();
	} );

	// Tags
	$( document ).on( 'click', '.lqd-dall-e--tags .lqd-dall-e--tag', function ( e ) {
		$( '.lqd-dall-e--form #prompt' ).val( $( this ).attr( 'data-prompt' ) );
	} );

	// File input
	$('.lqd-dall-e--file input').change(function() {
		$('.lqd-dall-e--file').addClass('selected');
	});

	$('.lqd-dall-e--types label').click(function() {
        $('.lqd-dall-e--types label').removeClass('selected');
        $(this).addClass('selected');
    });

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