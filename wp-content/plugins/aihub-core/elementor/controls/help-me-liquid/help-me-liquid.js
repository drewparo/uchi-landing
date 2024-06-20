window.addEventListener( "elementor/init", () => {
	class LiquidHelpMeControlView extends elementor.modules.controls.Base {

		events() {
			return {
				'click @ui.button': 'onButtonClick',
			}
		}

		ui() {
			const ui = super.ui();
			ui.button = 'button';
			return ui;
		}

		initialize( options ) {
			super.initialize( options );
			const previewWindow = elementor.$preview[ 0 ].contentWindow;
			if ( previewWindow.liquid?.helpRequests && previewWindow.liquid?.helpRequests[ `element-${ this.container.id }:${ this.model.get( 'name' ) }` ]?.helpRequested ) {
				this.el.classList.add( 'modifiers-visible' );
			}
		}

		onButtonClick( ev ) {
			const button = ev.currentTarget;
			const isModifier = button.dataset.action;
			if ( !isModifier ) {
				this.el.classList.add( 'modifiers-visible' );
			}
			const previewWindow = elementor.$preview[ 0 ].contentWindow;
			previewWindow.liquid.helpRequests = previewWindow.liquid.helpRequests || {};
			previewWindow.liquid.helpRequests[ `element-${ this.container.id }:${ this.model.get( 'name' ) }` ] = previewWindow.liquid.helpRequests[ `element-${ this.container.id }:${ this.model.get( 'name' ) }` ] || {};
			previewWindow.liquid.helpRequests[ `element-${ this.container.id }:${ this.model.get( 'name' ) }` ][ 'helpRequested' ] = true;
			const eventName = this.model.get( 'event' );
			elementor.channels.editor.trigger( eventName.replace( '{{ELEMENT_ID}}', this.container.id ), this, ev );
		}

	}

	elementor.addControlView( "liquid-help-me", LiquidHelpMeControlView );
} );
