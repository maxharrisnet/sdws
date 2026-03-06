/**
 * AeraHub 2025 London On-Demand Page
 * HubSpot form (London form ID), multiple video popups, overlay, smooth scroll
 */
(function () {
	'use strict';

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}

	function init() {
		setupHubSpotForm();
		setupFormOverlay();
		setupVideoPopups();
		setupSmoothScroll();
	}

	function setupHubSpotForm() {
		const script = document.createElement('script');
		script.src = 'https://js.hsforms.net/forms/embed/v2.js';
		document.body.appendChild(script);

		script.addEventListener('load', () => {
			if (window.hbspt) {
				window.hbspt.forms.create({
					portalId: '4455954',
					formId: '5348ec0a-1785-4bdf-a47a-fe7e779a4e1a',
					sfdcCampaignId: '701Rb00000Oi4BvIAJ',
					target: '#stickyform',
					onFormSubmit() {
						const overlay = document.getElementById('hideMe');
						const removeBlurr = document.getElementById('removeBlurr');
						if (overlay) overlay.style.display = 'none';
						if (removeBlurr) removeBlurr.style.filter = 'blur(0px)';
					},
				});
			}
		});
	}

	function setupFormOverlay() {
		const params = new URLSearchParams(window.location.search);
		const direct = params.get('access') === 'direct';
		const overlay = document.getElementById('hideMe');
		const removeBlurr = document.getElementById('removeBlurr');

		if (!overlay) return;

		if (direct) {
			overlay.style.display = 'none';
			if (removeBlurr) removeBlurr.style.filter = 'blur(0px)';
			document.body.style.height = '';
			document.body.style.overflowX = '';
		} else {
			overlay.style.display = 'block';
			if (removeBlurr) removeBlurr.style.filter = 'blur(8px)';
			document.body.style.height = '100vh';
			document.body.style.overflowX = 'hidden';
		}
	}

	function setupVideoPopups() {
		const popups = [
			{ openId: 'openPopupUnilever', closeId: 'closePopupUnilever', popupId: 'videoPopupUnilever', iframeId: 'vimeoVideoUnilever' },
			{ openId: 'openPopupPMI', closeId: 'closePopupPMI', popupId: 'videoPopupPMI', iframeId: 'vimeoVideoPMI' },
			{ openId: 'openPopupCastrol', closeId: 'closePopupCastrol', popupId: 'videoPopupCastrol', iframeId: 'vimeoVideoCastrol' },
			{ openId: 'openPopupFred', closeId: 'closePopupFred', popupId: 'videoPopupFred', iframeId: 'vimeoVideoFred' },
			{ openId: 'openPopupAccenture', closeId: 'closePopupAccenture', popupId: 'videoPopupAccenture', iframeId: 'vimeoVideoAccenture' },
			{ openId: 'openPopupAstraZeneca', closeId: 'closePopupAstraZeneca', popupId: 'videoPopupAstraZeneca', iframeId: 'vimeoVideoAstraZeneca' },
		];

		popups.forEach(({ openId, closeId, popupId, iframeId }) => {
			const openBtn = document.getElementById(openId);
			const closeBtn = document.getElementById(closeId);
			const popup = document.getElementById(popupId);
			const iframe = document.getElementById(iframeId);

			if (!openBtn || !popup || !iframe) return;

			function openPopup() {
				popup.style.display = 'flex';
				popup.setAttribute('aria-hidden', 'false');
				const src = iframe.src;
				iframe.src = src.indexOf('autoplay=1') === -1 ? src + (src.indexOf('?') !== -1 ? '&' : '?') + 'autoplay=1' : src;
			}

			function closePopup() {
				popup.style.display = 'none';
				popup.setAttribute('aria-hidden', 'true');
				iframe.src = iframe.src.replace('&autoplay=1', '').replace('?autoplay=1', '');
			}

			openBtn.addEventListener('click', (e) => {
				e.preventDefault();
				openPopup();
			});
			if (closeBtn) closeBtn.addEventListener('click', closePopup);
			popup.addEventListener('click', (e) => {
				if (e.target === popup) closePopup();
			});
		});
	}

	function setupSmoothScroll() {
		const register = document.getElementById('register');
		const keynote = document.getElementById('keynote');
		if (register && keynote) {
			register.addEventListener('click', (e) => {
				e.preventDefault();
				keynote.scrollIntoView({ behavior: 'smooth', block: 'start' });
			});
		}
	}
})();
