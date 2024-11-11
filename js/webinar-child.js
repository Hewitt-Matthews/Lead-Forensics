const initWebinars = () => {
	
	const transriptToggle = document.querySelector('#view-transcript');
	const transcript = document.querySelector('#webinar-transcript');


	let height = 0;

	const transcriptChildren = [...transcript.children]	

	transcriptChildren.forEach((child) => {
		height += child.getBoundingClientRect().height;
	})
	
	if (!height) {
		transriptToggle.parentElement.remove();
		return;
	}

	transcript.setAttribute('style', `max-height: ${height}px`);
		
	
	const toggleTranscript = (e) => {
		e.preventDefault();
		
		transcript.classList.toggle('hidden');
				
		if( !transcript.classList.contains('hidden') ) {
			transriptToggle.textContent = "Close Transcript";
		} else {
			transriptToggle.textContent = "View Transcript";
		}
		
	}
	
	transriptToggle.addEventListener('click', toggleTranscript);
	
	transriptToggle.click();
	
}

window.addEventListener('load', initWebinars)