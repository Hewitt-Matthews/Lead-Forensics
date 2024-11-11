// Truncate text beyond a given word limit
function limitText(txt, limit) {
	const words = txt.split(' ');

	if (words.length > limit) {
		return words.slice(0,limit).join(" ") + '...';
	} else {
		return txt;
	}
}

const initWebinars = () => {
	
	const latestWebinarsContainer = document.querySelector('.webinars-container');
	const webinarsContainer = document.querySelector('.webinars-container.past');
	const webinarTemplate = document.querySelector('.webinars-template');
	const loadMoreBtn = document.querySelector('#load-webinars');

	const createPost = (webinar) => {
		
		//Get All Post Info
		const webinarLink = webinar.link;
		const webinarImgURL = webinar.webinar_video_info.video_thumbnail.sizes.large;
		const webinarTitle = webinar.webinar_video_info.video_title;
		const webinarDescription = webinar.webinar_video_info.video_description;
		const webinarCategory = webinar.webinar_category_name;
		const webinarCategorySlug = webinar.webinar_category_slug;

		//Create Clone of template and get all template fields
		const clone = webinarTemplate.content.cloneNode(true);
		
		const templateLink = clone.querySelector('.webinar-info .post-meta a');
		const templateImg = clone.querySelector('.webinar-info .webinar-img');
		const templateTitle = clone.querySelector('.webinar-info .post-meta h3');
		const templateDescription = clone.querySelector('.webinar-info .post-meta .post-excerpt');
		const templateCategory = clone.querySelector('.webinar-info .post-meta .category');
		
		//Assign Posts fields to template fields
		templateLink.href = webinarLink;
		templateImg.src = webinarImgURL;
		templateTitle.textContent = webinarTitle;
		templateDescription.innerHTML = limitText(webinarDescription, 30);
		templateCategory.textContent = webinarCategory;
		templateCategory.classList.add(webinarCategorySlug)

		return clone;
	}
	
	
	// Load More
	
	loadMoreBtn.addEventListener('click', async (event) => {
		event.preventDefault();
		
		// Offset is equal to all the posts on the page minus the templates (1 templates)
		const offset = webinarsContainer.children.length + latestWebinarsContainer.children.length - 1;
		
		const response = await fetch(`/wp-json/lead_forensics/v1/webinars?offset=${offset}`);

		if (response.ok) {

			const data = await response.json();

			console.log(data)
			data.webinars.forEach((webinar) => {
				const newWebinar = createPost(webinar);
				webinarsContainer.append(newWebinar);
			})
			
			if(data.noMorePosts) {
				//Remove Load More button if there are no more posts
				loadMoreBtn.parentElement.remove();
			}

		} 
	});
}

window.addEventListener('load', initWebinars);