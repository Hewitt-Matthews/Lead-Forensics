const testimonialsSwiper = new Swiper('.testimonial-swiper', {
  	// Optional parameters
	slidesPerView: "auto",
	spaceBetween: 30,
	centeredSlides: true,
	observer: true,
	observeParents: true,
	navigation: {
	  	nextEl: ".swiper-button-next",
		prevEl: ".swiper-button-prev",
	},
	// scrollbar: {
	// 	el: ".swiper-scrollbar",
	// },
});

const logoSwiper = new Swiper('.client-logos-container', {
  	// Optional parameters
  	loop: true,
	slidesPerView: "auto",
	observer: true,
	observeParents: true,
 	spaceBetween: 10,
	allowTouchMove: false,
	grabCursor: false,
	freeMode: true,
	autoplay: {
	  	delay: 1,
		pauseOnMouseEnter: false,
		waitForTransition: false
	},
	speed: 5000,
	breakpoints: {
		640: {
			slidesPerView: "auto",
			spaceBetween: 20,
		},
		768: {
			slidesPerView: "auto",
			spaceBetween: 30,
		},
	},
});

const caseStudyTopSwiper = new Swiper('.case-study-swiper.top', {
  	// Optional parameters
	loop: true,
	freeMode: true,
	autoplay: {
		delay: 1,
		disableOnInteraction: false,
		pauseOnMouseEnter: false
	},
	speed: 5000,
	spaceBetween: 50,
	grabCursor: true,
	observer: true,
	observeParents: true,
	slidesPerView: 1,
	allowTouchMove: false,
	grabCursor: false,
	breakpoints: {
		640: {
			slidesPerView: 2,
			spaceBetween: 20,
		},
		768: {
			slidesPerView: 4,
			spaceBetween: 30,
		},
		980: {
			slidesPerView: 5,
			spaceBetween: 30,
		},
	},
	freeModeMomentum: false
});

const caseStudyBottomSwiper = new Swiper('.case-study-swiper.bottom', {
  	// Optional parameters
	loop: true,
	freeMode: true,
	autoplay: {
		delay: 1,
		disableOnInteraction: false,
		pauseOnMouseEnter: false
	},
	speed: 5000,
	spaceBetween: 50,
	grabCursor: true,
	observer: true,
	observeParents: true,
	slidesPerView: 1,
	allowTouchMove: false,
	grabCursor: false,
	breakpoints: {
		640: {
			slidesPerView: 2,
			spaceBetween: 20,
		},
		768: {
			slidesPerView: 4,
			spaceBetween: 30,
		},
		980: {
			slidesPerView: 5,
			spaceBetween: 30,
		},
	},
	freeModeMomentum: false
});