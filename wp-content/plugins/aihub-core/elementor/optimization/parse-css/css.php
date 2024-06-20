<?php

$css_directions = [
	't' => 'top',
	'e' => 'inline-end',
	'b' => 'bottom',
	's' => 'inline-start',
];

$preset_css = [

	// controls - adding here to be able to overwrite with other utilities
	'.lqd-bg-layer' => 'padding-top:var(--lqd-bg-layer-pt)',

	// flex
	'.flex' => 'display:flex',
	'.inline-flex' => 'display:inline-flex',
	'.flex-wrap' => 'flex-wrap:wrap',
	'.flex-row' => 'flex-direction:row',
	'.flex-row-reverse' => 'flex-direction:row-reverse',
	'.flex-col' => 'flex-direction:column',
	'.flex-col-reverse' => 'flex-direction:column-reverse',
	'.shrink-0' => 'flex-shrink:0',
	'.shrink' => 'flex-shrink:1',
	'.grow-0' => 'flex-grow:0',
	'.grow' => 'flex-grow:1',
	'.basis-auto' => 'flex-basis:auto',
	'.basis-0' => 'flex-basis:0',

	'.mobile\:flex' => 'display:flex',
	'.mobile-extra\:flex' => 'display:flex',
	'.tablet\:flex' => 'display:flex',
	'.tablet-extra\:flex' => 'display:flex',
	'.mobile\:inline-flex' => 'display:inline-flex',
	'.mobile-extra\:inline-flex' => 'display:inline-flex',
	'.tablet\:inline-flex' => 'display:inline-flex',
	'.tablet-extra\:inline-flex' => 'display:inline-flex',

	// grid
	'.grid' => 'display:grid',
	'.inline-grid' => 'display:inline-grid',
	'.grid-area-1-1' => 'grid-area:1/1',
	'.grid-col-start' => 'grid-column-start:1',
	'.grid-row-start' => 'grid-row-start:1',
	'.place-content-center' => 'place-content:center',
	'.grid-span-full' => 'grid-column:1/-1',
	'.grid-flow-row' => 'grid-auto-flow:row',
	'.grid-flow-col' => 'grid-auto-flow:column',
	'.auto-cols-min' => 'grid-auto-columns:min-content',
	'.auto-cols-max' => 'grid-auto-columns:max-content',

	// block
	'.block' => 'display:block',
	'.inline-block' => 'display:inline-block',
	'.inline' => 'display:inline',

	'.mobile\:block' => 'display:block',
	'.mobile-extra\:block' => 'display:block',
	'.tablet\:block' => 'display:block',
	'.tablet-extra\:block' => 'display:block',
	'.mobile\:inline-block' => 'display:inline-block',
	'.mobile-extra\:inline-block' => 'display:inline-block',
	'.tablet\:inline-block' => 'display:inline-block',
	'.tablet-extra\:inline-block' => 'display:inline-block',

	// hidden
	'.hidden' => 'display:none',
	'.hidden-if-empty:empty' => 'display:none!important',

	'.mobile\:hidden' => 'display:none',
	'.mobile-extra\:hidden' => 'display:none',
	'.tablet\:hidden' => 'display:none',
	'.tablet-extra\:hidden' => 'display:none',

	// width
	'.w-full' => 'width:100%',
	'.w-screen' => 'width:100vw',
	'.w-0' => 'width:0',
	'.w-px' => 'width:1px',
	'.w-1em' => 'width:1em',
	'.w-auto' => 'width:auto',
	'.w-min' => 'width:min-content',
	'.w-max' => 'width:max-content',
	'.w-fit' => 'width:fit-content',

	// height
	'.h-full' => 'height:100%',
	'.\!h-full' => 'height:100%!important',
	'.h-screen' => 'height:100vh',
	'.h-0' => 'height:0',
	'.h-px' => 'height:1px',
	'.h-1em' => 'height:1em',
	'.h-auto' => 'height:auto',

	// max-min width
	'.min-w-full' => 'min-width:100%',
	'.max-w-none' => 'max-width:none',
	'.max-w-full' => 'max-width:100%',
	'.max-w-1em' => 'max-width:1em',

	// max-min height
	'.min-h-full' => 'min-height:100%',
	'.max-h-none' => 'max-height:none',
	'.max-h-full' => 'max-height:100%',
	'.max-h-1em' => 'max-height:1em',

	// margin
	'.m-0' => 'margin:0',
	'.mt-0' => 'margin-top:0',
	'.mt-auto' => 'margin-top:auto',
	'.mb-0' => 'margin-bottom:0',
	'.ms-auto' => 'margin-inline-start:auto',
	'.me-auto' => 'margin-inline-end:auto',

	// padding
	'.p-0' => 'padding:0',
	'.pt-0' => 'padding-top:0',
	'.pb-0' => 'padding-bottom:0',

	// position
	'.absolute' => 'position:absolute',
	'.relative' => 'position:relative',
	'.fixed' => 'position:fixed',
	'.top-0' => 'top:0',
	'.top-1\/2' => 'top:50%',
	'.top-full' => 'top:100%',
	'.bottom-0' => 'bottom:0',
	'.bottom-1\/2' => 'bottom:50%',
	'.bottom-full' => 'bottom:100%',
	'.start-0' => 'inset-inline-start:0',
	'.start-1\/2' => 'inset-inline-start:50%',
	'.start-full' => 'inset-inline-start:100%',
	'.end-0' => 'inset-inline-end:0',
	'.end-1\/2' => 'inset-inline-end:50%',
	'.end-full' => 'inset-inline-end:100%',

	// border radius
	'.rounded-inherit' => 'border-radius:inherit',
	'.\!rounded-inherit' => 'border-radius:inherit!important',
	'.rounded-full' => 'border-radius:10em',
	'.\!rounded-full' => 'border-radius:10em!important',

	// aspect ratio
	'.aspect-square' => 'aspect-ratio:1/1',

	// lists
	'.list-none' => 'list-style-type:none',

	// backgrounds
	'.bg-primary' => 'background:var(--lqd-color-primary, var(--e-global-color-primary))',
	'.bg-secondary' => 'background:var(--lqd-color-secondary, var(--e-global-color-secondary))',
	'.bg-white' => 'background:#fff',
	'.bg-black' => 'background:#000',
	'.bg-current' => 'background:currentColor',
	'.bg-none' => 'background:none',
	'.bg-inherit' => 'background:inherit',

	// fill
	'.fill-none' => 'fill:none',
	'.fill-inherit' => 'fill:inherit',
	'.fill-current' => 'fill:currentColor',

	// vertical align
	'.align-middle' => 'vertical-align:middle',

	// pointer events
	'.pointer-events-none' => 'pointer-events:none',
	'.pointer-events-auto' => 'pointer-events:auto',

	// user select
	'.user-select-none' => 'user-select:none',

	// overflow
	'.overflow-hidden' => 'overflow:hidden',
	'.overflow-x-hidden' => 'overflow-x:hidden',
	'.overflow-y-hidden' => 'overflow-y:hidden',
	'.overflow-x-auto' => 'overflow-x:auto',
	'.overflow-y-auto' => 'overflow-y:auto',
	'.overflow-auto' => 'overflow:auto',
	'.overflow-visible' => 'overflow:visible',

	// visibility
	'.invisible' => 'visibility:hidden',

	// transform
	'.lqd-transform' => '--lqd-translate-x: 0; --lqd-translate-y: 0; --lqd-rotate: 0; --lqd-skew-x: 0; --lqd-skew-y: 0; --lqd-scale-x: 1; --lqd-scale-y: 1; transform: translate(var(--lqd-translate-x),var(--lqd-translate-y)) rotate(var(--lqd-rotate)) skewX(var(--lqd-skew-x)) skewY(var(--lqd-skew-y)) scaleX(var(--lqd-scale-x)) scaleY(var(--lqd-scale-y))',
	'.lqd-transform-3d' => '--lqd-translate-x: 0; --lqd-translate-y: 0; --lqd-translate-z: 0; --lqd-rotate: 0; --lqd-skew-x: 0; --lqd-skew-y: 0; --lqd-scale-x: 1; --lqd-scale-y: 1; transform: translate3d(var(--lqd-translate-x),var(--lqd-translate-y),var(--lqd-translate-z)) rotate(var(--lqd-rotate)) skewX(var(--lqd-skew-x)) skewY(var(--lqd-skew-y)) scaleX(var(--lqd-scale-x)) scaleY(var(--lqd-scale-y))',
	'.lqd-transform-perspective' => '--lqd-transform-perspective: 1200px; --lqd-translate-x: 0; --lqd-translate-y: 0; --lqd-translate-z: 0; --lqd-rotate: 0; --lqd-skew-x: 0; --lqd-skew-y: 0; --lqd-scale-x: 1; --lqd-scale-y: 1; transform: perspective(var(--lqd-transform-perspective)) translate3d(var(--lqd-translate-x),var(--lqd-translate-y),var(--lqd-translate-z)) rotate(var(--lqd-rotate)) skewX(var(--lqd-skew-x)) skewY(var(--lqd-skew-y)) scaleX(var(--lqd-scale-x)) scaleY(var(--lqd-scale-y))',
	'.flip' => '--lqd-scale-x: -1; --lqd-scale-y: -1',
	'.flip-x' => '--lqd-scale-x: -1',
	'.flip-y' => '--lqd-scale-y: -1',
	'.-translate-x-1\/2' => '--lqd-translate-x: -50%',
	'.translate-x-1\/2' => '--lqd-translate-x: 50%',
	'.-translate-x-full' => '--lqd-translate-x: -100%',
	'.translate-x-full' => '--lqd-translate-x: 100%',
	'.-translate-y-1\/2' => '--lqd-translate-y: -50%',
	'.translate-y-1\/2' => '--lqd-translate-y: 50%',
	'.-translate-y-full' => '--lqd-translate-y: -100%',
	'.translate-y-full' => '--lqd-translate-y: 100%',
	'.scale-x-0' => '--lqd-scale-x: 0',
	'.scale-x-50' => '--lqd-scale-x: 0.5',
	'.scale-x-100' => '--lqd-scale-x: 1',
	'.scale-y-0' => '--lqd-scale-y: 0',
	'.scale-y-50' => '--lqd-scale-y: 0.5',
	'.scale-y-100' => '--lqd-scale-y: 1',

	// perspective
	'.perspective' => 'perspective:1200px',

	// transform style
	'.transform-style-3d' => 'transform-style:preserve-3d',

	// transitions
	'.transition-all' => 'transition:all var(--lqd-transition-duration) var(--lqd-transition-timing-function);',
	'.transition-opacity' => 'transition:all var(--lqd-transition-duration) var(--lqd-transition-timing-function); transition-property:opacity,visibility',
	'.transition-colors' => 'transition:all var(--lqd-transition-duration) var(--lqd-transition-timing-function); transition-property:background,color,border,box-shadow,text-shadow,fill,stroke,border-radius',
	'.transition-transform' => 'transition:all var(--lqd-transition-duration) var(--lqd-transition-timing-function); transition-property:transform',
	'.transition-effects' => 'transition:all var(--lqd-transition-duration) var(--lqd-transition-timing-function); transition-property:transform,opacity,filter,background,color,border,box-shadow,text-shadow,fill,stroke,border-radius',
	'.transition-width' => 'transition:all var(--lqd-transition-duration) var(--lqd-transition-timing-function); transition-property:width',

	// text-transform
	'.uppercase' => 'text-transform:uppercase',
	'.lowecase' => 'text-transform:lowecase',
	'.capitalize' => 'text-transform:capitalize',

	// font-weight
	'.font-light' => 'font-weight:300',
	'.font-normal' => 'font-weight:400',
	'.font-medium' => 'font-weight:500',
	'.font-semibold' => 'font-weight:600',
	'.font-bold' => 'font-weight:700',

	// line height
	'.leading-none' => 'line-height:1',

	// text colors
	'.text-inherit' => 'color:inherit',
	'.text-primary' => 'color:var(--lqd-color-primary, var(--e-global-color-primary))',
	'.text-secondary' => 'color:var(--lqd-color-secondary, var(--e-global-color-secondary))',
	'.text-white' => 'color:#fff',
	'.text-black' => 'color:#000',

	// text decoration
	'.decoration-none' => 'text-decoration:none',

	// text indent
	'.-indent-full' => 'text-indent:-99999px',
	'.indent-full' => 'text-indent:99999px',

	// whitespace
	'.whitespace-nowrap' => 'white-space:nowrap',

	// object fit
	'.object-cover' => 'object-fit:cover',
	'.object-center' => 'object-position:center',

	// cursor
	'.cursor-pointer' => 'cursor:pointer',

	// input
	'.outline-none' => 'outline:none!important',

	// aspect ratio
	'.lqd-aspect-ratio-p' => 'padding-top:var(--lqd-aspect-ratio-p)',
	'.lqd-aspect-ratio' => 'aspect-ratio:var(--lqd-aspect-ratio)',

	// shadow
	'.shadow-sm' => 'box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05)',
	'.shadow' => 'box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.07)',
	'.shadow-md' => 'box-shadow: 0 4px 15px rgb(0 0 0 / 0.07)',
	'.shadow-lg' => 'box-shadow: 0 10px 33px rgb(0 0 0 / 0.07)',
	'.shadow-xl' => 'box-shadow: 0 20px 65px rgb(0 0 0 / 0.07)',
	'.shadow-2xl' => 'box-shadow: 0 25px 80px rgb(0 0 0 / 0.05)',
	'.shadow-none' => 'box-shadow: 0 0 #0000',

	/**
	 * TODO: improve this
	 */
	// groups
	'.lqd-group:hover .lqd-group-hover\:opacity-0' => 'opacity:0',
	'.lqd-group:hover .lqd-group-hover\:opacity-100' => 'opacity:1',
	'.lqd-group-btn:hover .lqd-group-btn-hover\:opacity-0' => 'opacity:0',
	'.lqd-group-btn:hover .lqd-group-btn-hover\:opacity-100' => 'opacity:1',
	'.lqd-group-box:hover .lqd-group-box-hover\:opacity-0' => 'opacity:0',
	'.lqd-group-box:hover .lqd-group-box-hover\:opacity-100' => 'opacity:1',
	'.lqd-group-carousel:hover .lqd-group-carousel-hover\:opacity-0' => 'opacity:0',
	'.lqd-group-carousel:hover .lqd-group-carousel-hover\:opacity-100' => 'opacity:1',

	'.lqd-widget-container-grid > .elementor-widget-container' => 'display:grid',

	'.lqd-widget-container-flex > .elementor-widget-container' => 'display:flex',
	'.lqd-widget-container-flex-wrap > .elementor-widget-container' => 'flex-wrap:wrap',
	'.lqd-widget-container-items-center > .elementor-widget-container' => 'align-items:center',

	// misc stuff
	'.lqd-bubble-arrow' => '--lqd-bubble-arrow-w:20px;--lqd-bubble-arrow-h:10px',
	'.lqd-bubble-arrow:after' => 'content: "" !important; display: inline-block; width: var(--lqd-bubble-arrow-w); height: var(--lqd-bubble-arrow-h); background:inherit; position: absolute; z-index: 1',
	'.lqd-bubble-arrow-top:after, .lqd-bubble-arrow-bottom:after' => 'inset-inline-start:calc(50% - (var(--lqd-bubble-arrow-w) / 2))',
	'.lqd-bubble-arrow-start:after, .lqd-bubble-arrow-end:after' => '--lqd-bubble-arrow-w:10px;--lqd-bubble-arrow-h:20px; top:calc(50% - (var(--lqd-bubble-arrow-h) / 2))',
	'.lqd-bubble-arrow-top:after' => 'top: calc((var(--lqd-bubble-arrow-h) - 1px) * -1); clip-path: polygon(50% 0, 0 100%, 100% 100%)',
	'.lqd-bubble-arrow-end:after' => 'inset-inline-end: calc((var(--lqd-bubble-arrow-w) - 1px) * -1); clip-path: polygon(0 0, 0 100%, 100% 50%)',
	'.lqd-bubble-arrow-bottom:after' => 'bottom: calc((var(--lqd-bubble-arrow-h) - 1px) * -1); clip-path: polygon(50% 100%, 0 0, 100% 0)',
	'.lqd-bubble-arrow-start:after' => 'inset-inline-start: calc((var(--lqd-bubble-arrow-w) - 1px) * -1); clip-path: polygon(100% 0, 100% 100%, 0 50%)',

	'.lqd-text-vertical' => 'writing-mode:vertical-lr;transform: rotate(180deg)',
	'.lqd-widget-container-text-vertical > .elementor-widget-container' => 'writing-mode:vertical-lr;transform: rotate(180deg)',

	// dark
	'[data-lqd-page-color-scheme=dark] .lqd-dark\:inline, [data-lqd-color-scheme=dark] .lqd-dark\:inline' => 'display:inline',
	'[data-lqd-page-color-scheme=dark] .lqd-dark\:block, [data-lqd-color-scheme=dark] .lqd-dark\:block' => 'display:block',
	'[data-lqd-page-color-scheme=dark] .lqd-dark\:inline-block, [data-lqd-color-scheme=dark] .lqd-dark\:inline-block' => 'display:inline-block',
	'[data-lqd-page-color-scheme=dark] .lqd-dark\:flex, [data-lqd-color-scheme=dark] .lqd-dark\:flex' => 'display:flex',
	'[data-lqd-page-color-scheme=dark] .lqd-dark\:inline-flex, [data-lqd-color-scheme=dark] .lqd-dark\:inline-flex' => 'display:inline-flex',
	'[data-lqd-page-color-scheme=dark] .lqd-dark\:hidden, [data-lqd-color-scheme=dark] .lqd-dark\:hidden' => 'display:none',

	// sticky
	'[data-lqd-container-is-sticky=true] .lqd-sticky\:inline' => 'display:inline',
	'[data-lqd-container-is-sticky=true] .lqd-sticky\:block' => 'display:block',
	'[data-lqd-container-is-sticky=true] .lqd-sticky\:inline-block' => 'display:inline-block',
	'[data-lqd-container-is-sticky=true] .lqd-sticky\:flex' => 'display:flex',
	'[data-lqd-container-is-sticky=true] .lqd-sticky\:inline-flex' => 'display:inline-flex',
	'[data-lqd-container-is-sticky=true] .lqd-sticky\:hidden' => 'display:none',
	// for inner containers
	'.e-child[data-lqd-hide-on-sticky=true], .e-child[data-lqd-show-on-sticky=true]' => 'transition:background var(--background-transition,.3s),border var(--border-transition,.3s),box-shadow var(--border-transition,.3s),transform var(--e-con-transform-transition-duration,.4s),opacity var(--e-con-opacity-transition-duration,.3s),visibility var(--e-con-visibility-transition-duration,.3s)',
	'.e-child[data-lqd-show-on-sticky=true], [data-lqd-container-is-sticky=true] .e-child[data-lqd-hide-on-sticky=true]' => 'opacity:0; visibility:hidden; pointer-events:none',
	'[data-lqd-container-is-sticky=true] .e-child[data-lqd-show-on-sticky=true]' => 'opacity:1; visibility:visible; pointer-events: auto',
];

