/**
 * Skills Archive - Client-Side Filtering
 * - Multi-checkbox filter by selected skills (IDs)
 * - Search input filters by title/excerpt
 * - Updates URL params via History API without reload
 * - Progressive enhancement: if JS disabled, server-side still works
 */
(function () {
	'use strict';

	const CONFIG = {
		checkboxSelector: '.skills-filter__checkbox',
		searchInputSelector: '.skills-filter__search-input',
		itemsSelector: '.skills-grid__list .icon-card',
		itemIdAttr: 'data-skill-id',
		itemCategoryIdsAttr: 'data-category-ids',
		urlCategoriesParam: 'categories',
		fadeInDuration: 300,
		fadeOutDuration: 250,
		urlSkillParam: 'skills[]',
		urlSearchParam: 'skill_search',
	};

	let checkboxes = [];
	let searchInput = null;
	let items = [];

	function init() {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', setup);
		} else {
			setup();
		}
	}

	function setup() {
		const filterForm = document.getElementById('skillsFilterForm');
		const searchForm = document.getElementById('skillsSearchForm');

		// Category-based filtering: client-side (no reload), like resources-filter.js
		const categoryCheckboxes = filterForm && Array.from(filterForm.querySelectorAll('.skills-filter__category-cb'));
		const hasCategoryFilter = categoryCheckboxes && categoryCheckboxes.length > 0;
		const items = Array.from(document.querySelectorAll(CONFIG.itemsSelector));

		if (hasCategoryFilter && items.length > 0) {
			setupCategoryFilter(filterForm, searchForm, categoryCheckboxes, items);
			return;
		}

		// Skill ID-based client-side filtering below
		try {
			window.AeraSkillsFilterActive = true;
		} catch (e) {}
		checkboxes = Array.from(document.querySelectorAll(CONFIG.checkboxSelector));
		searchInput = document.querySelector(CONFIG.searchInputSelector);
		items = Array.from(document.querySelectorAll(CONFIG.itemsSelector));

		if (!items.length) {
			return;
		}

		// Initial filter from URL
		const initial = getStateFromURL();
		applyFilter(initial.selectedIds, initial.searchTerm, false);

		// Intercept form submits
		if (filterForm) {
			filterForm.addEventListener('submit', function (e) {
				e.preventDefault();
			});
		}
		if (searchForm) {
			searchForm.addEventListener('submit', function (e) {
				e.preventDefault();
			});
		}

		// Checkbox change -> filter
		checkboxes.forEach((cb) => {
			cb.addEventListener('change', onControlsChange);
		});

		// Search input -> debounce filter
		if (searchInput) {
			let debounceTimer = null;
			searchInput.addEventListener('input', function () {
				clearTimeout(debounceTimer);
				debounceTimer = setTimeout(onControlsChange, 200);
			});
		}

		// Back/forward
		window.addEventListener('popstate', function () {
			const state = getStateFromURL();
			setControlsFromState(state);
			applyFilter(state.selectedIds, state.searchTerm, false);
		});
	}

	function onControlsChange() {
		const selectedIds = getSelectedIdsFromControls();
		const searchTerm = getSearchTermFromControls();
		applyFilter(selectedIds, searchTerm, true);
	}

	function getSelectedIdsFromControls() {
		return checkboxes
			.filter((cb) => cb.checked)
			.map((cb) => parseInt(cb.value, 10))
			.filter((n) => !Number.isNaN(n));
	}

	function getSearchTermFromControls() {
		return searchInput && searchInput.value ? searchInput.value.trim() : '';
	}

	function setControlsFromState(state) {
		// Update checkboxes
		const idSet = new Set(state.selectedIds);
		checkboxes.forEach((cb) => {
			cb.checked = idSet.has(parseInt(cb.value, 10));
		});
		// Update search
		if (searchInput) {
			searchInput.value = state.searchTerm || '';
		}
	}

	/**
	 * Category filter: client-side filter by category IDs + search, update URL with pushState (no reload).
	 */
	function setupCategoryFilter(filterForm, searchForm, categoryCheckboxes, items) {
		if (searchForm) {
			searchForm.addEventListener('submit', function (e) {
				e.preventDefault();
			});
		}
		if (filterForm) {
			filterForm.addEventListener('submit', function (e) {
				e.preventDefault();
			});
		}

		const hiddenCategories = document.getElementById('skillsFilterCategories');
		const searchInput = document.querySelector(CONFIG.searchInputSelector);

		function getSelectedCategoryIds() {
			return categoryCheckboxes
				.filter((cb) => cb.checked)
				.map((cb) => parseInt(cb.value, 10))
				.filter((n) => !Number.isNaN(n));
		}

		function getSearchTerm() {
			return searchInput && searchInput.value ? searchInput.value.trim() : '';
		}

		function getStateFromURLCategories() {
			const url = new URL(window.location.href);
			const param = url.searchParams.get(CONFIG.urlCategoriesParam);
			const categoryIds = !param
				? []
				: param
						.split(',')
						.map((s) => parseInt(s.trim(), 10))
						.filter((n) => !Number.isNaN(n));
			const searchTerm = url.searchParams.get(CONFIG.urlSearchParam) || '';
			return { categoryIds, searchTerm };
		}

		function updateURLState(selectedIds, searchTerm) {
			const url = new URL(window.location.href);
			if (selectedIds.length === 0) {
				url.searchParams.delete(CONFIG.urlCategoriesParam);
			} else {
				url.searchParams.set(CONFIG.urlCategoriesParam, selectedIds.join(','));
			}
			if (searchTerm) {
				url.searchParams.set(CONFIG.urlSearchParam, searchTerm);
			} else {
				url.searchParams.delete(CONFIG.urlSearchParam);
			}
			window.history.pushState({ categories: selectedIds, search: searchTerm }, '', url.toString());
		}

		function setCheckboxesFromState(selectedIds) {
			const idSet = new Set(selectedIds);
			categoryCheckboxes.forEach((cb) => {
				cb.checked = idSet.has(parseInt(cb.value, 10));
			});
			if (hiddenCategories) {
				hiddenCategories.value = selectedIds.join(',');
			}
		}

		function setSearchFromState(searchTerm) {
			if (searchInput) {
				searchInput.value = searchTerm || '';
			}
		}

		function expandHeadersForCheckedCategories() {
			const expanded = new Set();
			categoryCheckboxes.forEach((cb) => {
				if (!cb.checked) return;
				const fn = cb.closest('.skills-filter__function');
				const header = fn?.querySelector('.skills-filter__function-header');
				const slug = header?.getAttribute('data-function');
				if (slug && !expanded.has(slug)) {
					expanded.add(slug);
					const list = document.getElementById('function-' + slug);
					if (list) list.classList.add('active');
					if (header) header.classList.add('active');
				}
			});
		}

		function applyCategoryFilter(selectedIds, searchTerm, updateHistory) {
			if (updateHistory) {
				updateURLState(selectedIds, searchTerm);
			}
			setCheckboxesFromState(selectedIds);
			setSearchFromState(searchTerm);

			const hasCategoryFilter = selectedIds.length > 0;
			const idSet = new Set(selectedIds);
			const hasSearch = !!(searchTerm && searchTerm.length);
			const searchLower = hasSearch ? searchTerm.toLowerCase() : '';

			items.forEach((item) => {
				const raw = item.getAttribute(CONFIG.itemCategoryIdsAttr) || '';
				const cardCategoryIds = raw
					.split(',')
					.map((s) => parseInt(s.trim(), 10))
					.filter((n) => !Number.isNaN(n));
				const matchesCategory = !hasCategoryFilter || cardCategoryIds.some((id) => idSet.has(id));

				let matchesSearch = true;
				if (hasSearch) {
					const titleEl = item.querySelector('.icon-card__title');
					const excerptEl = item.querySelector('.icon-card__excerpt');
					const text = ((titleEl ? titleEl.textContent : '') + ' ' + (excerptEl ? excerptEl.textContent : '')).toLowerCase();
					matchesSearch = text.indexOf(searchLower) !== -1;
				}

				const shouldShow = matchesCategory && matchesSearch;
				if (shouldShow) {
					fadeIn(item);
				} else {
					fadeOut(item);
				}
			});

			expandHeadersForCheckedCategories();
		}

		function onFilterChange(updateHistory) {
			const selectedIds = getSelectedCategoryIds();
			const searchTerm = getSearchTerm();
			applyCategoryFilter(selectedIds, searchTerm, updateHistory);
		}

		// Initial state from URL
		const initial = getStateFromURLCategories();
		applyCategoryFilter(initial.categoryIds, initial.searchTerm, false);

		categoryCheckboxes.forEach((cb) => {
			cb.addEventListener('change', function () {
				onFilterChange(true);
			});
		});

		if (searchInput) {
			let debounceTimer = null;
			searchInput.addEventListener('input', function () {
				clearTimeout(debounceTimer);
				debounceTimer = setTimeout(function () {
					onFilterChange(true);
				}, 200);
			});
		}

		window.addEventListener('popstate', function () {
			const state = getStateFromURLCategories();
			applyCategoryFilter(state.categoryIds, state.searchTerm, false);
		});
	}

	function getStateFromURL() {
		const url = new URL(window.location.href);
		const params = url.searchParams;
		// skill[] can be multiple entries
		// Read primary (skills[]) and legacy (skill[]) for robustness
		let rawSkills = params.getAll(CONFIG.urlSkillParam);
		if (!rawSkills.length) {
			rawSkills = params.getAll('skill[]');
		}
		const selectedIds = rawSkills.map((v) => parseInt(v, 10)).filter((n) => !Number.isNaN(n));
		const searchTerm = params.get(CONFIG.urlSearchParam) || '';
		return { selectedIds, searchTerm };
	}

	function updateURL(selectedIds, searchTerm) {
		const url = new URL(window.location.href);
		const params = url.searchParams;

		// Clear existing skill[] params
		// URLSearchParams doesn't expose deleteAll for same key; rebuild
		params.forEach((value, key) => {
			if (key === CONFIG.urlSkillParam || key === 'skill[]') {
				params.delete(key);
			}
		});

		// Append selected ids as skill[]
		selectedIds.forEach((id) => params.append(CONFIG.urlSkillParam, String(id)));

		// Search term
		if (searchTerm && searchTerm.length) {
			params.set(CONFIG.urlSearchParam, searchTerm);
		} else {
			params.delete(CONFIG.urlSearchParam);
		}

		window.history.pushState({ skills: selectedIds, search: searchTerm }, '', url.toString());
	}

	function applyFilter(selectedIds, searchTerm, updateHistory) {
		if (updateHistory) {
			updateURL(selectedIds, searchTerm);
		}

		const idSet = new Set(selectedIds);
		const hasIdFilter = selectedIds && selectedIds.length > 0;
		const hasSearch = !!(searchTerm && searchTerm.length);
		const searchLower = hasSearch ? searchTerm.toLowerCase() : '';

		items.forEach((item) => {
			const itemId = parseInt(item.getAttribute(CONFIG.itemIdAttr), 10);
			let matchesId = true;
			if (hasIdFilter) {
				matchesId = idSet.has(itemId);
			}

			let matchesSearch = true;
			if (hasSearch) {
				const titleEl = item.querySelector('.icon-card__title');
				const excerptEl = item.querySelector('.icon-card__excerpt');
				const text = ((titleEl ? titleEl.textContent : '') + ' ' + (excerptEl ? excerptEl.textContent : '')).toLowerCase();
				matchesSearch = text.indexOf(searchLower) !== -1;
			}

			const shouldShow = matchesId && matchesSearch;
			if (shouldShow) {
				fadeIn(item);
			} else {
				fadeOut(item);
			}
		});
	}

	function fadeIn(el) {
		if (el.style.display !== 'none' && el.style.opacity === '1') {
			return;
		}
		el.style.display = '';
		el.style.opacity = '0';
		el.offsetHeight;
		el.style.transition = 'opacity ' + CONFIG.fadeInDuration + 'ms ease-in-out';
		el.style.opacity = '1';
	}

	function fadeOut(el) {
		if (el.style.display === 'none') {
			return;
		}
		el.style.transition = 'opacity ' + CONFIG.fadeOutDuration + 'ms ease-in-out';
		el.style.opacity = '0';
		setTimeout(function () {
			el.style.display = 'none';
		}, CONFIG.fadeOutDuration);
	}

	init();
})();
