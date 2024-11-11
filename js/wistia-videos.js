const initWisita = () => {
	
	// This function is for the webinar pages where advanced play/pause functionality is required
	const globalWistiaFunction = () => {
	
		const playVideoBtn = document.querySelector('#play-video');
		const webinarPlayVideoBtn = document.querySelector('#play-video-scroll');
		const imagePlayBtn = document.querySelector('.video-container .image-overlay');
		const videoID = document.querySelector('.video-container').dataset.videoid;
		const imageOverlay = document.querySelector('.video-container .image-overlay');

		const video = Wistia.api(videoID);
		

		//Wistia Safari Error Fallback
		if(!video) {

			playVideoBtn.remove();

			if(webinarPlayVideoBtn) {
				webinarPlayVideoBtn.remove();
			}

			imageOverlay.addEventListener('click', () => {
				imageOverlay.remove();
			});


			return;
		} else {

			// Play/Pause Video when either button is clicked
			const toggleVideo = (e) => {
				e.preventDefault();

				if(e.target.id == 'play-video-scroll') {
					document.querySelector('#main-content').scrollIntoView();
				}

				if (imageOverlay) {
					imageOverlay.remove();
				}

				if (video.state() === "playing") {
					video.pause();

					if(document.body.classList.contains('single-webinars')) {
						playVideoBtn.innerText = 'Watch now';
					} else {
						playVideoBtn.innerText = 'Watch now';
					}

					if(webinarPlayVideoBtn) {
						webinarPlayVideoBtn.innerText = 'Watch now';
					}
				} else {
					video.play();

					if(document.body.classList.contains('single-webinars')) {
						playVideoBtn.innerText = 'Pause';
					} else {
						playVideoBtn.innerText = 'Pause';
					}

					if(webinarPlayVideoBtn) {
						webinarPlayVideoBtn.innerText = 'Pause recording';
					}
				}

			}
			

			video.bind("silentplaybackmodechange", function (inSilentPlaybackMode) {
				console.log("Is 'Click For Sound' visible?", inSilentPlaybackMode ? "yes" : "no");

				video.bind("secondchange", function(s) {
				  if (s === 3) {
					video.pause();
				  }
				});

			});

			//Change the button text if video is paused using video controls
			video.bind("pause", function() {

				if(document.body.classList.contains('single-webinars')) {
					playVideoBtn.innerText = 'Watch now';
				} else {
					playVideoBtn.innerText = 'Watch now';
				}

				if(webinarPlayVideoBtn) {
					webinarPlayVideoBtn.innerText = 'Watch now';
				}
			});

			//Change the button text if video is played using video controls
			video.bind("play", function() {

				if(document.body.classList.contains('single-webinars')) {
					playVideoBtn.innerText = 'Pause';
				} else {
					playVideoBtn.innerText = 'Pause';
				}

				if(webinarPlayVideoBtn) {
					webinarPlayVideoBtn.innerText = 'Pause';
				}
			});

			imagePlayBtn.addEventListener('click', toggleVideo);
			imagePlayBtn.addEventListener('touchstart', toggleVideo);
			playVideoBtn.addEventListener('click', toggleVideo);
			playVideoBtn.addEventListener('touchstart', toggleVideo);

			if(webinarPlayVideoBtn) {
				webinarPlayVideoBtn.addEventListener('click', toggleVideo);
				webinarPlayVideoBtn.addEventListener('touchstart', toggleVideo);
			}

		}
		
	}
		
	// This function is for the homepage to inject iframe in for more efficiency
	const wistiaHomeFunction = () => {
		const wistiaVideo = document.querySelector( ".wistia" );
		const videoThumbnailURL = wistiaVideo.dataset.thumb;
		const playButton = document.querySelector( "#play-video" );

		let image = new Image();
		image.src = videoThumbnailURL;

		image.addEventListener( "load", function() {
			wistiaVideo.appendChild( image );
		} () );

		const initVideo = (e) => {
			
			e.preventDefault();
			
			var iframe = document.createElement( "iframe" );

			iframe.setAttribute( "frameborder", "0" );
			iframe.setAttribute( "allowfullscreen", "" );
			iframe.setAttribute( "mozallowfullscreen", "" );
			iframe.setAttribute( "webkitallowfullscreen", "" );
			iframe.setAttribute( "oallowfullscreen", "" );
			iframe.setAttribute( "msallowfullscreen", "" );
			iframe.setAttribute( "src", "//fast.wistia.net/embed/iframe/"+ wistiaVideo.dataset.embed +"?videoFoam=true" );

			wistiaVideo.innerHTML = "";
			wistiaVideo.appendChild( iframe );
			
		}
		
		wistiaVideo.addEventListener( "click", initVideo);    
		playButton.addEventListener( "click", initVideo);
		
	}
	
	const current = window.location.pathname;

	if (current == '/') {
	  wistiaHomeFunction();
	} else {
	  globalWistiaFunction();
	}
	
	
}

window.addEventListener('load', initWisita)