document.addEventListener('DOMContentLoaded', () => {
	const slides = document.querySelectorAll('.logo-carousel .logo-slide');
	let index = 0;

	if (slides.length > 0) {
		slides[index].classList.add('active');

		setInterval(() => {
			slides[index].classList.remove('active');
			index = (index + 1) % slides.length;
			slides[index].classList.add('active');
		}, 3000);
	}
});
