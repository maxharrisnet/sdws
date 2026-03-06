/**
 * AeraHub 2025 Page Scripts
 * Handles HubSpot form, video popup, and form overlay logic
 */

(function () {
	'use strict';

	// Wait for DOM to be ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}

	function init() {
		setupHubSpotForm();
		setupFormOverlay();
		setupVideoPopup();
		setupSmoothScroll();
		hideNavigation();
	}

	/**
	 * Initialize HubSpot form
	 */
	function setupHubSpotForm() {
		const script = document.createElement('script');
		script.src = 'https://js.hsforms.net/forms/embed/v2.js';
		document.body.appendChild(script);

		script.addEventListener('load', () => {
			if (window.hbspt) {
				window.hbspt.forms.create({
					portalId: '4455954',
					formId: '097ee201-0440-4b59-a68e-d682966a8e08',
					target: '#stickyform',
					onFormSubmit($form) {
						const overlay = document.getElementById('hideMe');
						const removeBlurr = document.getElementById('removeBlurr');
						if (overlay) {
							overlay.style.display = 'none';
						}
						if (removeBlurr) {
							removeBlurr.style.filter = 'blur(0px)';
						}
					},
				});
			}
		});
	}

	/**
	 * Setup form overlay based on URL parameter
	 */
	function setupFormOverlay() {
		const searchParams = new URLSearchParams(window.location.search);
		const paramId = searchParams.get('access');
		const overlay = document.getElementById('hideMe');
		const removeBlurr = document.getElementById('removeBlurr');

		if (overlay) {
			if (paramId === 'direct') {
				// Direct access: keep overlay hidden and un-blur the page
				overlay.style.display = 'none';
				if (removeBlurr) {
					removeBlurr.style.filter = 'blur(0px)';
				}
				document.body.style.height = '';
				document.body.style.overflowX = 'inherit';
			} else {
				// No direct param: show the gated overlay
				overlay.style.display = 'block';
				if (removeBlurr) {
					removeBlurr.style.filter = 'blur(8px)';
				}
				document.body.style.height = '100vh';
				document.body.style.overflowX = 'hidden';
			}
		}
	}

	/**
	 * Setup video popup functionality
	 */
	function setupVideoPopup() {
		const closeBtn = document.getElementById('closePopup');
		const videoPopupEl = document.getElementById('videoPopup');
		const vimeoIframe = document.getElementById('vimeoVideo');

		if (!videoPopupEl || !vimeoIframe) {
			return;
		}

		// Store vimeoPlayer in a persistent scope
		let vimeoPlayer = null;
		let vimeoScriptLoaded = false;

		// Load Vimeo Player API script if not already loaded
		const loadVimeoScript = () => {
			if (window.Vimeo) {
				vimeoScriptLoaded = true;
				return Promise.resolve();
			}

			if (vimeoScriptLoaded) {
				return Promise.resolve();
			}

			return new Promise((resolve) => {
				const vimeoScript = document.createElement('script');
				vimeoScript.src = 'https://player.vimeo.com/api/player.js';
				vimeoScript.onload = () => {
					vimeoScriptLoaded = true;
					resolve();
				};
				vimeoScript.onerror = () => {
					console.warn('Failed to load Vimeo Player API');
					resolve(); // Resolve anyway to not block
				};
				document.body.appendChild(vimeoScript);
			});
		};

		// Initialize Vimeo Player instance
		const initVimeoPlayer = () => {
			if (vimeoPlayer) {
				return vimeoPlayer;
			}

			try {
				if (window.Vimeo && vimeoIframe) {
					vimeoPlayer = new window.Vimeo.Player(vimeoIframe);
					return vimeoPlayer;
				}
			} catch (err) {
				console.warn('Failed to initialize Vimeo Player', err);
			}

			return null;
		};

		// Helper to close popup and cleanup
		const closeVideoPopup = () => {
			if (videoPopupEl) {
				videoPopupEl.style.display = 'none';
			}
			if (vimeoPlayer && typeof vimeoPlayer.pause === 'function') {
				vimeoPlayer.pause().catch(() => {});
			}
			if (vimeoIframe) {
				vimeoIframe.src = '';
			}
			// Don't set vimeoPlayer to null - keep the instance for reuse
		};

		// Helper to open popup with a given src
		window.openVideoPopup = function (src) {
			if (!vimeoIframe || !videoPopupEl) {
				return;
			}

			// Normalize src: remove any existing autoplay then add autoplay=1
			let normalized = src.replace(/(&|\?)autoplay=1/g, '');
			normalized = normalized.replace(/&amp;/g, '&');
			normalized += normalized.includes('?') ? '&autoplay=1' : '?autoplay=1';
			vimeoIframe.src = normalized;
			videoPopupEl.style.display = 'flex';

			// Load script and initialize player
			loadVimeoScript().then(() => {
				const player = initVimeoPlayer();
				if (player && typeof player.play === 'function') {
					player.play().catch(() => {});
				}
			});
		};

		// Close handler
		if (closeBtn) {
			closeBtn.addEventListener('click', closeVideoPopup);
		}

		// Click outside to close
		if (videoPopupEl) {
			videoPopupEl.addEventListener('click', (e) => {
				if (e.target === videoPopupEl) {
					closeVideoPopup();
				}
			});
		}

		// Attach click handlers to speaker images
		// Use a more flexible selector and wait for DOM to be ready
		const attachVideoHandlers = () => {
			try {
				const speakerImgs = document.querySelectorAll('.aerahub-2025__keynoteCol1 img[data-vimeo-src]');
				speakerImgs.forEach((img) => {
					// Skip if already has handler
					if (img.hasAttribute('data-video-handler-attached')) {
						return;
					}

					img.style.cursor = 'pointer';
					img.setAttribute('tabindex', '0');
					img.setAttribute('role', 'button');
					img.setAttribute('aria-label', 'Play video');
					img.setAttribute('data-video-handler-attached', 'true');

					img.addEventListener('click', (ev) => {
						const src = img.getAttribute('data-vimeo-src') || img.getAttribute('data-src');
						if (src && window.openVideoPopup) {
							window.openVideoPopup(src);
						}
					});

					img.addEventListener('keydown', (ev) => {
						if (ev.key === 'Enter' || ev.key === ' ') {
							ev.preventDefault();
							img.click();
						}
					});
				});
			} catch (err) {
				console.warn('Could not attach speaker image video handlers', err);
			}
		};

		// Attach handlers immediately and also after a short delay for dynamically loaded content
		attachVideoHandlers();
		setTimeout(attachVideoHandlers, 500);
	}

	/**
	 * Setup smooth scroll for "Watch On-Demand" button
	 */
	function setupSmoothScroll() {
		const onDemandBtn = document.getElementById('onDemandBtn');
		const onDemandSection = document.getElementById('onDemandSection');

		if (onDemandBtn && onDemandSection) {
			onDemandBtn.addEventListener('click', (e) => {
				e.preventDefault();
				const offset = 120;
				const elementPosition = onDemandSection.getBoundingClientRect().top;
				const offsetPosition = elementPosition + window.pageYOffset - offset;

				window.scrollTo({
					top: offsetPosition,
					behavior: 'smooth',
				});
			});
		}
	}

	/**
	 * Hide navigation on AeraHub page
	 */
	function hideNavigation() {
		const headnav = document.getElementById('headnav');
		const aeraLogo = document.getElementById('aeraLogo');
		if (headnav) {
			headnav.style.display = 'none';
		}
		if (aeraLogo) {
			aeraLogo.style.display = 'none';
		}
	}
})();
