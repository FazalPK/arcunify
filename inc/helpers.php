<?php
/**
 * Template helpers.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * Read a theme setting with its schema default.
 *
 * @param string $key Setting key without the au_ prefix.
 * @return mixed
 */
function arcunify_mod( $key ) {
	$schema  = arcunify_settings_schema();
	$default = isset( $schema[ $key ] ) ? $schema[ $key ][3] : '';
	return get_theme_mod( 'au_' . $key, $default );
}

/**
 * Resolve a stored link: site-relative paths become absolute site URLs.
 *
 * @param string $value Path (/contact-us/), anchor (#pricing) or absolute URL.
 * @return string Unescaped URL.
 */
function arcunify_url( $value ) {
	$value = (string) $value;
	if ( '' === $value ) {
		return '';
	}
	if ( 0 === strpos( $value, '#' ) ) {
		return $value;
	}
	if ( 0 === strpos( $value, '/' ) && 0 !== strpos( $value, '//' ) ) {
		return home_url( $value );
	}
	return $value;
}

/**
 * Service URL. Uses the real page permalink when the page exists, so a slug
 * changed in WP admin is followed automatically.
 *
 * @param array $service Service from arcunify_services().
 * @return string
 */
function arcunify_service_url( $service ) {
	$page = get_page_by_path( trim( $service['path'], '/' ) );
	return $page ? get_permalink( $page ) : home_url( $service['path'] );
}

/**
 * Inline SVG icon from the sprite printed in wp_body_open.
 *
 * @param string $name  Icon name (see assets/images/icons.svg).
 * @param string $class Extra classes.
 * @return string
 */
function arcunify_icon( $name, $class = '' ) {
	return sprintf(
		'<svg class="au-icon %1$s" aria-hidden="true" focusable="false"><use href="#i-%2$s"></use></svg>',
		esc_attr( $class ),
		esc_attr( $name )
	);
}

/**
 * Button markup.
 *
 * @param string $label   Visible label.
 * @param string $url     Link (path or absolute).
 * @param string $variant primary|ghost|link.
 * @param array  $extra   Optional: 'sr' screen-reader suffix, 'class', 'icon'.
 * @return string
 */
function arcunify_button( $label, $url, $variant = 'primary', $extra = array() ) {
	if ( '' === trim( (string) $label ) || '' === trim( (string) $url ) ) {
		return '';
	}
	$icon = isset( $extra['icon'] ) ? $extra['icon'] : 'arrow-right';
	$sr   = ! empty( $extra['sr'] ) ? '<span class="screen-reader-text"> ' . esc_html( $extra['sr'] ) . '</span>' : '';

	return sprintf(
		'<a class="au-btn au-btn--%1$s %2$s" href="%3$s"><span>%4$s</span>%5$s%6$s</a>',
		esc_attr( $variant ),
		esc_attr( isset( $extra['class'] ) ? $extra['class'] : '' ),
		esc_url( arcunify_url( $url ) ),
		esc_html( $label ),
		$sr,
		$icon ? arcunify_icon( $icon, 'au-btn__icon' ) : ''
	);
}

/**
 * Split a textarea setting into non-empty lines.
 *
 * @param string $text Text.
 * @return string[]
 */
function arcunify_lines( $text ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $text ) ) ) );
}

/**
 * Phone number as a tel: href.
 *
 * @param string $phone Display phone.
 * @return string
 */
function arcunify_tel( $phone ) {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', (string) $phone );
}

/**
 * Section header component.
 *
 * @param array $args kicker, title, lead, id (for the heading), tag, layout (stack|split).
 */
function arcunify_section_header( $args ) {
	get_template_part( 'template-parts/components/section-header', null, $args );
}

/**
 * Whether this request renders the native theme homepage.
 *
 * @return bool
 */
function arcunify_is_native_home() {
	return is_front_page() && 'page' !== arcunify_mod( 'home_source' );
}

/**
 * Social profiles that have a URL set.
 *
 * @return array name => [ url, icon ]
 */
function arcunify_social_links() {
	$networks = array(
		'linkedin'  => __( 'LinkedIn', 'arcunify' ),
		'facebook'  => __( 'Facebook', 'arcunify' ),
		'x'         => __( 'X', 'arcunify' ),
		'instagram' => __( 'Instagram', 'arcunify' ),
		'youtube'   => __( 'YouTube', 'arcunify' ),
	);
	$out = array();
	foreach ( $networks as $key => $label ) {
		$url = arcunify_mod( 'social_' . $key );
		if ( $url ) {
			$out[ $label ] = array( $url, 'social-' . $key );
		}
	}
	return $out;
}

/**
 * Escape a heading and keep service names from splitting across lines
 * (e.g. "Managed IT", "Unified Communications"). Copy is unchanged.
 *
 * @param string $text Heading text.
 * @return string Escaped HTML.
 */
