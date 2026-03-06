/**
 * File navigation.js.
 *
 * Handles keyboard navigation support for dropdown menus.
 * Mobile submenu toggles are handled by site.js
 */
( function() {
	/**
	 * Sets or removes .focus class on an element for keyboard navigation.
	 *
	 * @param {Event} event The focus/blur event.
	 */
	function toggleFocus( event ) {
		if ( event.type === 'focus' || event.type === 'blur' ) {
			let self = this;
			// Move up through the ancestors of the current link until we hit .navigation__list.
			while ( self && ! self.classList.contains( 'navigation__list' ) ) {
				// On li elements toggle the class .focus.
				if ( 'li' === self.tagName.toLowerCase() ) {
					self.classList.toggle( 'focus' );
				}
				self = self.parentNode;
			}
		}
	}

	/**
	 * Initialize keyboard navigation support for menu links.
	 */
	function initKeyboardNavigation() {
		const navList = document.querySelector( '.navigation__list' );
		if ( ! navList ) {
			return;
		}

		const links = navList.getElementsByTagName( 'a' );

		// Toggle focus each time a menu link is focused or blurred.
		for ( const link of links ) {
			link.addEventListener( 'focus', toggleFocus, true );
			link.addEventListener( 'blur', toggleFocus, true );
		}
	}

	// Initialize when DOM is ready
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initKeyboardNavigation );
	} else {
		initKeyboardNavigation();
	}
}() );
