<?php 
	
	$theme = liquid_helper()->get_current_theme();
	
?>
<nav class="lqd-dsd-menubard">

	<span class="lqd-dsd-logo">
		<img src="<?php echo get_template_directory_uri() . '/assets/img/logo/logo.svg'; ?>" alt="<?php echo esc_attr( $theme->name ); ?>">
		<?php printf( '<span class="lqd-v">%s</span>', $theme->version ); ?>
	</span>

	<ul class="lqd-dsd-menu">
		<li class="<?php echo liquid_helper()->active_tab( 'liquid' ); ?>">
			<a href="<?php echo liquid_helper()->dashboard_page_url(); ?>">
				<span><?php esc_html_e( 'Activation', 'aihub' ); ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo esc_url(admin_url( 'admin.php?page=liquid-setup' )); ?>">
				<span><?php esc_html_e( 'Setup Wizard', 'aihub' ); ?></span>
			</a>
		</li>
		<li>
			<a href="https://docs.liquid-themes.com/collection/573-ai-hub" target="_blank">
				<svg style="margin-right:8px" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="ai ai-Lifesaver"><g clip-path="url(#clip0_73_30)"><circle cx="12" cy="12" r="10" transform="rotate(45 12 12)"/><circle cx="12" cy="12" r="4" transform="rotate(45 12 12)"/><path d="M19.071 4.929l-4.243 4.243"/><path d="M9.172 14.828l-4.243 4.243"/><path d="M19.071 19.071l-4.243-4.243"/><path d="M9.172 9.172L4.929 4.929"/></g><defs><clipPath id="clip0_73_30"><rect width="24" height="24"/></clipPath></defs></svg>
				<span><?php esc_html_e( 'Documentations', 'aihub' ); ?></span>
			</a>
		</li>
	</ul>

</nav>