function arcunify_keep_together( $text ) {
	$html  = esc_html( $text );
	$pairs = apply_filters( 'arcunify_keep_together', array( 'Managed IT' ) );
	foreach ( $pairs as $pair ) {
		$html = str_replace( esc_html( $pair ), str_replace( ' ', '&nbsp;', esc_html( $pair ) ), $html );
	}
	return $html;
}

/**
 * Image from the site's uploads by path. Uses the attachment (srcset, alt,
 * dimensions) when the file is in the Media Library, else a plain lazy <img>.
 *
 * @param string $path  Upload path, e.g. /wp-content/uploads/2026/06/photo.jpg.
 * @param string $alt   Fallback alt text.
 * @param string $size  Image size for attachments.
 * @param array  $attrs Extra attributes.
 * @return string
 */
function arcunify_site_image( $path, $alt = '', $size = 'large', $attrs = array() ) {
	if ( ! $path ) {
		return '';
	}
	$url   = arcunify_url( $path );
	$id    = attachment_url_to_postid( $url );
	$attrs = wp_parse_args( $attrs, array( 'loading' => 'lazy', 'decoding' => 'async' ) );
	if ( $id ) {
		if ( '' !== $alt && ! get_post_meta( $id, '_wp_attachment_image_alt', true ) ) {
			$attrs['alt'] = $alt;
		}
		return wp_get_attachment_image( $id, $size, false, $attrs );
	}
	$html = '';
	foreach ( $attrs as $k => $v ) {
		$html .= sprintf( ' %s="%s"', esc_attr( $k ), esc_attr( $v ) );
	}
	return sprintf( '<img src="%s" alt="%s"%s>', esc_url( $url ), esc_attr( $alt ), $html );
}

/**
 * Whether the current view is rendered by a native theme template
 * (homepage or a mapped/assigned page template).
 *
 * @return bool
 */
function arcunify_is_native_view() {
	if ( arcunify_is_native_home() ) {
		return true;
	}
	return is_singular( 'page' ) && '' !== arcunify_native_template_for( get_queried_object_id() );
}

/**
 * Service key for a page: explicit meta box choice, else matched by slug.
 *
 * @param int $post_id Page ID.
 * @return string Service key or ''.
 */
function arcunify_service_key_for( $post_id ) {
	$services = arcunify_services();
	$chosen   = get_post_meta( $post_id, '_au_service', true );
	if ( $chosen && isset( $services[ $chosen ] ) ) {
		return $chosen;
	}
	$slug = get_post_field( 'post_name', $post_id );
	foreach ( $services as $key => $service ) {
		if ( trim( $service['path'], '/' ) === $slug ) {
			return $key;
		}
	}
	return '';
}

/**
 * Sprite icon placed inside an SVG diagram.
 *
 * @param string $name Icon.
 * @param float  $x    X (top-left).
 * @param float  $y    Y (top-left).
 * @param int    $size Size.
 * @return string
 */
function arcunify_svg_icon( $name, $x, $y, $size = 20 ) {
	return sprintf(
		'<svg class="au-icon au-v__icon" x="%1$s" y="%2$s" width="%3$d" height="%3$d" viewBox="0 0 24 24"><use href="#i-%4$s"></use></svg>',
		esc_attr( $x ),
		esc_attr( $y ),
		(int) $size,
		esc_attr( $name )
	);
}

/**
 * Labelled node used by the service diagrams: icon tile + label.
 *
 * @param float  $cx    Centre x.
 * @param float  $cy    Centre y.
 * @param string $icon  Icon.
 * @param string $label Label (existing service wording).
 * @param string $pos   Label position: below|right|left.
 * @return string
 */
function arcunify_svg_node( $cx, $cy, $icon, $label, $pos = 'below' ) {
	$out  = sprintf( '<g class="au-v__node"><rect x="%1$s" y="%2$s" width="44" height="44" rx="10" class="au-v__tile"/>', $cx - 22, $cy - 22 );
	$out .= arcunify_svg_icon( $icon, $cx - 11, $cy - 11, 22 );
	if ( 'right' === $pos ) {
		$out .= sprintf( '<text x="%1$s" y="%2$s" class="au-v__label" dominant-baseline="middle">%3$s</text>', $cx + 34, $cy, esc_html( $label ) );
	} elseif ( 'left' === $pos ) {
		$out .= sprintf( '<text x="%1$s" y="%2$s" class="au-v__label" text-anchor="end" dominant-baseline="middle">%3$s</text>', $cx - 34, $cy, esc_html( $label ) );
	} else {
		$out .= sprintf( '<text x="%1$s" y="%2$s" class="au-v__label" text-anchor="middle">%3$s</text>', $cx, $cy + 44, esc_html( $label ) );
	}
	return $out . '</g>';
}
