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
			const originalSlides = Array.from(root.querySelectorAll('[data-carousel-slide]'));
			const prev = root.querySelector('[data-carousel-prev]');
			const next = root.querySelector('[data-carousel-next]');
			const dots = Array.from(root.querySelectorAll('[data-carousel-dot]'));
			const isTestimonials = root.classList.contains('c-carousel--testimonials');
			const isLooping = originalSlides.length > 1;
			const originalCount = originalSlides.length;
			let slides = originalSlides.slice();
			let currentRealIndex = 0;
			let currentPhysicalIndex = 0;
			let scrollEndTimer;

			if (!viewport || !track || !originalSlides.length) {
				return;
			}

			if (isLooping) {
				const leadClone = originalSlides[originalSlides.length - 1].cloneNode(true);
				const tailClone = originalSlides[0].cloneNode(true);

				leadClone.setAttribute('data-carousel-clone', 'true');
				leadClone.setAttribute('data-origin-index', String(originalSlides.length - 1));
				tailClone.setAttribute('data-carousel-clone', 'true');
				tailClone.setAttribute('data-origin-index', '0');

				track.insertBefore(leadClone, originalSlides[0]);
				track.appendChild(tailClone);

				slides = Array.from(track.querySelectorAll('[data-carousel-slide]'));
			}

			originalSlides.forEach(function (slide, index) {
				slide.setAttribute('data-origin-index', String(index));
			});

			function clampIndex(index) {
				return Math.max(0, Math.min(slides.length - 1, index));
			}

			function realToPhysicalIndex(realIndex) {
				if (!isLooping) {
					return clampIndex(realIndex);
				}

				return clampIndex(realIndex + 1);
			}

			function physicalToRealIndex(physicalIndex) {
				if (!isLooping) {
					return clampIndex(physicalIndex);
				}

				if (physicalIndex <= 0) {
					return originalCount - 1;
				}

				if (physicalIndex >= slides.length - 1) {
					return 0;
				}

				return physicalIndex - 1;
			}

			function getSlideCenter(index) {
				const slide = slides[index];
				if (!slide) {
					return 0;
				}

				return slide.offsetLeft + slide.offsetWidth / 2;
			}

			function getTargetScrollLeft(index) {
				const maxScroll = Math.max(0, track.scrollWidth - viewport.clientWidth);
				const raw = getSlideCenter(index) - viewport.clientWidth / 2;
				return Math.min(Math.max(raw, 0), maxScroll);
			}

			function getClosestPhysicalIndex() {
				const viewportCenter = track.scrollLeft + viewport.clientWidth / 2;
				let closestIndex = 0;
				let closestDistance = Number.POSITIVE_INFINITY;

				slides.forEach(function (slide, index) {
					const center = slide.offsetLeft + slide.offsetWidth / 2;
					const distance = Math.abs(center - viewportCenter);
					if (distance < closestDistance) {
						closestDistance = distance;
						closestIndex = index;
					}
				});

				return closestIndex;
			}

			function updateUI(realIndex) {
				currentRealIndex = Math.max(0, Math.min(originalCount - 1, realIndex));

				slides.forEach(function (slide) {
					const originIndex = parseInt(slide.getAttribute('data-origin-index') || '-1', 10);
					slide.classList.toggle('is-active', originIndex === currentRealIndex);
				});

				dots.forEach(function (dot, dotIndex) {
					dot.setAttribute('aria-current', String(dotIndex === currentRealIndex));
				});

				if (prev) {
					prev.disabled = !isLooping && currentRealIndex <= 0;
				}

				if (next) {
					next.disabled = !isLooping && currentRealIndex >= originalCount - 1;
				}
			}

			function goToPhysicalIndex(index, behavior) {
				currentPhysicalIndex = clampIndex(index);
				track.scrollTo({ left: getTargetScrollLeft(currentPhysicalIndex), behavior: behavior || 'smooth' });
				updateUI(physicalToRealIndex(currentPhysicalIndex));
			}

			function normalizeLoopEdges() {
				if (!isLooping) {
					return;
				}

				if (currentPhysicalIndex === 0) {
					goToPhysicalIndex(realToPhysicalIndex(originalCount - 1), 'auto');
					return;
				}

				if (currentPhysicalIndex === slides.length - 1) {
					goToPhysicalIndex(realToPhysicalIndex(0), 'auto');
				}
			}

			if (prev) {
				prev.addEventListener('click', function () {
					goToPhysicalIndex(currentPhysicalIndex - 1);
				});
			}

			if (next) {
				next.addEventListener('click', function () {
					goToPhysicalIndex(currentPhysicalIndex + 1);
				});
			}

			dots.forEach(function (dot) {
				dot.addEventListener('click', function () {
					const index = parseInt(dot.getAttribute('data-slide-index') || '0', 10);
					goToPhysicalIndex(realToPhysicalIndex(index));
				});
			});

			track.addEventListener('scroll', function () {
				window.clearTimeout(scrollEndTimer);
				scrollEndTimer = window.setTimeout(function () {
					currentPhysicalIndex = getClosestPhysicalIndex();
					normalizeLoopEdges();
					updateUI(physicalToRealIndex(currentPhysicalIndex));
				}, 90);
			});

			window.addEventListener('resize', function () {
				goToPhysicalIndex(realToPhysicalIndex(currentRealIndex), 'auto');
			});

			const startRealIndex = isTestimonials && originalCount > 1 ? 1 : 0;
			goToPhysicalIndex(realToPhysicalIndex(startRealIndex), 'auto');
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
