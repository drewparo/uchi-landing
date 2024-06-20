window.addEventListener( 'elementor/init', () => {

	class LiquicParticlesControlView extends elementor.modules.controls.BaseData {

		ui() {
			const ui = super.ui();
			ui.particlesContainer = '#particles-container';
			return ui;
		}

		onReady() {
		}

		initParticles() {
		}

	};

	elementor.addControlView( 'liquid-particles', LiquicParticlesControlView );

} );