$psuedo_css = [
	'flex' => 'display:flex',
	'inline-flex' => 'display:inline-flex',
	'block' => 'display:block',
	'inline-block' => 'display:inline-block',
	'flex' => 'display:flex',
	'w-full' => 'width:100%',
	'w-px' => 'width:1px',
	'h-full' => 'height:100%',
	'h-px' => 'height:1px',
	'absolute' => 'position:absolute',
	'relative' => 'position:relative',
	'top-0' => 'top:0',
	'top-1\/2' => 'top:50%',
	'top-full' => 'top:100%',
	'bottom-0' => 'bottom:0',
	'bottom-1\/2' => 'bottom:50%',
	'bottom-full' => 'bottom:100%',
	'start-0' => 'inset-inline-start:0',
	'start-1\/2' => 'inset-inline-start:50%',
	'start-full' => 'inset-inline-start:100%',
	'end-0' => 'inset-inline-end:0',
	'end-1\/2' => 'inset-inline-end:50%',
	'end-full' => 'inset-inline-end:100%',
	'rounded-inherit' => 'border-radius:inherit',
	'bg-current' => 'background:currentColor',
	'-translate-x-1\/2' => '--lqd-translate-x: -50%',
	'translate-x-1\/2' => '--lqd-translate-x: 50%',
	'-translate-x-full' => '--lqd-translate-x: -100%',
	'translate-x-full' => '--lqd-translate-x: 100%',
	'-translate-y-1\/2' => '--lqd-translate-y: -50%',
	'translate-y-1\/2' => '--lqd-translate-y: 50%',
	'-translate-y-full' => '--lqd-translate-y: -100%',
	'translate-y-full' => '--lqd-translate-y: 100%',
];

