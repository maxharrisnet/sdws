<?php

/**
 * Custom Walker classes for SDWS navigation menus.
 *
 * @package Starter_Coat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Desktop primary nav walker.
 *
 * Produces the SDWS gallery-style nav with a drop-down for items
 * that have children (e.g. Exhibitions).
 */
class SDWS_Primary_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 === $depth ) {
			$output .= '<ul class="sdws-dropdown__menu" role="menu">';
		} else {
			$output .= '<ul class="sub-menu">';
		}
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	public function start_el( &$output, $data_object, $depth = 0, $args = null, $id = 0 ) {
		$item         = $data_object;
		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$is_current   = in_array( 'current-menu-item', $classes, true )
			|| in_array( 'current-menu-ancestor', $classes, true )
			|| in_array( 'current-menu-parent', $classes, true );

		if ( $has_children && 0 === $depth ) {
			$classes[] = 'sdws-dropdown';
		}
		$output .= '<li id="menu-item-' . absint( $item->ID ) . '" class="' . esc_attr( implode( ' ', $classes ) ) . '">';

		if ( $has_children && 0 === $depth ) {
			$btn_class = 'sdws-dropdown__toggle';
			if ( $is_current ) {
				$btn_class .= ' sdws-dropdown__toggle--current';
			}
			$output .= '<button class="' . esc_attr( $btn_class ) . '" aria-expanded="false" aria-haspopup="true">';
			$output .= esc_html( $item->title );
			$output .= '<svg width="10" height="6" viewBox="0 0 10 6" fill="none" aria-hidden="true">'
				. '<path d="M1 1l4 4 4-4" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>'
				. '</svg>';
			$output .= '</button>';
		} else {
			$target = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
			$rel    = ! empty( $item->xfn )    ? ' rel="'    . esc_attr( $item->xfn )    . '"' : '';
			$title  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
			$aria   = $is_current ? ' aria-current="page"' : '';

			if ( 0 === $depth ) {
				$a_class = 'sdws-nav__link';
				if ( $is_current ) {
					$a_class .= ' sdws-nav__link--current';
				}
			} else {
				$a_class = 'sdws-nav__link--child';
			}

			$output .= '<a href="' . esc_url( $item->url ) . '"' . $target . $rel . $title . $aria
				. ' class="' . esc_attr( $a_class ) . '">';
			$output .= esc_html( $item->title );
			$output .= '</a>';
		}
	}

	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}

/**
 * Mobile overlay nav walker.
 *
 * Shows all items flat. Parent items that have children are rendered
 * as a non-clickable label; their children appear as full-size links.
 */
class SDWS_Mobile_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 === $depth ) {
			$output .= '<ul class="sdws-mobile-nav__sub-list">';
		}
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 === $depth ) {
			$output .= '</ul>';
		}
	}

	public function start_el( &$output, $data_object, $depth = 0, $args = null, $id = 0 ) {
		$item         = $data_object;
		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );

		$output .= '<li class="sdws-mobile-nav__item">';

		if ( $has_children && 0 === $depth ) {
			$output .= '<span class="sdws-mobile-nav__label">'
				. esc_html( $item->title ) . '</span>';
		} else {
			$target    = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
			$link_class = $depth > 0 ? 'sdws-mobile-nav__link sdws-mobile-nav__link--child' : 'sdws-mobile-nav__link';
			$output   .= '<a href="' . esc_url( $item->url ) . '"' . $target
				. ' class="' . esc_attr( $link_class ) . '">'
				. esc_html( $item->title ) . '</a>';
		}
	}

	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}

/**
 * Footer nav walker.
 *
 * Renders plain white links for use on the dark footer background.
 */
class SDWS_Footer_Nav_Walker extends Walker_Nav_Menu {

	public function start_el( &$output, $data_object, $depth = 0, $args = null, $id = 0 ) {
		$item   = $data_object;
		$target = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$output .= '<li>';
		$output .= '<a href="' . esc_url( $item->url ) . '"' . $target
			. ' class="sdws-footer__link">'
			. esc_html( $item->title ) . '</a>';
	}

	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}
