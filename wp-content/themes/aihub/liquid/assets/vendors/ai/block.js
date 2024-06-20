const Hub_Block_Extended = function ( BlockEdit ) {
	return function ( props ) {
		if ( props.name !== 'core/paragraph' ) {
			return BlockEdit( props );
		}

		return [
			wp.element.createElement(
				wp.blockEditor.BlockControls,
				null,
				wp.element.createElement(
					wp.components.ToolbarButton,
					{
						icon: 'hub-logo',
						label: 'Liquid AI',
						onClick: function () {
							jQuery.confirm( {
								columnClass: 'lqd-updates',
								//type: 'dark',
								title: 'Liquid AI <div id="liquid-ai-modal-ripple" class="lds-ripple" style="position:relative;left:10px;top:-6px"><div></div><div></div></div>',
								content: `
										<p>Explain to Liquid AI what you want to do. Keep it short.</p>
										<input id="liquid-ai-gutenberg-prompt" style="width:99%;padding:1em;border-color:99%" placeholder="Enter prompt..." type="text" required />
										<p>Examples:</p>
										<div class="liquid-ai-examples">
										<span>summarize</span>
										<span>translate to Spanish</span>
										<span>fix the grammer</span>
										<span>make more creative</span>
										</div>`,
								closeIcon: true,
								closeIconClass: 'dashicons dashicons-no',
								buttons: {
									new: {
										btnClass: 'btn-blue',
										text: 'Confirm →',
										action: function () {
											var $modal = this;
											jQuery( '#liquid-ai-modal-ripple' ).css( 'display', 'inline' );
											jQuery.post( ajaxurl, { action: 'liquid_ai_gutenberg', data: { prompt: jQuery( '#liquid-ai-gutenberg-prompt' ).val(), content: props.attributes.content, clientId: props.clientId } }, function ( response ) {
												if ( response.error ) {
													alert( response.message );
												} else {
													wp.data.dispatch( 'core/block-editor' ).updateBlockAttributes( props.clientId, { content: response.output } );
													$modal.close();
													add_log( response.total_tokens );
												}
											} );
											// prevent the modal from closing
											return false;
										}
									},
								}
							} );
							//console.log(props);
						}
					}
				)
			),
			BlockEdit( props )
		];
	};

}
wp.hooks.addFilter( 'editor.BlockEdit', 'ai-hub', Hub_Block_Extended );