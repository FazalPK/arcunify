<?php
/**
 * Navigation.
 *
 * Menus stay editable in Appearance → Menus. Give a top-level item the CSS class
 * "au-mega" (Screen Options → CSS Classes) and its dropdown is replaced by the
 * Services mega panel, built from the service list. Other items with children
 * get a normal accessible dropdown.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * Walker producing accessible disclosure-pattern navigation.
 */
class Arcunify_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * 'desktop' or 'mobile'.
	 *
	 * @var string
	 */
	private $context;

	/**
	 * True while walking the children of an au-mega item (they are skipped).
	 *
	 * @var bool
	 */
	private $in_mega = false;

	/**
	 * Submenu ids by depth, for aria-controls.
	 *
	 * @var array
	 */
	private $panel_ids = array();

	/**
	 * @param string $context desktop|mobile.
	 */
	public function __construct( $context = 'desktop' ) {
		$this->context = $context;
	}

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( $this->in_mega ) {
			return;
		}
		$id      = isset( $this->panel_ids[ $depth ] ) ? $this->panel_ids[ $depth ] : '';
		$output .= '<ul class="au-nav__sub" id="' . esc_attr( $id ) . '">';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( $this->in_mega ) {
			return;
		}
		$output .= '</ul>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( $depth > 0 && $this->in_mega ) {
			return;
		}

		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
		$is_mega      = ( 0 === $depth && in_array( 'au-mega', $classes, true ) );
		$has_children = $is_mega || in_array( 'menu-item-has-children', $classes, true );
		$is_current   = (bool) array_intersect( array( 'current-menu-item', 'current-menu-ancestor', 'current-page-ancestor', 'current_page_parent' ), $classes );

		$li_classes = array( 'au-nav__item' );
		if ( $has_children ) {
			$li_classes[] = 'has-sub';
		}
		if ( $is_mega ) {
			$li_classes[] = 'has-mega';
		}
		if ( $is_current ) {
			$li_classes[] = 'is-current';
		}

		$output .= '<li class="' . esc_attr( implode( ' ', $li_classes ) ) . '">';
		$output .= arcunify_nav_link_html( $item->title, $item->url, in_array( 'current-menu-item', $classes, true ), $item->target );

		if ( $has_children ) {
			$panel_id                  = 'au-' . $this->context . '-sub-' . $item->ID;
			$this->panel_ids[ $depth ] = $panel_id;
			$output                   .= arcunify_nav_toggle_html( $item->title, $panel_id );
		}

		if ( $is_mega ) {
			$this->in_mega = true;
			$output       .= arcunify_services_panel_html( $panel_id, $this->context );
		}
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( $depth > 0 && $this->in_mega ) {
			return;
		}
		if ( 0 === $depth ) {
			$this->in_mega = false;
		}
		$output .= '</li>';
	}
}

/**
 * @param string $title      Link text.
 * @param string $url        URL.
 * @param bool   $is_current Current page.
 * @param string $target     Target attribute.
 * @return string
 */
function arcunify_nav_link_html( $title, $url, $is_current = false, $target = '' ) {
	return sprintf(
		'<a class="au-nav__link" href="%1$s"%2$s%3$s>%4$s</a>',
		esc_url( $url ),
		$is_current ? ' aria-current="page"' : '',
		$target ? ' target="' . esc_attr( $target ) . '" rel="noopener"' : '',
		esc_html( $title )
	);
}

/**
 * @param string $title    Parent title.
 * @param string $panel_id Controlled panel id.
 * @return string
 */
function arcunify_nav_toggle_html( $title, $panel_id ) {
	return sprintf(
		'<button class="au-nav__toggle" type="button" aria-expanded="false" aria-controls="%1$s"><span class="screen-reader-text">%2$s</span>%3$s</button>',
		esc_attr( $panel_id ),
		/* translators: %s: menu item title. */
		esc_html( sprintf( __( 'Show %s menu', 'arcunify' ), $title ) ),
		arcunify_icon( 'chevron-down', 'au-nav__chev' )
	);
}

/**
 * Services panel: grouped mega menu on desktop, flat list on mobile.
 *
 * @param string $panel_id Panel id.
 * @param string $context  desktop|mobile.
 * @return string
 */
function arcunify_services_panel_html( $panel_id, $context ) {
	$services = arcunify_services();
	ob_start();

	if ( 'mobile' === $context ) {
		echo '<ul class="au-nav__sub" id="' . esc_attr( $panel_id ) . '">';
		foreach ( $services as $service ) {
			printf(
				'<li><a class="au-nav__sublink" href="%1$s">%2$s<span>%3$s</span></a></li>',
				esc_url( arcunify_service_url( $service ) ),
				arcunify_icon( $service['icon'] ), // phpcs:ignore WordPress.Security.EscapeOutput
				esc_html( $service['name'] )
			);
		}
		printf( '<li><a class="au-nav__sublink au-nav__sublink--all" href="%1$s">%2$s</a></li>', esc_url( home_url( '/services/' ) ), esc_html__( 'All services', 'arcunify' ) );
		echo '</ul>';
		return ob_get_clean();
	}

	get_template_part( 'template-parts/header/mega-services', null, array( 'id' => $panel_id ) );
	return ob_get_clean();
}

/**
 * Fallback when no menu is assigned: Services (mega) · About · Contact.
 *
 * @param array $args wp_nav_menu args (uses 'au_context').
 */
function arcunify_nav_fallback( $args ) {
	$context = isset( $args['au_context'] ) ? $args['au_context'] : 'desktop';
	$items   = array(
		array( __( 'Services', 'arcunify' ), home_url( '/services/' ), true ),
		array( __( 'About', 'arcunify' ), home_url( '/about-us/' ), false ),
		array( __( 'Contact', 'arcunify' ), home_url( '/contact-us/' ), false ),
	);
	$current = untrailingslashit( home_url( add_query_arg( array() ) ) );

	echo '<ul class="au-nav__list">';
	foreach ( $items as $i => $item ) {
		list( $title, $url, $mega ) = $item;
		$is_current = untrailingslashit( $url ) === $current;
		echo '<li class="au-nav__item' . ( $mega ? ' has-sub has-mega' : '' ) . ( $is_current ? ' is-current' : '' ) . '">';
		echo arcunify_nav_link_html( $title, $url, $is_current ); // phpcs:ignore WordPress.Security.EscapeOutput
		if ( $mega ) {
			$panel_id = 'au-' . $context . '-sub-services';
			echo arcunify_nav_toggle_html( $title, $panel_id ); // phpcs:ignore WordPress.Security.EscapeOutput
			echo arcunify_services_panel_html( $panel_id, $context ); // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * Render the primary navigation.
 *
 * @param string $context desktop|mobile.
 */
function arcunify_primary_nav( $context = 'desktop' ) {
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'au-nav__list',
			'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
			'depth'          => 2,
			'walker'         => new Arcunify_Nav_Walker( $context ),
			'fallback_cb'    => 'arcunify_nav_fallback',
			'au_context'     => $context,
		)
	);
}
