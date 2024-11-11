const splideLogoSlider = () => {
	const logoSlider = new Splide( '.splide', {
		type     : 'loop',
		autoWidth: true,
		pauseOnHover: false,
		pauseOnFocus: false,
// 		lazyLoad: 'sequential',
		drag: false,
		autoScroll: {
			speed: 2,
		},
	} );
	
	logoSlider.mount(window.splide.Extensions);
}

window.addEventListener('load', splideLogoSlider);

const caseStudyTopSwiper = () => {
	const topSlider = new Splide( '.case-study-swiper.top', {
		type     : 'loop',
		autoWidth: true,
		gap: "2em",
		pauseOnHover: false,
		pauseOnFocus: false,
		drag: false,
		autoScroll: {
			speed: 2,
		},
	} );
	
	topSlider.mount(window.splide.Extensions);
}

window.addEventListener('load', caseStudyTopSwiper);


const caseStudyBottomSwiper = () => {
	const bottomSlider = new Splide( '.case-study-swiper.bottom', {
		type     : 'loop',
		autoWidth: true,
		direction: 'rtl',
		gap: "2em",
		pauseOnHover: false,
		pauseOnFocus: false,
		drag: false,
		autoScroll: {
			speed: 2,
		},
	} );
	
	bottomSlider.mount(window.splide.Extensions);
}

window.addEventListener('load', caseStudyBottomSwiper);