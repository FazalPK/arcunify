<?php
/**
 * JSON-LD structured data: Organization (home), FAQPage (contact), BreadcrumbList (inner pages).
 * Toggle: Customize → ArcUnify → Advanced. Untick if an SEO plugin already outputs Organization.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * Print JSON-LD.
 */
function arcunify_print_schema() {
	if ( ! arcunify_mod( 'output_schema' ) || is_admin() ) {
		return;
	}
	$graph = array();

	if ( is_front_page() ) {
		$org = array(
			'@type' => 'Organization',
			'@id'   => home_url( '/#organization' ),
			'name'  => get_bloginfo( 'name' ),
			'url'   => home_url( '/' ),
		);
		$logo = get_theme_mod( 'custom_logo' );
		if ( $logo ) {
			$org['logo'] = wp_get_attachment_image_url( $logo, 'full' );
		}
		if ( arcunify_mod( 'email' ) ) {
			$org['email'] = arcunify_mod( 'email' );
		}
		if ( arcunify_mod( 'phone' ) ) {
			$org['telephone'] = arcunify_mod( 'phone' );
		}
		if ( arcunify_mod( 'address' ) ) {
			$org['address'] = array(
				'@type'         => 'PostalAddress',
				'streetAddress' => arcunify_mod( 'address' ),
			);
		}
		$same = array_values( array_map( static function ( $s ) { return $s[0]; }, arcunify_social_links() ) );
		if ( $same ) {
			$org['sameAs'] = $same;
		}
		$graph[] = $org;
	}

	if ( is_singular( 'page' ) && ! is_front_page() ) {
		$items   = array(
			array( '@type' => 'ListItem', 'position' => 1, 'name' => __( 'Home', 'arcunify' ), 'item' => home_url( '/' ) ),
		);
		$pos     = 2;
		foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $ancestor ) {
			$items[] = array( '@type' => 'ListItem', 'position' => $pos++, 'name' => get_the_title( $ancestor ), 'item' => get_permalink( $ancestor ) );
		}
		$items[] = array( '@type' => 'ListItem', 'position' => $pos, 'name' => get_the_title(), 'item' => get_permalink() );
		$graph[] = array(
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $items,
		);

		if ( 'page-templates/contact.php' === arcunify_native_template_for( get_the_ID() ) ) {
			$faq = array();
			foreach ( arcunify_page_content()['contact']['faq'] as $qa ) {
				$faq[] = array(
					'@type'          => 'Question',
					'name'           => $qa[0],
					'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $qa[1] ),
				);
			}
			$graph[] = array( '@type' => 'FAQPage', 'mainEntity' => $faq );
		}
	}

	if ( $graph ) {
		echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
	}
}
add_action( 'wp_head', 'arcunify_print_schema', 30 );
