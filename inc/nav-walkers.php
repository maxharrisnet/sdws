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
			$output .= '<ul class="sdws-dropdown__menu" role="menu"'
				. ' style="display:none; position:absolute; top:100%; left:0;'
				. ' background:#fff; border:1px solid #000; min-width:220px;'
				. ' list-style:none; margin:0; padding:0; z-index:200;">';
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

		$li_style = ( $has_children && 0 === $depth ) ? ' style="position:relative;"' : '';
		if ( $has_children && 0 === $depth ) {
			$classes[] = 'sdws-dropdown';
		}
		$output .= '<li id="menu-item-' . absint( $item->ID ) . '" class="' . esc_attr( implode( ' ', $classes ) ) . '"' . $li_style . '>';

		if ( $has_children && 0 === $depth ) {
			$btn_style = 'padding:0.5rem 0.875rem; font-size:1rem; font-weight:400;'
				. ' letter-spacing:0.02em; color:#000; background:none; border:none;'
				. ' cursor:pointer; display:flex; align-items:center; gap:0.375rem;'
				. ' font-family:var(--font-body);';
			if ( $is_current ) {
				$btn_style .= ' border-bottom:2px solid #3a9aaa;';
			}
			$output .= '<button class="sdws-dropdown__toggle" aria-expanded="false" aria-haspopup="true" style="' . esc_attr( $btn_style ) . '">';
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
				$a_style = 'padding:0.5rem 0.875rem; font-size:1rem; font-weight:400;'
					. ' letter-spacing:0.02em; color:#000; text-decoration:none; display:block;';
				if ( $is_current ) {
					$a_style .= ' border-bottom:2px solid #3a9aaa;';
				}
			} else {
				$a_style = 'padding:0.75rem 1rem; font-size:1rem; color:#000; text-decoration:none; display:block;';
			}

			$output .= '<a href="' . esc_url( $item->url ) . '"' . $target . $rel . $title . $aria
				. ' style="' . esc_attr( $a_style ) . '">';
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
			$output .= '<ul style="list-style:none; padding:0; margin:0;">';
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

		$output .= '<li style="border-bottom:1px solid #000;">';

		if ( $has_children && 0 === $depth ) {
			$output .= '<span style="display:block; padding:0.6rem 0; font-size:0.75rem;'
				. ' font-weight:600; text-transform:uppercase; letter-spacing:0.1em;'
				. ' color:#000; opacity:0.45;">'
				. esc_html( $item->title ) . '</span>';
		} else {
			$target  = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
			$padding = $depth > 0 ? '0.75rem 1.25rem' : '1rem 0';
			$size    = $depth > 0 ? '1.25rem' : '1.5rem';
			$output .= '<a href="' . esc_url( $item->url ) . '"' . $target
				. ' style="display:block; padding:' . $padding . '; font-size:' . $size
				. '; font-weight:600; color:#000; text-decoration:none;">'
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
