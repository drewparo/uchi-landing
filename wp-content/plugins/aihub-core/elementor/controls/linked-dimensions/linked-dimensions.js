window.addEventListener( "elementor/init", () => {
	class LiquidLinkedDimensions extends elementor.modules.controls.Dimensions {

		getPossibleDimensions() {
			return [
				'width',
				'height',
			];
		}

	}

	elementor.addControlView( "liquid-linked-dimensions", LiquidLinkedDimensions );
} );