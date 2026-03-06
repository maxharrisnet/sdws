(function () {
	const page = document.querySelector('.landing-page');
	if (!page) {
		return;
	}

	const carousel = page.querySelector('[data-carousel]');
	const prevButton = page.querySelector('[data-carousel-prev]');
	const nextButton = page.querySelector('[data-carousel-next]');
	if (!carousel || !prevButton || !nextButton) {
		return;
	}

	const state = {
		currentIndex: 0,
		perView: 3,
		gapPx: 24,
		isTransitioning: true,
	};

	const getOriginalItems = () => Array.from(carousel.children).filter((item) => !item.dataset.clone);

	const updateCarouselLayout = () => {
		const w = window.innerWidth || 1024;
		if (w <= 720) {
			state.perView = 1;
			state.gapPx = 15;
		} else if (w <= 960) {
			state.perView = 2;
			state.gapPx = 20;
		} else {
			state.perView = 3;
			state.gapPx = 24;
		}

		Array.from(carousel.querySelectorAll('[data-clone="true"]')).forEach((node) => node.remove());

		const originals = getOriginalItems();
		if (!originals.length) {
			return;
		}

		const clones = originals.slice(0, state.perView).map((item) => {
			const clone = item.cloneNode(true);
			clone.dataset.clone = 'true';
			return clone;
		});
		clones.forEach((clone) => carousel.appendChild(clone));

		if (state.currentIndex >= originals.length) {
			state.currentIndex = 0;
		}

		applyTransform();
	};

	const applyTransform = () => {
		carousel.style.transition = state.isTransitioning ? 'transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)' : 'none';
		carousel.style.transform = `translateX(calc(-${state.currentIndex} * (100% / ${state.perView} + ${state.gapPx}px / ${state.perView})))`;
	};

	const handleNext = () => {
		const originals = getOriginalItems();
		if (originals.length <= 1) {
			return;
		}

		state.currentIndex += 1;
		state.isTransitioning = true;
		applyTransform();

		if (state.currentIndex >= originals.length) {
			setTimeout(() => {
				state.currentIndex = 0;
				state.isTransitioning = false;
				applyTransform();
			}, 500);
		}
	};

	const handlePrev = () => {
		const originals = getOriginalItems();
		if (originals.length <= 1) {
			return;
		}

		if (state.currentIndex === 0) {
			state.currentIndex = originals.length;
			state.isTransitioning = false;
			applyTransform();
			setTimeout(() => {
				state.currentIndex = originals.length - 1;
				state.isTransitioning = true;
				applyTransform();
			}, 50);
			return;
		}

		state.currentIndex -= 1;
		state.isTransitioning = true;
		applyTransform();
	};

	let touchStartX = 0;
	let touchStartY = 0;

	carousel.addEventListener('touchstart', (event) => {
		const touch = event.touches && event.touches[0];
		if (!touch) {
			return;
		}
		touchStartX = touch.clientX;
		touchStartY = touch.clientY;
	});

	carousel.addEventListener('touchend', (event) => {
		const touch = event.changedTouches && event.changedTouches[0];
		if (!touch) {
			return;
		}
		const deltaX = touch.clientX - touchStartX;
		const deltaY = touch.clientY - touchStartY;
		if (Math.abs(deltaX) < 40 || Math.abs(deltaX) < Math.abs(deltaY)) {
			return;
		}
		if (deltaX > 0) {
			handlePrev();
		} else {
			handleNext();
		}
	});

	prevButton.addEventListener('click', handlePrev);
	nextButton.addEventListener('click', handleNext);

	updateCarouselLayout();
	window.addEventListener('resize', updateCarouselLayout);
})();
