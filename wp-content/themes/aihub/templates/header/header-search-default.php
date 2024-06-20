<?php
	$search_id = uniqid( 'search-' );
	$icon = '';
	if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ){
		$icon = isset($icon_render) ? $icon_render : $icon;
	}

	if ( !isset($search_type) ){
		if( class_exists( 'WooCommerce' ) ) $search_type = "product"; else $search_type = "post";
	}
?>
<div class="lqd-module-search lqd-module-search-default flex items-center relative">

	<span class="lqd-module-trigger">
		<span class="lqd-module-trigger-txt"></span>
        <span class="lqd-module-trigger-icon">
            <i class="<?php echo esc_attr( $icon ) ?>"></i>
        </span>
	</span>

	<div role="search" class="lqd-module-dropdown absolute" id="<?php echo esc_attr( $search_id ) ?>" aria-expanded="false">
		<div class="lqd-search-form-container">
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" class="lqd-search-form relative">
				<input class="w-full" type="search" placeholder="<?php echo esc_attr_x( 'Start searching', 'placeholder', 'aihub' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
				<span role="search" class="input-icon inline-block absolute" aria-expanded="false">
                    <svg class="w-1em h-1em" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ai ai-Search"><path d="M21 21l-4.486-4.494M19 10.5a8.5 8.5 0 1 1-17 0 8.5 8.5 0 0 1 17 0z"/></svg>
                </span>
				<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_type  ); ?>" />
			</form>
		</div>
	</div>

</div>