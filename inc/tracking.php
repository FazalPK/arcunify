<?php
/**
 * Google Tag Manager, preserved from the current site (GTM-KRNHXWK2).
 * Set or clear the ID in Customize → ArcUnify → Advanced.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * @return string Valid container ID or ''.
 */
function arcunify_gtm_id() {
	$id = strtoupper( trim( (string) arcunify_mod( 'gtm_id' ) ) );
	return preg_match( '/^GTM-[A-Z0-9]+$/', $id ) ? $id : '';
}

/**
 * Head snippet.
 */
function arcunify_gtm_head() {
	$id = arcunify_gtm_id();
	if ( ! $id ) {
		return;
	}
	?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','<?php echo esc_js( $id ); ?>');</script>
<!-- End Google Tag Manager -->
	<?php
}
add_action( 'wp_head', 'arcunify_gtm_head', 1 );

/**
 * Body noscript fallback.
 */
function arcunify_gtm_body() {
	$id = arcunify_gtm_id();
	if ( ! $id ) {
		return;
	}
	printf(
		'<noscript><iframe src="%s" height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager"></iframe></noscript>' . "\n",
		esc_url( 'https://www.googletagmanager.com/ns.html?id=' . $id )
	);
}
add_action( 'wp_body_open', 'arcunify_gtm_body', 1 );
