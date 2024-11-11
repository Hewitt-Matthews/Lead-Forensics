const initFAQs = () => {
	
	const questions = document.querySelectorAll('.question');
	const questionsToggles = document.querySelectorAll('.question-toggle');
	const answers = document.querySelectorAll('.question-container .answer');
	
	answers.forEach((answer) => {
		
		let height = 0;
		
		const answerChildren = [...answer.children]	
		
		answerChildren.forEach((child) => {
			height += child.getBoundingClientRect().height;
		})
		
		answer.setAttribute('style', `max-height: ${height}px`);
		
	})
	
	const toggleQuestion = (e) => {
		
		let toggle;
		
		if(e.target.className != 'question') {
			
			if(e.target.parentElement.className != 'question') {
				toggle = e.target.parentElement.parentElement;
			} else {
				toggle = e.target.parentElement.lastElementChild;
			}
			
		} else {
			toggle = e.target.lastElementChild;
		}		
		
		const 	answer = toggle.parentElement.nextElementSibling,
				lineArray = [...toggle.children[0].children];
		
		answer.classList.toggle('hidden');
				
		lineArray.forEach((line) => {
			line.classList.toggle('active');
		})

		
	}
	
	questions.forEach((question) => {
		question.addEventListener('click', toggleQuestion);
	})
}

window.addEventListener('load', initFAQs)