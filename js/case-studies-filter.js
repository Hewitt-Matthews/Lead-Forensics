// Truncate text beyond a given word limit
function limitText(txt, limit) {
	const words = txt.split(' ');

	if (words.length > limit) {
		return words.slice(0,limit).join(" ") + '...';
	} else {
		return txt;
	}
}

const initCaseStudies = () => {
	
	//Rest Function
	
	const caseStudiesContainer = document.querySelector('.case-studies-grid-container');
	const caseStudyTemplate = document.querySelector('.case-study-template');
	const loadMoreBtn = document.querySelector('#load-case-studies');

	const createPost = (caseStudy) => {
		
		const selectedCategory = caseStudiesContainer.classList[1];
		
		//Get All Post Info
		const caseStudyLink = caseStudy.link;
		const caseStudyImgURL = caseStudy.featuredImg;
		const caseStudyTitle = caseStudy.title;
		const caseStudyLogoURL = caseStudy.logo;
		const caseStudyColour = caseStudy.colour;
		const caseStudyCategory = caseStudy.category;

		//Create Clone of template and get all template fields
		const clone = caseStudyTemplate.content.cloneNode(true);
		
		const templateLink = clone.querySelector('.case-study');
		templateLink.dataset.category = caseStudyCategory ? caseStudyCategory : "";
		const templateImg = clone.querySelector('.case-study .bg-image');
		const templateTitle = clone.querySelector('.case-study h3');
		const templateLogo = clone.querySelector('.case-study img');
		
		//Assign Posts fields to template fields
		templateLink.href = caseStudyLink;
		templateLink.style.background = `linear-gradient(0deg, ${caseStudyColour} 0%, rgba(0, 0, 0, 0.3) 100%)`;
		templateImg.style.background = `url(${caseStudyImgURL})`;
		templateTitle.innerHTML = `${caseStudyTitle}<span class='et-pb-icon'>&#x35;</span>` ;
		templateLogo.src = caseStudyLogoURL;
		
						
		if(selectedCategory) {

			if(selectedCategory == "all") return clone;

			if(selectedCategory != caseStudyCategory) {
				templateLink.classList.add('hidden');
			}

		}
		

		return clone;
	}
	
	//Define Category globall so we can check if it's defined in the load more func
	let category;
	
	//Filter Function
	
	const filterButtons = document.querySelectorAll('.case-studies-categories-container .category-button');
	
	filterButtons.forEach(btn => {
		
		btn.addEventListener('click', async (e) => {
		
			const target = e.target;
			category = target.dataset.slug;
			
			filterButtons.forEach(btn => {
				btn.classList.remove('checked');
			})

			target.classList.add('checked');
			
			const response = await fetch(`/wp-json/lead_forensics/v1/case-studies?category=${category}`);

			if (response.ok) {

				const data = await response.json();
				
				caseStudiesContainer.innerHTML = "";
				caseStudiesContainer.parentElement.append(caseStudyTemplate);

				data.case_studies.forEach((caseStudy) => {
					const newCaseStudy = createPost(caseStudy);
					caseStudiesContainer.append(newCaseStudy);			
				})
				
				if(data.case_studies.length > 3) {
					
					const isThereALoadBtn = document.querySelector('#load-case-studies');
					
					if(!isThereALoadBtn) {
						caseStudiesContainer.closest('.et_pb_column').append(loadMoreBtn.parentElement);
					}
					
				}

			} 

		})
		
	})
	
	
	// Load More
	
	loadMoreBtn.addEventListener('click', async (event) => {
		event.preventDefault();
		
		let response;
		// Offset is equal to all the posts on the page minus the templates (1 templates)
		const offset = caseStudiesContainer.children.length;
		
		if(category) {
			response = await fetch(`/wp-json/lead_forensics/v1/case-studies?offset=${offset}&category=${category}`);
		} else {
			response = await fetch(`/wp-json/lead_forensics/v1/case-studies?offset=${offset}`);
		}

		if (response.ok) {

			const data = await response.json();

			data.case_studies.forEach((caseStudy) => {
				const newCaseStudy = createPost(caseStudy);
				caseStudiesContainer.append(newCaseStudy);			
			})
			
			if(data.noMorePosts) {
				//Remove Load More button if there are no more posts
				loadMoreBtn.parentElement.remove();
			}

		} 
	});

	
}

window.addEventListener('load', initCaseStudies);