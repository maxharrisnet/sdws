/**
 * Decision Intelligence Page Scripts
 * Handles scroll tracking, navigation, and progress indicator
 */
(function () {
	'use strict';

	// Wait for DOM to be ready
	document.addEventListener('DOMContentLoaded', function () {
		// Check if we're on the decision intelligence page
		const outerSection = document.getElementById('outerSection');
		if (!outerSection) {
			return; // Not on this page
		}

		const sections = document.querySelectorAll('section');
		const navLinks = document.querySelectorAll('.nav a');
		const mainLinks = document.querySelectorAll('.nav li.main > a');
		const toggles = document.querySelectorAll('.toggle-btn');
		const toggleIcon = document.getElementById('toggleIcon');
		const hamburgerToggle = document.getElementById('hamburgerToggle');
		const accordionMenu = document.querySelector('.accordion');
		const menuList = document.getElementById('menu');
		const leftWrapper = document.getElementById('leftWrapper');
		const navMobile = document.getElementById('navMobile');

		if (!sections.length || !leftWrapper) {
			return; // Required elements not found
		}

		/**
		 * Update progress line based on scroll position
		 */
		function updateProgressLine() {
			const scrollPosition = leftWrapper.scrollTop;
			const totalHeight = leftWrapper.scrollHeight - window.innerHeight;
			const scrollPercent = scrollPosition / totalHeight;
			const menu = document.getElementById('menu');

			if (!menu) {
				return;
			}

			const barHeight = scrollPercent * menu.clientHeight;
			const styleEl = document.getElementById('dynamic-bar-style') || document.createElement('style');
			styleEl.id = 'dynamic-bar-style';
			styleEl.innerHTML = `
				.nav ul#menu::after {
					height: ${barHeight}px !important;
				}
			`;
			document.head.appendChild(styleEl);

			// Handle section1 special case
			if (window.innerWidth > 780) {
				const section1Link = document.querySelector('.nav a[href="#section1"]');
				if (barHeight === 0 && section1Link) {
					section1Link.classList.remove('active');
					section1Link.classList.remove('filled');
				}
			}
		}

		/**
		 * Toggle accordion menu for mobile
		 */
		if (toggles.length > 0) {
			toggles.forEach((btn) => {
				btn.addEventListener('click', (e) => {
					e.preventDefault();
					const parent = btn.parentElement;
					parent.classList.toggle('open');
					btn.textContent = parent.classList.contains('open') ? '▲' : '▼';
				});
			});
		}

		/**
		 * Hamburger toggle for mobile menu
		 */
		if (hamburgerToggle && accordionMenu && toggleIcon) {
			hamburgerToggle.addEventListener('click', () => {
				accordionMenu.classList.toggle('show');
				toggleIcon.textContent = accordionMenu.classList.contains('show') ? '▲' : '▼';
			});
		}

		/**
		 * Close mobile menu when nav link is clicked
		 */
		if (navLinks.length > 0) {
			navLinks.forEach((link) => {
				link.addEventListener('click', () => {
					if (window.innerWidth < 768 && accordionMenu && toggleIcon) {
						accordionMenu.classList.remove('show');
						toggleIcon.textContent = accordionMenu.classList.contains('show') ? '▲' : '▼';
					}
				});
			});
		}

		/**
		 * Handle scroll tracking for navigation
		 */
		if (leftWrapper) {
			leftWrapper.addEventListener('scroll', () => {
				const section6 = document.getElementById('section6');
				const scrollPosition = leftWrapper.scrollTop;
				let current = '';

				// Determine current section based on scroll position
				sections.forEach((section) => {
					const sectionTop = section.offsetTop - 150;
					if (leftWrapper.scrollTop >= sectionTop) {
						current = section.getAttribute('id');
					}
				});

				// Update active navigation links
				navLinks.forEach((link) => {
					link.classList.remove('active');
					if (link.getAttribute('href') === `#${current}`) {
						link.classList.add('active');
					}

					// Special handling for section6
					if (window.innerWidth > 780) {
						if (scrollPosition >= 13500) {
							link.classList.remove('active');
							if (link.getAttribute('href') === '#section6') {
								link.classList.add('active');
							}
						}
					} else if (window.innerWidth < 780) {
						if (scrollPosition >= 18800) {
							link.classList.remove('active');
							if (link.getAttribute('href') === '#section6') {
								link.classList.add('active');
							}
						}
					}
				});

				// Update filled state for main links
				let anyFilled = false;
				mainLinks.forEach((mainLink) => {
					const sectionId = mainLink.getAttribute('href').substring(1);
					const section = document.getElementById(sectionId);
					if (section && leftWrapper.scrollTop >= section.offsetTop - 150) {
						mainLink.classList.add('filled');
						anyFilled = true;
					} else {
						mainLink.classList.remove('filled');
					}
				});

				// Special handling for section6 filled state
				if (window.innerWidth > 780 && menuList) {
					const section6Link = document.querySelector('.nav li.main > a[href="#section6"]');
					if (section6Link && section6Link.classList.contains('active')) {
						section6Link.classList.add('filled');
					} else if (section6Link) {
						section6Link.classList.remove('filled');
					}
				}

				// Update menu filled state
				if (menuList) {
					if (window.innerWidth >= 768) {
						if (anyFilled) {
							menuList.classList.add('filled');
						} else {
							menuList.classList.remove('filled');
						}
					} else {
						menuList.classList.remove('filled');
					}
				}

				// Update progress line
				updateProgressLine();
			});
		}

		/**
		 * Handle window scroll for mobile nav positioning
		 */
		window.addEventListener('scroll', () => {
			if (window.innerWidth <= 720 && outerSection && navMobile) {
				const offsetTop = outerSection.offsetTop;
				if (window.scrollY >= offsetTop) {
					navMobile.classList.add('navfixed');
				} else {
					navMobile.classList.remove('navfixed');
				}
			}
		});

		/**
		 * Hide/show header and announcement bar on scroll
		 * Hide on scroll down, show on scroll up
		 */
		let lastScrollY = window.scrollY;
		let ticking = false;

		function handleHeaderScroll() {
			const header = document.getElementById('headnav');
			const topBanner = header ? header.querySelector('.header__topBanner') : null;
			const currentScrollY = window.scrollY;

			// Ensure header is fixed when scrolling (needed for transform to work properly)
			if (header && currentScrollY > 0) {
				header.style.position = 'fixed';
				header.style.top = '0';
				header.style.left = '0';
				header.style.width = '100%';
			}

			// Only apply hide/show if scrolled past a threshold (e.g., 50px)
			if (currentScrollY > 50) {
				if (currentScrollY > lastScrollY) {
					// Scrolling down - hide header and banner
					if (header) {
						header.classList.add('header--hidden');
					}
					if (topBanner) {
						topBanner.classList.add('header__topBanner--hidden');
						document.body.classList.add('banner-hidden');
					}
				} else {
					// Scrolling up - show header and banner
					if (header) {
						header.classList.remove('header--hidden');
					}
					if (topBanner) {
						topBanner.classList.remove('header__topBanner--hidden');
						document.body.classList.remove('banner-hidden');
					}
				}
			} else {
				// At top of page - always show and reset to absolute
				if (header) {
					header.classList.remove('header--hidden');
					header.style.position = 'absolute';
					header.style.top = '0';
				}
				if (topBanner) {
					topBanner.classList.remove('header__topBanner--hidden');
					document.body.classList.remove('banner-hidden');
				}
			}

			lastScrollY = currentScrollY;
			ticking = false;
		}

		window.addEventListener('scroll', () => {
			if (!ticking) {
				window.requestAnimationFrame(handleHeaderScroll);
				ticking = true;
			}
		});

		/**
		 * Initial progress line update
		 */
		window.addEventListener('load', updateProgressLine);
		window.addEventListener('resize', updateProgressLine);
	});
})();