foreach ( [ 'before', 'after' ] as $psuedo ) {
	$preset_css['.lqd-has-' . $psuedo . ':' . $psuedo] = 'content: attr(data-lqd-' . $psuedo . '-content)';
	foreach ($psuedo_css as $css_prop => $css_val) {
		$preset_css[ '.lqd-' . $psuedo . '\:' . $css_prop . ':' . $psuedo] = $css_val;
	}
}

foreach ( [ 'start', 'center', 'end' ] as $align ) {
	$preset_css['.text-' . $align] = "text-align:$align";
	$preset_css['.items-' . $align] = "align-items:$align";
	$preset_css['.justify-' . $align] = "justify-content:$align";
	$preset_css['.align-self-' . $align] = "align-self:$align";
}
$preset_css['.align-self-stretch'] = "align-self:stretch";
$preset_css['.justify-between'] = "justify-content:space-between";

// columns: from 1 to 12. works with grid
for ( $i = 1; $i <= 12; $i += 1 ) {
	$preset_css[ '.columns-' . $i ] = "grid-template-columns:repeat($i" . ",1fr)";
	$preset_css[ '.mobile:columns-' . $i ] = "grid-template-columns:repeat($i" . ",1fr)";
	$preset_css[ '.mobile-extra:columns-' . $i ] = "grid-template-columns:repeat($i" . ",1fr)";
	$preset_css[ '.tablet:columns-' . $i ] = "grid-template-columns:repeat($i" . ",1fr)";
	$preset_css[ '.tablet-extra:columns-' . $i ] = "grid-template-columns:repeat($i" . ",1fr)";
}

