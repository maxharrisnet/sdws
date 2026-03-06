/**
 * Resources Page - Client-Side Filtering
 * Filters resources without page reload using URL parameters
 */

(function () {
	'use strict';

	// Configuration
	const CONFIG = {
		filterSelector: '#typeSelector a[data-filter]',
		itemSelector: '[data-resource-class="resources"]',
		itemTypeAttr: 'data-resource-type',
		urlParam: 'category',
		allValue: 'all',
		activeClass: 'active',
		activeBorderStyle: '1px solid #00578f',
		inactiveBorderStyle: '1px solid transparent',
		fadeInDuration: 400,
		fadeOutDuration: 300,
	};

	let filterButtons = null;
	let resourceItems = null;

	/**
	 * Initialize the filter system
	 */
	function init() {
		// Wait for DOM to be ready
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', setup);
		} else {
			setup();
		}
	}

	/**
	 * Setup filter functionality
	 */
	function setup() {
		filterButtons = document.querySelectorAll(CONFIG.filterSelector);
		resourceItems = document.querySelectorAll(CONFIG.itemSelector);

		if (!filterButtons.length || !resourceItems.length) {
			return;
		}

		// Read initial filter from URL and apply
		const urlParams = new URLSearchParams(window.location.search);
		const initialFilter = urlParams.get(CONFIG.urlParam) || CONFIG.allValue;
		applyFilter(initialFilter, false);

		// Attach click handlers to filter buttons
		filterButtons.forEach(function (button) {
			button.addEventListener('click', handleFilterClick);
		});

		// Handle browser back/forward buttons
		window.addEventListener('popstate', function () {
			const urlParams = new URLSearchParams(window.location.search);
			const filter = urlParams.get(CONFIG.urlParam) || CONFIG.allValue;
			applyFilter(filter, false);
		});
	}

	/**
	 * Handle filter button click
	 *
	 * @param {Event} event - Click event
	 */
	function handleFilterClick(event) {
		event.preventDefault();
		event.stopPropagation();

		const button = event.currentTarget;
		const filterValue = button.getAttribute('data-filter');

		// Apply filter and update URL
		applyFilter(filterValue, true);
	}

	/**
	 * Apply filter to resources
	 *
	 * @param {string}  filterValue   - Filter value to apply
	 * @param {boolean} updateHistory - Whether to update browser history
	 */
	function applyFilter(filterValue, updateHistory) {
		// Update URL
		if (updateHistory) {
			updateURL(filterValue);
		}

		// Update active states on buttons
		updateButtonStates(filterValue);

		// Filter items
		filterItems(filterValue);
	}

	/**
	 * Update URL parameter
	 *
	 * @param {string} filterValue - Filter value
	 */
	function updateURL(filterValue) {
		const url = new URL(window.location.href);

		if (filterValue === CONFIG.allValue) {
			url.searchParams.delete(CONFIG.urlParam);
		} else {
			url.searchParams.set(CONFIG.urlParam, filterValue);
		}

		window.history.pushState({ filter: filterValue }, '', url.toString());
	}

	/**
	 * Update active states on filter buttons
	 *
	 * @param {string} activeFilter - Currently active filter
	 */
	function updateButtonStates(activeFilter) {
		filterButtons.forEach(function (button) {
			const filterValue = button.getAttribute('data-filter');
			const isActive = filterValue === activeFilter;

			if (isActive) {
				button.classList.add(CONFIG.activeClass);
				button.style.borderBottom = CONFIG.activeBorderStyle;
			} else {
				button.classList.remove(CONFIG.activeClass);
				button.style.borderBottom = CONFIG.inactiveBorderStyle;
			}
		});
	}

	/**
	 * Normalize filter slug to match post_type values used in data-resource-type
	 * e.g., 'videos' -> 'video', 'blogs' -> 'blog'
	 *
	 * @param {string} value
	 * @return {string}
	 */
	function normalizeFilter(value) {
		const map = {
			videos: 'video',
			whitepapers: 'whitepaper',
			blogs: 'blog',
			'case-studies': 'case-study',
			podcasts: 'podcast',
		};
		return map[value] || value;
	}

	/**
	 * Filter resource items with fade animation
	 *
	 * @param {string} filterValue - Filter value
	 */
	function filterItems(filterValue) {
		const showAll = filterValue === CONFIG.allValue;
		const normalized = normalizeFilter(filterValue);

		resourceItems.forEach(function (item) {
			const itemType = item.getAttribute(CONFIG.itemTypeAttr);
			const shouldShow = showAll || itemType === normalized;

			if (shouldShow) {
				fadeIn(item);
			} else {
				fadeOut(item);
			}
		});
	}

	/**
	 * Fade in element
	 *
	 * @param {HTMLElement} element - Element to fade in
	 */
	function fadeIn(element) {
		// If already visible and opacity is 1, skip
		if (element.style.display !== 'none' && element.style.opacity === '1') {
			return;
		}

		element.style.display = '';
		element.style.opacity = '0';

		// Force reflow
		element.offsetHeight;

		element.style.transition = 'opacity ' + CONFIG.fadeInDuration + 'ms ease-in-out';
		element.style.opacity = '1';
	}

	/**
	 * Fade out element
	 *
	 * @param {HTMLElement} element - Element to fade out
	 */
	function fadeOut(element) {
		// If already hidden, skip
		if (element.style.display === 'none') {
			return;
		}

		element.style.transition = 'opacity ' + CONFIG.fadeOutDuration + 'ms ease-in-out';
		element.style.opacity = '0';

		setTimeout(function () {
			element.style.display = 'none';
		}, CONFIG.fadeOutDuration);
	}

	// Initialize when script loads
	init();
})();
