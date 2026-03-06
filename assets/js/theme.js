(function () {
	const menuToggle = document.querySelector('.menu-toggle');
	const nav = document.getElementById('site-navigation');

	if (menuToggle && nav) {
		menuToggle.addEventListener('click', function () {
			const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
			menuToggle.setAttribute('aria-expanded', String(!expanded));
			nav.classList.toggle('is-open', !expanded);
		});
	}

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
