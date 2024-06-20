window.addEventListener( "elementor/init", () => {
	class LiquidColorControlView extends elementor.modules.controls.Color {

		isInit = false;
		pickerIsVisible = false;
		getCssVarFrom = null;

		ui() {
			const ui = super.ui();
			ui.pickerTrigger = ".liquid-color-picker-trigger";
			ui.pickerContainer = ".liquid-color-picker-placeholder";
			return ui;
		}

		applySavedValue() {

			const currentValue = this.getCurrentValue().trim();

			if ( this.colorpicker && currentValue ) {
				if ( currentValue.includes( 'gradient' ) ) {
					this.colorpicker.setColor( currentValue );
				} else {
					this.colorpicker.EmbedColorPicker.setColor( currentValue );
				}
				return;
			};

			this.initPicker();
			this.addTriggerHandler();
			this.setTriggerBg( this.getCurrentValue().trim() );
		}

		async initPicker() {

			const currentValue = this.getCurrentValue().trim();

			this.getCssVarFrom = window.elementor.$previewContents.find( 'body' )[ 0 ];

			const options = {
				container: this.ui.pickerContainer[ 0 ],
				types: this.model.get( 'types' ) || 'all',
				gradient: '',
				getCssVarFrom: this.getCssVarFrom,
				colorpicker: {
					color: 'var(--e-global-color-primary)',
					getCssVarFrom: this.getCssVarFrom,
				},
			};

			if ( currentValue.includes( 'gradient' ) ) {
				options[ 'gradient' ] = currentValue;
			} else if ( currentValue !== '' ) {
				options[ 'colorpicker' ][ 'color' ] = currentValue;
			}

			this.setTriggerBg( currentValue );

			const globalColors = await this.getGlobalsList();

			if ( globalColors && !_.isEmpty( globalColors ) ) {
				const swatch = [];
				_.mapObject( globalColors, ( { id, title, value } ) => {
					swatch.push( { title, color: `--e-global-color-${ id }` } );
				} );
				options[ 'colorpicker' ][ 'swatchTitle' ] = 'Global colors';
				options[ 'colorpicker' ][ 'swatchColors' ] = swatch;
			}

			this.colorpicker = new EasyLogicColorPicker.GradientPicker( {
				...options,
				onChange: color => {
					if ( !this.isInit ) return;
					this.setValue( color );
					this.setTriggerBg( color );
				},
				onInit: () => {
					_.defer( () => {
						this.isInit = true;
					} )
				}
			} );
		}

		addTriggerHandler() {
			this.ui.pickerTrigger.on( 'click', ev => {
				this.pickerIsVisible = !this.pickerIsVisible;
				this.ui.pickerContainer.toggleClass( 'lqd-picker-is-visible', this.pickerIsVisible );
				if ( this.pickerIsVisible ) {
					const timeout = setTimeout( () => {
						this.ui.pickerContainer.find( '.el-cp-color-field input[type=text]' ).focus();
						this.ui.pickerContainer.find( '.el-cp-color-field input[type=text]' ).select();
						timeout && clearTimeout( timeout );
					}, 25 )
				}
			} );
			jQuery( document ).on( 'click.lqdColorPicker', ev => {
				if ( !this.isInit || !this.pickerIsVisible ) return;
				const { target } = ev;
				const clickedOutside = !this.ui.pickerContainer.parent()[ 0 ].contains( target ) && !target.parentElement?.classList?.contains( 'step' );
				if ( !clickedOutside ) return;
				this.pickerIsVisible = false;
				this.ui.pickerContainer.removeClass( 'lqd-picker-is-visible' );
			} );
		}

		/**
		 *
		 * @param {string} color
		 */
		setTriggerBg( color ) {
			let clr = color;
			const cssVars = clr.match( /var\(--\b.*?\)/g );
			const getCssVarFrom = this.getCssVarFrom || window.elementor.$previewContents.find( 'body' )[ 0 ];
			if ( cssVars ) {
				cssVars.forEach( cssVar => {
					clr = clr.replace( cssVar, getComputedStyle( getCssVarFrom ).getPropertyValue( cssVar.replace( 'var(', '' ).replace( ')', '' ).trim() ) );
				} )
			}
			this.ui.pickerTrigger.css( '--lqd-background', clr );
			if ( clr === '' || !clr ) {
				this.ui.pickerTrigger.addClass( 'lqd-is-empty' );
			} else {
				this.ui.pickerTrigger.removeClass( 'lqd-is-empty' );
			}
		}

		onBeforeDestroy() {
			this.ui.pickerTrigger.off();
			jQuery( document ).off( 'click.lqdColorPicker' );
			super.onBeforeDestroy();
		}

	}

	elementor.addControlView( "liquid-color", LiquidColorControlView );
} );
