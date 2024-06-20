<?php

/**
* Default header
*
* @package Hub
*/

?>
<header class="lqd-site-header lqd-site-header-default relative z-99 text-16" id="lqd-page-header-wrap">

    <div id="lqd-page-header" data-lqd-view="liquidPageHeader">
        <div class="e-con flex justify-between pt-30 pb-30 ps-30 pe-30">
            <div class="flex items-center gap-30">
                <div class="elementor-widget shrink-0">
                    <div class="elementr-widget-container">
                        <a class="lqd-logo flex relative" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <span class="lqd-logo-inner">
                                <img class="lqd-logo-default" src="<?php liquid_logo_url(); ?>" alt="<?php echo bloginfo( 'name' ) ?>" />
                            </span>
                        </a>
                    </div>
                </div>
            </div>
			<div class="flex gap-30 justify-end">
                <nav class="elementor-widget elementor-widget-lqd-menu" id="lqd-menu-default" data-lqd-menu-dropdown-position-applied="true">
					<div class="elementor-widget-container">
						<button class="lqd-trigger lqd-togglable-trigger items-center bg-transparent border-none p-0 hidden tablet:inline-flex">
							<span class="lqd-trigger-bars-shape flex items-center justify-center relative pointer-events-none w-34px h-34px">
								<span class="flex flex-col relative">
									<span class="lqd-trigger-bar lqd-trigger-bar-close lqd-trigger-bar-close-1 absolute top-0 start-0 transition-transform bg-current"></span>
									<span class="lqd-trigger-bar lqd-trigger-bar-close lqd-trigger-bar-close-2 absolute top-0 start-0 transition-transform bg-current"></span>
									<span class="lqd-trigger-bar lqd-trigger-bar-1 lqd-trigger-bar-open transition-transform origin-right bg-current"></span>
									<span class="lqd-trigger-bar lqd-trigger-bar-2 lqd-trigger-bar-open transition-transform origin-right bg-current"></span>
								</span>
							</span>
							<span class="lqd-trigger-text inline-flex overflow-hidden whitespace-nowrap pointer-events-none transition-all"><?php
								echo __( 'Menu', 'aihub' )
							?></span>
						</button>
						<div class="lqd-menu-wrap [&.lqd-is-active:flex] grow tablet:hidden"><?php

							if( has_nav_menu( 'primary' ) ) {

								wp_nav_menu( array(
									'theme_location' => 'primary',
									'container'      => 'ul',
									'before'         => false,
									'after'          => false,
									'link_before'    => '',
									'link_after'     => '',
									'menu_id'        => 'primary-nav',
									'menu_class'     => 'lqd-menu-ul lqd-menu-ul-top lqd-menu-ul-default flex items-center grow list-none transition-colors',
									'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
									'walker'         => class_exists( 'Liquid_Menu_Walker' ) ? new Liquid_Menu_Walker : '',
								) );

							} elseif ( wp_get_nav_menu_object('all-pages') ) {

								wp_nav_menu( array(
									'menu'           => 'all-pages',
									'container'      => 'ul',
									'before'         => false,
									'after'          => false,
									'link_before'    => '',
									'link_after'     => '',
									'menu_id'        => 'primary-nav',
									'menu_class'     => 'lqd-menu-ul lqd-menu-ul-top lqd-menu-ul-default flex items-center grow list-none transition-colors',
									'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
									'walker'         => class_exists( 'Liquid_Menu_Walker' ) ? new Liquid_Menu_Walker : '',
								) );

							} else {
								wp_page_menu( array(
									'container'   => 'ul',
									'before'      => false,
									'after'       => false,
									'link_before' => '',
									'link_after'  => '',
									'menu_id'     => 'primary-nav',
									'menu_class'  => 'lqd-menu-ul lqd-menu-ul-top lqd-menu-ul-default flex items-center grow list-none transition-colors',
									'depth'       => 3
								) );

							}

						?></div>
					</div>
				</nav>
				<div class="elementor-widget elementor-widget-lqd-search lqd-search-style-slide flex" id="lqd-search-default">
					<div class="elementor-widget-container flex">
						<button class="lqd-trigger lqd-togglable-trigger items-center bg-transparent border-none p-0 flex">
							<span class="lqd-trigger-bars-shape flex items-center justify-center relative pointer-events-none">
								<span class="flex flex-col relative">
									<span class="lqd-trigger-bar lqd-trigger-bar-close lqd-trigger-bar-close-1 absolute top-0 start-0 transition-transform"></span>
									<span class="lqd-trigger-bar lqd-trigger-bar-close lqd-trigger-bar-close-2 absolute top-0 start-0 transition-transform"></span>
									<span class="lqd-trigger-bar lqd-trigger-bar-open transition-transform origin-right invisible"></span>
									<span class="lqd-trigger-icon inline-flex items-center justify-center w-full h-full absolute top-0 start-0 transition-all">
										<svg class="lqd-akar-icon w-1em text-percent-150" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> <path d="M21 21l-4.486-4.494M19 10.5a8.5 8.5 0 1 1-17 0 8.5 8.5 0 0 1 17 0z"></path> </svg>
									</span>
								</span>
							</span>
						</button>
						<div class="lqd-dropdown lqd-search-dropdown lqd-togglable-element w-full flex-col overflow-hidden backface-hidden [&.lqd-is-active:flex] h-full fixed top-0 start-0 end-0 hidden" style="--lqd-search-dropdown-bs: 0 5px 33px rgb(0 0 0 / 10%)">
							<div class="lqd-search-container flex flex-col justify-center h-full mx-auto backface-hidden">
								<form class="lqd-search-form w-full relative leading-none" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>">
									<input class="lqd-search-input w-full transition-colors" type="search" placeholder="<?php echo esc_attr_x( 'Start searching', 'placeholder', 'aihub' ) ?>" value="" name="s">
									<span class="lqd-input-icon inline-block absolute top-1/2 lqd-transform -translate-y-1/2 end-0">
										<button class="lqd-trigger lqd-togglable-trigger items-center bg-transparent border-none p-0 flex justify-center rounded-full w-50px h-50px relative lqd-has-before lqd-before:bg-current lqd-before:inline-block lqd-before:w-full lqd-before:h-full lqd-before:absolute lqd-before:top-0 lqd-before:start-0 lqd-before:rounded-inherit lqd-before:opacity-5" data-lqd-before-content="asda">
											<span class="lqd-trigger-bars-shape flex items-center justify-center relative pointer-events-none">
												<span class="flex flex-col relative w-full h-full">
													<span class="lqd-trigger-bar lqd-trigger-bar-close lqd-trigger-bar-close-1 absolute top-0 start-0 transition-transform bg-current"></span>
													<span class="lqd-trigger-bar lqd-trigger-bar-close lqd-trigger-bar-close-2 absolute top-0 start-0 transition-transform bg-current"></span>
													<span class="lqd-trigger-bar lqd-trigger-bar-open transition-transform origin-right invisible"></span>
													<span class="lqd-trigger-icon inline-flex items-center justify-center w-full h-full absolute top-0 start-0 transition-all">
														<svg class="lqd-akar-icon w-1em" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> <path d="M21 21l-4.486-4.494M19 10.5a8.5 8.5 0 1 1-17 0 8.5 8.5 0 0 1 17 0z"></path> </svg>
													</span>
												</span>
											</span>
										</button>
									</span>
									<input type="hidden" name="post_type" value="post">
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>

</header>