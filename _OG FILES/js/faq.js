(function () {
	function toggleItem(trigger) {
		if (!trigger) return;
		var panelId = trigger.getAttribute('aria-controls');
		var panel = document.getElementById(panelId);
		if (!panel) return;

		var isOpen = trigger.getAttribute('aria-expanded') === 'true';
		trigger.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
		panel.hidden = isOpen;
		var icon = trigger.querySelector('.faq__icon');
		if (icon) {
			icon.textContent = isOpen ? '\u2304' : '\u2303';
			icon.classList.toggle('up', !isOpen);
			icon.classList.toggle('down', isOpen);
		}
	}

	function onClick(evt) {
		var trigger = evt.target.closest('.faq__question');
		if (!trigger) return;
		toggleItem(trigger);
	}

	function onKeydown(evt) {
		if (evt.key !== 'Enter' && evt.key !== ' ') return;
		var trigger = evt.target.closest('.faq__question');
		if (!trigger) return;
		evt.preventDefault();
		toggleItem(trigger);
	}

	document.addEventListener('DOMContentLoaded', function () {
		var roots = document.querySelectorAll('[data-faq-root]');
		roots.forEach(function (root) {
			root.addEventListener('click', onClick);
			root.addEventListener('keydown', onKeydown);
		});
	});
})();
