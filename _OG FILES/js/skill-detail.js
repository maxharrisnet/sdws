/**
 * Skill Detail Page Scripts
 * Handles scroll tracking, navigation, and active state management
 */
(function () {
	'use strict';

	// Wait for DOM to be ready
	document.addEventListener('DOMContentLoaded', function () {
		// Check if we're on the skill detail page
		const mainContent = document.getElementById('skillMainContent');
		if (!mainContent) {
			return; // Not on this page
		}

		const sections = document.querySelectorAll('.skill-detail__section');
		const tabLinks = document.querySelectorAll('.skill-tabs__link');
		const sidebarLinks = document.querySelectorAll('.skill-detail__sidebar-nav a');
		const allNavLinks = [...tabLinks, ...sidebarLinks];

		if (!sections.length) {
			return; // No sections found
		}

		/**
		 * Update active navigation based on scroll position
		 */
		function updateActiveNav() {
			const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
			const windowHeight = window.innerHeight;
			let current = '';

			// Find the current section based on scroll position
			// Check sections from bottom to top
			sections.forEach((section) => {
				const sectionTop = section.offsetTop - 200; // 200px offset for better UX
				if (scrollPosition >= sectionTop) {
					current = section.getAttribute('id');
				}
			});

			// Update active class on navigation links
			allNavLinks.forEach((link) => {
				link.classList.remove('active');
				const href = link.getAttribute('href');
				if (href === `#${current}`) {
					link.classList.add('active');
				}
			});

			// Special case: if we're at the very bottom of the page, activate the last link
			const scrollHeight = document.documentElement.scrollHeight;
			if (scrollPosition + windowHeight >= scrollHeight - 100) {
				const lastSection = sections[sections.length - 1];
				if (lastSection) {
					const lastSectionId = lastSection.getAttribute('id');
					allNavLinks.forEach((link) => {
						link.classList.remove('active');
						if (link.getAttribute('href') === `#${lastSectionId}`) {
							link.classList.add('active');
						}
					});
				}
			}
		}

		/**
		 * Smooth scroll to section
		 */
		function scrollToSection(e) {
			e.preventDefault();
			const targetId = this.getAttribute('href');
			const targetSection = document.querySelector(targetId);

			if (targetSection) {
				// Remove active from all nav links
				allNavLinks.forEach((link) => link.classList.remove('active'));
				// Add active to clicked link
				this.classList.add('active');

				// Calculate offset for fixed header/tabs
				const tabsHeight = document.querySelector('.skill-tabs')?.offsetHeight || 0;
				const headerHeight = document.querySelector('.site-header')?.offsetHeight || 0;
				const offset = tabsHeight + headerHeight + 20; // 20px additional padding

				const targetPosition = targetSection.offsetTop - offset;

				window.scrollTo({
					top: targetPosition,
					behavior: 'smooth'
				});
			}
		}

		/**
		 * Handle clicks on tab and sidebar navigation
		 */
		allNavLinks.forEach((link) => {
			link.addEventListener('click', scrollToSection);
		});

		/**
		 * Handle scroll tracking
		 */
		let ticking = false;
		window.addEventListener('scroll', function () {
			if (!ticking) {
				window.requestAnimationFrame(function () {
					updateActiveNav();
					ticking = false;
				});
				ticking = true;
			}
		});

		/**
		 * Initial active state on page load
		 */
		updateActiveNav();

		/**
		 * Handle hash in URL on page load
		 */
		if (window.location.hash) {
			setTimeout(function () {
				const targetLink = document.querySelector(`a[href="${window.location.hash}"]`);
				if (targetLink) {
					targetLink.click();
				}
			}, 100);
		}
	});
})();

