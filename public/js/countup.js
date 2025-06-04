const counters = document.querySelectorAll('.countup');
counters.forEach(counter => {
	const target = parseInt(counter.getAttribute('data-target'));
	let current = 0;
	const increment = target / 100;

	const updateCount = () => {
		if (current < target) {
			current = Math.min(current + increment, target);
			counter.innerText = Math.floor(current);
			requestAnimationFrame(updateCount);
		} else
			counter.innerText = target;
	};

	requestAnimationFrame(updateCount);
});
