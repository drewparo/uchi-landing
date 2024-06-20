<?php
/**
 * The template for displaying the header
 *
 * @package Hub theme
 */

?><!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?>>
<head <?php liquid_helper()->attr( 'head' ); ?>>

	<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ) ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?> <?php liquid_helper()->attr( 'body' ); ?>>

    <script>
        let initPageColorScheme = '<?php echo liquid_helper()->get_kit_option( 'lqd_init_color_scheme' ) ?>';
        if ( initPageColorScheme === 'system' ) {
            initPageColorScheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
                const color = event.matches ? 'dark' : 'light';
                document.body.setAttribute('data-lqd-page-color-scheme', color);
                localStorage.setItem('lqd-page-color-scheme', color)
            });
        }
        const liquidPageColorScheme = localStorage.getItem('lqd-page-color-scheme');
        const liquidTouchMM = window.matchMedia( "(pointer: coarse)" );
        if ( initPageColorScheme === '' || initPageColorScheme === 'none' ) {
            document.body.setAttribute('data-lqd-page-color-scheme', '');
        } else {
            if ( liquidPageColorScheme ) {
                document.body.setAttribute('data-lqd-page-color-scheme', liquidPageColorScheme);
            } else if ( initPageColorScheme && initPageColorScheme !== '' ) {
                document.body.setAttribute('data-lqd-page-color-scheme', initPageColorScheme);
            };
        }
        function liquidCheckTouch() {
            if ( liquidTouchMM.matches ) {
                document.body.classList.remove('lqd-no-touch');
                document.body.classList.add('lqd-is-touch');
            } else {
                document.body.classList.remove('lqd-is-touch');
                document.body.classList.add('lqd-no-touch');
            }
        }
        liquidTouchMM.addEventListener( 'change', liquidCheckTouch );
        liquidCheckTouch();
    </script>

	<?php
		if (function_exists('wp_body_open')) {
			wp_body_open();
		}
	?>

	<?php liquid_action( 'before' ) ?>

    <div id="lqd-wrap" class="relative overflow-hidden">

        <?php
            liquid_action( 'before_header' );
            liquid_action( 'header' );
            liquid_action( 'after_header' );
        ?>

        <main <?php liquid_helper()->attr( 'content' ); ?>>

            <?php liquid_action( 'before_contents_wrap' ); ?>

            <div <?php liquid_helper()->attr( 'contents_wrap' ); ?>>

            <?php liquid_action( 'before_content' ); ?>
