(function () {
	function initHeaderNav() {
		const headerShell = document.querySelector('.site-header-shell');
		const header = document.getElementById('masthead');
		const menuToggle = document.querySelector('.menu-toggle');
		const nav = document.getElementById('site-navigation');
		const menu = document.getElementById('primary-menu');

		if (!header || !menuToggle || !nav || !menu) {
			return;
		}

		const fixedNode = headerShell || header;
		const isFixed = fixedNode && fixedNode.getAttribute('data-fixed') === 'true';
		const isTransparentVariant = header.classList.contains('header--style-transparent');
		const logoMarkBreakpoint = headerShell ? parseInt(headerShell.getAttribute('data-logo-mark-breakpoint') || '1024', 10) : 1024;

		function setHeaderHeightVar() {
			if (!isFixed) {
				document.documentElement.style.removeProperty('--header-offset');
				return;
			}

			const headerHeight = fixedNode ? fixedNode.offsetHeight : header.offsetHeight;
			document.documentElement.style.setProperty('--header-offset', String(headerHeight) + 'px');
		}

		setHeaderHeightVar();
		window.addEventListener('resize', setHeaderHeightVar);
		window.addEventListener('load', setHeaderHeightVar);

		function updateLogoMarkState() {
			if (!document.body.classList.contains('has-logo-mark')) {
				return;
			}

			document.body.classList.toggle('logo-mark-mobile', window.innerWidth <= logoMarkBreakpoint);
		}

		updateLogoMarkState();
		window.addEventListener('resize', updateLogoMarkState);
		window.addEventListener('load', updateLogoMarkState);

		if (window.ResizeObserver && fixedNode) {
			const offsetObserver = new ResizeObserver(function () {
				setHeaderHeightVar();
			});
			offsetObserver.observe(fixedNode);
		}

		function updateScrolledState() {
			if (!isTransparentVariant || !isFixed) {
				return;
			}

			header.classList.toggle('is-scrolled', window.scrollY > 12);
		}

		updateScrolledState();
		window.addEventListener('scroll', function () {
			updateScrolledState();
			setHeaderHeightVar();
		});

		function setMenuState(open) {
			menuToggle.setAttribute('aria-expanded', String(open));
			nav.classList.toggle('is-open', open);
			document.body.classList.toggle('nav-is-open', open);
		}

		menuToggle.addEventListener('click', function () {
			const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
			setMenuState(!expanded);
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				setMenuState(false);
				menu.querySelectorAll('.menu-item.is-submenu-open').forEach(function (item) {
					item.classList.remove('is-submenu-open');
				});
			}
		});

		document.addEventListener('click', function (event) {
			if (!nav.classList.contains('is-open')) {
				return;
			}

			if (!header.contains(event.target)) {
				setMenuState(false);
			}
		});

		menu.querySelectorAll('.menu-item-has-children').forEach(function (item, index) {
			const link = item.querySelector(':scope > a');
			const submenu = item.querySelector(':scope > .sub-menu');

			if (!link || !submenu) {
				return;
			}

			const submenuId = 'submenu-' + String(index + 1);
			submenu.id = submenuId;

			const toggle = document.createElement('button');
			toggle.type = 'button';
			toggle.className = 'submenu-toggle';
			toggle.setAttribute('aria-expanded', 'false');
			toggle.setAttribute('aria-controls', submenuId);
			toggle.setAttribute('aria-label', 'Toggle submenu');

			item.insertBefore(toggle, submenu);

			toggle.addEventListener('click', function (event) {
				event.preventDefault();
				const expanded = toggle.getAttribute('aria-expanded') === 'true';
				toggle.setAttribute('aria-expanded', String(!expanded));
				item.classList.toggle('is-submenu-open', !expanded);
			});
		});

		menu.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
			anchor.addEventListener('click', function (event) {
				const href = anchor.getAttribute('href');
				if (!href || href.length < 2) {
					return;
				}

				const target = document.querySelector(href);
				if (!target) {
					return;
				}

				event.preventDefault();
				const offset = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--header-offset') || '0', 10) || 0;
				const top = target.getBoundingClientRect().top + window.scrollY - offset - 8;
				window.scrollTo({ top, behavior: 'smooth' });

				setMenuState(false);
				target.setAttribute('tabindex', '-1');
				target.focus({ preventScroll: true });
			});
		});
	}

	initHeaderNav();

	function initCarousels() {
		document.querySelectorAll('[data-carousel]').forEach(function (root) {
			const viewport = root.querySelector('[data-carousel-viewport]');
			const track = root.querySelector('[data-carousel-track]');
			const slides = root.querySelectorAll('[data-carousel-slide]');
			const prev = root.querySelector('[data-carousel-prev]');
			const next = root.querySelector('[data-carousel-next]');

			if (!viewport || !track || !slides.length) {
				return;
			}

			function getStep() {
				const first = slides[0];
				if (!first) {
					return viewport.clientWidth;
				}

				const style = window.getComputedStyle(track);
				const gap = parseFloat(style.columnGap || style.gap || '0') || 0;
				return first.getBoundingClientRect().width + gap;
			}

			if (prev) {
				prev.addEventListener('click', function () {
					track.scrollBy({ left: -getStep(), behavior: 'smooth' });
				});
			}

			if (next) {
				next.addEventListener('click', function () {
					track.scrollBy({ left: getStep(), behavior: 'smooth' });
				});
			}
		});
	}

	initCarousels();

	document.querySelectorAll('[data-modal-target]').forEach(function (trigger) {
		trigger.addEventListener('click', function (event) {
			event.preventDefault();
			const target = document.querySelector(trigger.getAttribute('data-modal-target'));
			if (!target) {
				return;
			}
			target.classList.add('is-open');
		});
	});

	document.querySelectorAll('[data-modal-close]').forEach(function (button) {
		button.addEventListener('click', function () {
			const modal = button.closest('.modal');
			if (modal) {
				modal.classList.remove('is-open');
			}
		});
	});

	document.querySelectorAll('.c-category-filter').forEach(function (filterRoot) {
		const buttons = filterRoot.querySelectorAll('[data-filter-term]');
		const taxonomy = filterRoot.getAttribute('data-filter-taxonomy');
		const postType = filterRoot.getAttribute('data-filter-post-type') || 'post';
		const targetId = filterRoot.getAttribute('data-filter-target') || 'archive-results';
		const target = document.getElementById(targetId);

		if (!buttons.length || !taxonomy || !target || !window.starterCoat) {
			return;
		}

		buttons.forEach(function (button) {
			button.addEventListener('click', function () {
				buttons.forEach(function (item) {
					item.classList.remove('is-active');
				});
				button.classList.add('is-active');

				const payload = new URLSearchParams();
				payload.set('action', 'starter_coat_filter_posts');
				payload.set('nonce', window.starterCoat.nonce);
				payload.set('postType', postType);
				payload.set('taxonomy', taxonomy);
				payload.set('term', button.getAttribute('data-filter-term') || 'all');

				fetch(window.starterCoat.ajaxUrl, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
					},
					body: payload.toString(),
				})
					.then(function (response) {
						return response.json();
					})
					.then(function (data) {
						if (data && data.success && data.data && data.data.html) {
							target.innerHTML = data.data.html;
						}
					});
			});
		});
	});
})();
