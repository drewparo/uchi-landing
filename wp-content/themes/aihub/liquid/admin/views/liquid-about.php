<main>

	<div class="lqd-dsd-wrap" style="padding-top:4%">

	<?php 

	wp_enqueue_script( 'merlin', get_template_directory_uri() . '/liquid/libs/merlin/assets/js/merlin.js', array( 'jquery-core' ) );

	$tgmpa = TGM_Plugin_Activation::get_instance();
	$plugins = array(
		'all'      => array(), // Meaning: all plugins which still have open actions.
		'install'  => array(),
		'update'   => array(),
		'activate' => array(),
	);

	$texts = array(
		'something_went_wrong' => esc_html__( 'Something went wrong. Please refresh the page and try again!', 'aihub' ),
	);

	// Localize the javascript.
	if ( class_exists( 'TGM_Plugin_Activation' ) ) {
		// Check first if TMGPA is included.
		wp_localize_script(
			'merlin', 'merlin_params', array(
				'tgm_plugin_nonce' => array(
					'update'  => wp_create_nonce( 'tgmpa-update' ),
					'install' => wp_create_nonce( 'tgmpa-install' ),
				),
				'tgm_bulk_url'     => $tgmpa->get_tgmpa_url(),
				'ajaxurl'          => admin_url( 'admin-ajax.php' ),
				'wpnonce'          => wp_create_nonce( 'merlin_nonce' ),
				'texts'            => $texts,
			)
		);
	} else {
		// If TMGPA is not included.
		wp_localize_script(
			'merlin', 'merlin_params', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'wpnonce' => wp_create_nonce( 'merlin_nonce' ),
				'texts'   => $texts,
			)
		);
	}

	foreach ( $tgmpa->plugins as $slug => $plugin ) {
		if ( $tgmpa->is_plugin_active( $slug ) && false === $tgmpa->does_plugin_have_update( $slug ) ) {
			continue;
		} else {
			$plugins['all'][ $slug ] = $plugin;
			if ( ! $tgmpa->is_plugin_installed( $slug ) ) {
					$plugins['install'][ $slug ] = $plugin;
			} else {
				if ( false !== $tgmpa->does_plugin_have_update( $slug ) ) {
					$plugins['update'][ $slug ] = $plugin;
				}
				if ( $tgmpa->can_plugin_activate( $slug ) ) {
					$plugins['activate'][ $slug ] = $plugin;
				}
			}
		}
	}

	$required_plugins = array();
	$list_plugins     = array( 'aihub-core' );
	//$tgmpa->is_plugin_active( 'elementor' ) ? array_push( $list_plugins, 'aihub-core' ) : '';

	// Split the plugins into required and recommended.
	foreach ( $plugins['all'] as $slug => $plugin ) {
		if ( ! empty( $plugin['required'] ) && in_array( $slug, $list_plugins ) ) {
			$required_plugins[ $slug ] = $plugin;
		}
	}

	$count = count( $required_plugins );
	
	?>
	<?php if ( $count ) : ?>
	<div class="lqd-about-plugins-wrap lqd-row" style="--lqd-about-bg: rgba(241, 196, 15, 1)">

		<div class="lqd-col lqd-col-6">
			<h5>One last action is needed to complete the update</h5>
			<p>Update all plugins to discover the latest features and improvements. </p>

			<div class="about-button-wrapper">
				<a href="#install-about" class="merlin__button merlin__button--next button-next" data-callback="install_plugins">
					<span class="merlin__button--loading__text">Update Plugins</span>
				</a>
				<?php if ( false === get_transient('lqd_about_update_escape') ) : ?>
				<a class="lqd-about-update-escape">Auto-update not working? Try updating manually.</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="lqd-col lqd-col-6">
			<form action="" method="post">
				<ul class="merlin__drawer--install-plugins">
				<?php if ( ! empty( $required_plugins ) ) : ?>
					<?php foreach ( $required_plugins as $slug => $plugin ) : ?>
						<li data-slug="<?php echo esc_attr( $slug ); ?>">
							<input type="checkbox" name="default_plugins[<?php echo esc_attr( $slug ); ?>]" class="checkbox" id="default_plugins_<?php echo esc_attr( $slug ); ?>" value="1" checked>

							<label for="default_plugins_<?php echo esc_attr( $slug ); ?>">
								<i></i>

								<span><?php echo esc_html( $plugin['name'] ); ?></span>

								<span class="badge">
									<span class="hint--top" aria-label="<?php esc_html_e( 'Required', 'aihub' ); ?>">
										<?php esc_html_e( 'Required', 'aihub' ); ?>
									</span>
								</span>
							</label>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
				</ul>
			</form>
		</div>

	</div>
	<?php endif; ?>

	<div class="lqd-about-plugins-wrap lqd-row" style="--lqd-about-bg: rgba(240, 10, 10, 0.35)">
		<div class="lqd-col lqd-col-12">
			<h5>v1.2 Update Notices</h5>
			<p>Version 1.2 is a major update in which we have made significant improvements and changes to some key options. As a result, certain options may no longer function as expected.</p>
			<p>To address this, please reset the following options if you had previously configured them:<br>
				→ Container dark options<br>
				→ Container sticky options
			</p>
		</div>
	</div>

	<?php if ( !liquid_helper()->system_requirements( true ) ) : ?>
	<div class="lqd-about-plugins-wrap lqd-row" style="--lqd-about-bg: rgba(255, 255, 255, 1)">
		<div class="lqd-col lqd-col-12">
			<h5>System</h5>
			<?php liquid_helper()->system_requirements_table(); ?>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="lqd-about-plugins-wrap lqd-row" style="--lqd-about-bg: rgba(255, 198, 0, 0.35)">
		<div class="lqd-col lqd-col-12">
			<h5>Clear your cache after update the theme!</h5>
			<p>Please make sure to clear your browser and server-side cache after the update is completed. Otherwise your website might look broken to you.</p>
		</div>
	</div>

	<!--
	<div class="lqd-row">
		<img src="<?php echo esc_url(get_template_directory_uri() . '/liquid/assets/img/dashboard/about/2-1.jpg'); ?>"  
			style="border-radius:18px" 
			alt="Hub"
		>
	</div>
	-->
	
	<div class="lqd-row lqd-about-iconbox-wrap">
		<div class="lqd-col-4 lqd-about-iconbox">
			<h4>Introducing AIHub</h4>
			<p>Meet the AIHub</p>
			<a href="https://staging-hub.liquid-themes.com/ai-landing/" target="_blank" class="merlin__button">
				<span>See Landing Page
				<svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;margin-left:.5em" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
				</svg>
				</span>
			</a>
		</div>
		
		<div class="lqd-col-4 lqd-about-iconbox">
			<h4>What's new?</h4>
			<p>See what's changed in this version</p>
			<a href="https://hub.liquid-themes.com/aihub-changelog/" target="_blank" class="merlin__button">
				<span>Changelog
				<svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;margin-left:.5em" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
				</svg>
				</span>
			</a>
		</div>
		
		<div class="lqd-col-4 lqd-about-iconbox">
			<h4>Up-to-date</h4>
			<p>Enjoy your Free updates!</p>
		</div>
		
	</div>

</main>

<script type="text/javascript">

	jQuery(".lqd-about-update-escape").on("click", function (e) {
		e.preventDefault();
		
		const link = e.target;
		var data = {
			'action': 'lqd_about_update_escape',
		};
	
		jQuery(".lqd-about-update-escape").text('Redirecting...');

		jQuery.post(ajaxurl, data, function (response) {
			window.location.href = '<?php echo esc_url(admin_url( 'plugins.php' )); ?>';
		});

	});
</script>
