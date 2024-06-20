jQuery( document ).ready( function ( $ ) {

	var subscribeForm = $( '.lqd-newsletter-form' );

	subscribeForm.each( function () {

		var sf = $( this );
		var response = sf.siblings( '.lqd-newsletter--response' );
		var messageTimeout = null;

		sf.on( 'submit', function ( e ) {

			var email = jQuery( ".lqd-newsletter-form-input[type=email]", sf );
			var emailVal = email.val();

			if ( emailVal == "" ) {
				email.focus();
				return false;
			}

			sf.addClass( 'form-submitting' );

			$.ajax( {
				type: 'POST',
				url: liquidTheme.uris.ajax,
				data: {
					'action': 'add_mailchimp_user',
					'list_id': $( '.lqd-newsletter-form--list-id', sf ).val(),
					'email': $( '.lqd-newsletter-form-input[type=email]', sf ).val(),
					'tags': $( '.lqd-newsletter-form--tags', sf ).val(),
					'security': $( '#security', sf ).val(),
				},
				complete: function ( jqXHR, status ) {
					response.removeClass( 'hidden' );
					sf.removeClass( 'form-submitting' );
					response.html( jqXHR.responseText );
					messageTimeout = setTimeout( () => {
						response.addClass( 'hidden' );
						response.html( '' );
						messageTimeout && clearTimeout( messageTimeout );
					}, 7000 )
				},
				error: function ( jqXHR, textStatus, errorThrown ) {
					console.log( jqXHR.status );
				}
			} );

			e.preventDefault();

		} );

	} );

} );