// gap: gap-2 to gap-20
for ( $i = 2; $i <= 30; $i += 2 ) {
	$preset_css[ '.gap-' . $i ] = "gap:$i" . "px";
}

// width: w-1/12 to w-11/12
for ( $i = 1; $i <= 11; $i += 1 ) {
	$width = $i / 12 * 100;
	$preset_css[ '.w-' . $i . '\/12' ] = "width:$width%";
	$preset_css[ '.mobile:w-' . $i . '/12' ] = "width:$width%";
	$preset_css[ '.mobile-extra:w-' . $i . '/12' ] = "width:$width%";
	$preset_css[ '.tablet:w-' . $i . '/12' ] = "width:$width%";
	$preset_css[ '.tablet-extra:w-' . $i . '/12' ] = "width:$width%";

	if ( $i <= 5 ) {
		$preset_css[ '.w-' . $i . '\/5' ] = "width:$width%";
		$preset_css[ '.mobile:w-' . $i . '/5' ] = "width:$width%";
		$preset_css[ '.mobile-extra:w-' . $i . '/5' ] = "width:$width%";
		$preset_css[ '.tablet:w-' . $i . '/5' ] = "width:$width%";
		$preset_css[ '.tablet-extra:w-' . $i . '/5' ] = "width:$width%";
	}
}
$preset_css[ '.mobile:w-full' ] = "width:100%";
$preset_css[ '.mobile-extra:w-full' ] = "width:100%";
$preset_css[ '.tablet:w-full' ] = "width:100%";
$preset_css[ '.tablet-extra:w-full' ] = "width:100%";


