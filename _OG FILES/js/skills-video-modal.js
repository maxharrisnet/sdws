/**
 * Skills Video Modal
 * Handles gated video modals with HubSpot forms on Skills Function pages
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
		// Only run on skills function pages
		if (!document.querySelector('.skills-function')) {
			return;
		}

		setupVideoModal();

		// Pre-load HubSpot script (non-blocking)
		// If it fails, we'll handle it when modal opens
		loadHubSpotScript().catch(() => {
			console.log('ℹ️ HubSpot script not available on page load');
		});
	}

	/**
	 * Load HubSpot forms script with error handling
	 */
	function loadHubSpotScript() {
		// Check if script already exists
		if (document.querySelector('script[src*="js.hsforms.net"]')) {
			return Promise.resolve();
		}

		return new Promise((resolve, reject) => {
			const script = document.createElement('script');
			script.src = 'https://js.hsforms.net/forms/embed/v2.js';
			script.charset = 'utf-8';
			script.type = 'text/javascript';

			// Set timeout for script loading (5 seconds)
			const timeout = setTimeout(() => {
				console.warn('⚠️ HubSpot script loading timeout - likely blocked by ad blocker');
				reject(new Error('HubSpot script timeout'));
			}, 5000);

			script.onload = () => {
				clearTimeout(timeout);
				console.log('✅ HubSpot script loaded');
				resolve();
			};

			script.onerror = () => {
				clearTimeout(timeout);
				console.warn('⚠️ HubSpot script failed to load - likely blocked by ad blocker');
				reject(new Error('HubSpot script blocked'));
			};

			document.body.appendChild(script);
		});
	}

	/**
	 * Setup video modal functionality
	 */
	function setupVideoModal() {
		const modal = document.getElementById('skillVideoModal');
		const closeBtn = document.getElementById('closeSkillVideoModal');
		const videoIframe = document.getElementById('skillVideoIframe');
		const formContainer = document.getElementById('skillVideoForm');
		const videoPlayer = document.getElementById('skillVideoPlayer');
		const hubspotFormContainer = document.getElementById('skillVideoHubspotForm');

		if (!modal) {
			return;
		}

		let currentVideoUrl = '';
		let currentFormId = '';
		let formSubmitted = false;
		const hubspotAvailable = null; // null = unknown, true = available, false = blocked

		/**
		 * Open modal with video
		 *
		 * @param  videoUrl
		 * @param  hubspotFormId
		 */
		function openModal(videoUrl, hubspotFormId) {
			currentVideoUrl = videoUrl;
			currentFormId = hubspotFormId;
			formSubmitted = false;

			modal.style.display = 'flex';
			document.body.style.overflow = 'hidden';

			// If there's a HubSpot form ID, try to show the form first
			if (hubspotFormId && hubspotFormId.trim() !== '') {
				showForm();

				// Load HubSpot with fallback
				loadHubSpotScript()
					.then(() => {
						loadHubSpotForm(hubspotFormId);
					})
					.catch((error) => {
						console.warn('⚠️ HubSpot unavailable, showing video directly:', error.message);
						showHubSpotBlockedMessage();
						// Auto-show video after 3 seconds
						setTimeout(showVideo, 3000);
					});
			} else {
				// No form required, show video immediately
				showVideo();
			}
		}

		/**
		 * Close modal
		 */
		function closeModal() {
			modal.style.display = 'none';
			document.body.style.overflow = '';

			// Stop video
			if (videoIframe) {
				videoIframe.src = '';
			}

			// Reset form
			if (hubspotFormContainer) {
				hubspotFormContainer.innerHTML = '';
			}

			// Reset display states
			if (formContainer) {
				formContainer.style.display = 'none';
			}
			if (videoPlayer) {
				videoPlayer.style.display = 'none';
			}

			// Remove video styling from close button
			if (closeBtn) {
				closeBtn.classList.remove('skill-video-modal__close--video');
			}
		}

		/**
		 * Show form container
		 */
		function showForm() {
			if (formContainer) {
				formContainer.style.display = 'block';
			}
			if (videoPlayer) {
				videoPlayer.style.display = 'none';
			}
			// Remove video styling from close button
			if (closeBtn) {
				closeBtn.classList.remove('skill-video-modal__close--video');
			}
		}

		/**
		 * Show video container
		 */
		function showVideo() {
			if (formContainer) {
				formContainer.style.display = 'none';
			}
			if (videoPlayer) {
				videoPlayer.style.display = 'block';
			}

			// Add video styling to close button (blue circle)
			if (closeBtn) {
				closeBtn.classList.add('skill-video-modal__close--video');
			}

			// Load video with autoplay
			if (videoIframe && currentVideoUrl) {
				let videoUrl = currentVideoUrl;

				// Add autoplay parameter
				if (videoUrl.includes('?')) {
					videoUrl += '&autoplay=1';
				} else {
					videoUrl += '?autoplay=1';
				}

				videoIframe.src = videoUrl;
			}
		}

		/**
		 * Show message when HubSpot is blocked
		 */
		function showHubSpotBlockedMessage() {
			if (!hubspotFormContainer) {
				return;
			}

			hubspotFormContainer.innerHTML = `
				<div style="text-align: center; padding: 30px 20px;">
					<p style="font-size: 16px; color: #666; margin-bottom: 20px;">
						⚠️ <strong>Ad Blocker Detected</strong>
					</p>
					<p style="font-size: 14px; color: #666; line-height: 1.6; margin-bottom: 20px;">
						We use HubSpot forms to manage content access, but it appears to be blocked by your browser or an extension.
					</p>
					<p style="font-size: 14px; color: #333; font-weight: 600; margin-bottom: 15px;">
						Loading video in 3 seconds...
					</p>
					<button id="skipFormButton" style="
						background: #00619e;
						color: white;
						border: none;
						padding: 12px 24px;
						border-radius: 4px;
						font-size: 14px;
						font-weight: 600;
						cursor: pointer;
						transition: background 0.2s ease;
					">
						Skip & Watch Now
					</button>
				</div>
			`;

			// Add click handler for skip button
			const skipButton = document.getElementById('skipFormButton');
			if (skipButton) {
				skipButton.addEventListener('click', showVideo);
				skipButton.addEventListener('mouseenter', function () {
					this.style.background = '#004c7a';
				});
				skipButton.addEventListener('mouseleave', function () {
					this.style.background = '#00619e';
				});
			}
		}

		/**
		 * Load HubSpot form with error handling
		 *
		 * @param  formId
		 */
		function loadHubSpotForm(formId) {
			if (!window.hbspt) {
				console.error('🔴 HubSpot script not loaded');
				showHubSpotBlockedMessage();
				setTimeout(showVideo, 3000);
				return;
			}

			// Clear previous form
			if (hubspotFormContainer) {
				hubspotFormContainer.innerHTML = '';
			}

			try {
				// Create form with timeout
				const formTimeout = setTimeout(() => {
					console.warn('⚠️ HubSpot form creation timeout');
					showHubSpotBlockedMessage();
					setTimeout(showVideo, 3000);
				}, 5000);

				window.hbspt.forms.create({
					portalId: '4455954', // Your HubSpot portal ID
					formId,
					target: '#skillVideoHubspotForm',
					onFormReady($form) {
						clearTimeout(formTimeout);
						console.log('✅ HubSpot form ready');
					},
					onFormSubmit($form) {
						clearTimeout(formTimeout);
						console.log('✅ Form submitted');
						formSubmitted = true;

						// Short delay to allow form processing
						setTimeout(function () {
							showVideo();
						}, 500);
					},
				});
			} catch (error) {
				console.error('🔴 HubSpot form error:', error);
				showHubSpotBlockedMessage();
				setTimeout(showVideo, 3000);
			}
		}

		/**
		 * Attach click handlers to video thumbnails
		 */
		function attachThumbnailHandlers() {
			const thumbnails = document.querySelectorAll('.skill-content__video-thumbnail');

			thumbnails.forEach(function (thumbnail) {
				// Skip if already has handler
				if (thumbnail.hasAttribute('data-handler-attached')) {
					return;
				}

				thumbnail.setAttribute('data-handler-attached', 'true');

				thumbnail.addEventListener('click', function (e) {
					e.preventDefault();

					const videoUrl = thumbnail.getAttribute('data-video-url');
					const hubspotFormId = thumbnail.getAttribute('data-hubspot-form');

					if (videoUrl) {
						openModal(videoUrl, hubspotFormId);
					}
				});

				// Keyboard accessibility
				thumbnail.addEventListener('keydown', function (e) {
					if (e.key === 'Enter' || e.key === ' ') {
						e.preventDefault();
						thumbnail.click();
					}
				});
			});
		}

		/**
		 * Close button handler
		 */
		if (closeBtn) {
			closeBtn.addEventListener('click', closeModal);
		}

		/**
		 * Click outside to close
		 */
		if (modal) {
			modal.addEventListener('click', function (e) {
				if (e.target === modal || e.target.classList.contains('skill-video-modal__overlay')) {
					closeModal();
				}
			});
		}

		/**
		 * Escape key to close
		 */
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && modal.style.display === 'flex') {
				closeModal();
			}
		});

		// Attach handlers immediately and after tab switches
		attachThumbnailHandlers();

		// Re-attach handlers when tabs are switched
		const tabs = document.querySelectorAll('.skills-function__tab');
		if (tabs.length > 0) {
			tabs.forEach(function (tab) {
				tab.addEventListener('click', function () {
					setTimeout(attachThumbnailHandlers, 100);
				});
			});
		}
	}
})();
