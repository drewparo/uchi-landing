<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the main containers
 *
 * @package Hub theme
 */
?>

		<?php liquid_action( 'after_content' ); ?>
		</div>
		<?php liquid_action( 'after_contents_wrap' ); ?>
	</main>
	<?php
	liquid_action( 'before_footer' );
	liquid_action( 'footer' );
	liquid_action( 'after_footer' );
	?>

    </div><!-- /#lqd-wrap -->

	<?php liquid_action( 'after' ) ?>

	<?php wp_footer(); ?>

    <svg class="hidden">
        <defs>
			<g id="lqd-loading-spinner">
				<path d="M22 12c0 6-4.39 10-9.806 10C7.792 22 4.24 19.665 3 16"/><path d="M2 12C2 6 6.39 2 11.806 2 16.209 2 19.76 4.335 21 8"/><path d="M7 17l-4-1-1 4"/><path d="M17 7l4 1 1-4"/>
			</g>
			<g id="lqd-icon-check">
				<path d="M4 12l6 6L20 6"/>
			</g>
			<g id="lqd-icon-chevron-left">
				<path d="M15 4l-8 8 8 8"/>
			</g>
			<g id="lqd-icon-chevron-right">
				<path d="M8 4l8 8-8 8"/>
			</g>
			<g id="lqd-icon-chevron-up">
				<path d="M4 15l8-8 8 8"/>
			</g>
			<g id="lqd-icon-chevron-down">
				<path d="M4 9l8 8 8-8"/>
			</g>
        </defs>
    </svg>

</body>
</html>