// padding and margin: .[p|m[-t|e|b|s]]-2 to 64
// width and height: .[w|h]]-2 to 64
for ( $i = 2; $i <= 64; $i += 2 ) {
	$preset_css[ '.w-' . $i . 'px' ] = "width:$i" . "px";
	$preset_css[ '.h-' . $i . 'px' ] = "height:$i" . "px";
	foreach ( $css_directions as $dir => $css_dir) {
		$preset_css[ '.p' . $dir . '-' . $i ] = "padding-$css_dir:$i" . "px";
		$preset_css[ '.m' . $dir . '-' . $i ] = "margin-$css_dir:$i" . "px";
		$preset_css[ '.mobile:p' . $dir . '-' . $i ] = "padding-$css_dir:$i" . "px";
		$preset_css[ '.tablet:m' . $dir . '-' . $i ] = "margin-$css_dir:$i" . "px";
	}
}

// border-radius: .rounded-2 to rounded-24
for ( $i = 2; $i <= 24; $i += 2 ) {
	$preset_css[ '.rounded-' . $i ] = "border-radius:$i" . "px";
}

// order from -3 to 3
for ( $i = -3; $i <= 3; $i += 1 ) {
	$prefix = $i < 0 ? '-' : '';
	$classname = '.' . $prefix . 'order-' . abs($i);
	$preset_css[ $classname ] = "order:$i";
	$preset_css[ '.mobile:' . $classname ] = "order:$i";
	$preset_css[ '.tablet:' . $classname ] = "order:$i";
}

