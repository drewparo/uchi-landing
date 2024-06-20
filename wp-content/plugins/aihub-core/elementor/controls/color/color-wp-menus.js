window.addEventListener( 'DOMContentLoaded', ( event ) => {

	let wrap = null;

	document.querySelectorAll( '.lqd-colorpicker' ).forEach( cp => {
		const input = cp.querySelector( '.lqd-colorpicker-val' );
		const val = input.value;
		if ( val !== '' ) {
			cp.querySelector( '.lqd-colorpicker-trigger-span' ).style.background = val;
		}
	} )

	jQuery( 'body' ).on( 'click', '.lqd-colorpicker-trigger', event => {
		event.preventDefault();
		const trigger = event.currentTarget;
		wrap = trigger.closest( '.lqd-colorpicker' );
		const input = wrap.querySelector( '.lqd-colorpicker-val' );
		const triggerSpan = trigger.querySelector( 'span' );
		let type = wrap.getAttribute( 'data-type' );

		if ( type !== 'all' ) {
			type = type.split( ',' ).map( t => t.trim() );
		}

		const options = {
			container: wrap.querySelector( '.lqd-colorpicker-wrap' ),
			types: type,
			gradient: '',
			colorpicker: {
				color: input.value || ''
			},
		};
		const currentValue = input.value;

		if ( currentValue.includes( 'gradient' ) ) {
			options[ 'gradient' ] = currentValue;
		} else if ( currentValue !== '' ) {
			options[ 'colorpicker' ][ 'color' ] = currentValue;
		}

		triggerSpan.style.background = currentValue;

		if ( !wrap.classList.contains( 'initiated' ) ) {
			new EasyLogicColorPicker.GradientPicker( {
				...options,
				onChange: color => {
					input.value = color;
					triggerSpan.style.background = color;
				},
			} );
			wrap.classList.add( 'initiated' );
			wrap.classList.add( 'colorpicker-showing' );
		} else {
			wrap.classList.toggle( 'colorpicker-showing' );
			wrap.querySelector( '.el-gradientpicker' ).style.display = !wrap.classList.contains( 'colorpicker-showing' ) ? 'none' : 'block';
		}

	} );

	jQuery( document ).on( 'click.lqdColorPicker', ev => {
		if ( !wrap || !wrap.classList.contains( 'initiated' ) || !wrap.classList.contains( 'colorpicker-showing' ) ) return;
		const { target } = ev;
		const clickedOutside = !wrap.querySelector( '.lqd-colorpicker-wrap' ).contains( target ) && !target.parentElement?.classList?.contains( 'step' );
		if ( !clickedOutside ) return;
		wrap.classList.remove( 'colorpicker-showing' );
		wrap.querySelector( '.el-gradientpicker' ).style.display = 'none';
		wrap = null;
	} );

} );