// z-index from -1 to 10
for ( $i = -1; $i <= 10; $i += 1 ) {
	$prefix = $i < 0 ? '-' : '';
	$preset_css[ '.' . $prefix . 'z-' . abs($i) ] = "z-index:$i";
}
$preset_css[ '.z-99' ] = "z-index:99";

// opacity from 0 to 1. classnames: opacity-0, opactiy-10, opacity-50 ...
for ( $i = 0; $i <= 100; $i += 5 ) {
	$opacity_val = 'opacity:' . $i / 100;
	$preset_css[ '.opacity-' . $i ] = $opacity_val;
	foreach ( [ 'before', 'after' ] as $psuedo ) {
		$preset_css[ '.lqd-' . $psuedo . '\:opacity-' . $i . ':' . $psuedo] = $opacity_val;
	}
}

// font-size: em from 0.3 to 1.5, 2 and 3
for ( $i = 30; $i <= 150; $i += 5 ) {
	$preset_css[ '.text-percent-' . $i ] = 'font-size:' . $i / 100 . 'em';
}
$preset_css[ '.text-percent-200' ] = 'font-size:2em';
$preset_css[ '.text-percent-300' ] = 'font-size:3em';

// font-size: px from 10 to 26
for ( $i = 10; $i <= 26; $i += 2 ) {
	$preset_css[ '.text-' . $i ] = 'font-size:' . $i . 'px';
}

// line-height: em from 1.05 to 2
for ( $i = 105; $i <= 200; $i += 5 ) {
	$preset_css[ '.leading-' . $i ] = 'line-height:' . ($i / 100) . 'em';
}

// letter-spacing: .tracking-50 - .tracking-100 ...
for ( $i = 50; $i <= 200; $i += 50 ) {
	$preset_css[ '.tracking-' . $i ] = 'letter-spacing:' . $i / 1000 . 'em';
}

// transform origins
$transform_origins = [
	'left', 'center', 'right',
	'left-top', 'center-top', 'right-top',
	'left-center', 'right-center',
	'left-bottom', 'center-bottom', 'right-bottom'
];
foreach ( $transform_origins as $origin ) {
	$preset_css[ '.origin-' . $origin ] = 'transform-origin:' . str_replace( '-', ' ', $origin );
}

$this->preset_css = $preset_css;