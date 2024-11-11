// Truncate text beyond a given word limit
function limitText(txt, limit) {
	const words = txt.split(' ');

	if (words.length > limit) {
		return words.slice(0,limit).join(" ") + '...';
	} else {
		return txt;
	}
}

const initPodcasts = () => {
	
	const latestPodcastsContainer = document.querySelector('.podcasts-container');
	const podcastsContainer = document.querySelector('.podcasts-container.past');
	const podcastsTemplate = document.querySelector('.podcast-template');
	const loadMoreBtn = document.querySelector('#load-webinars');

	const createPost = (podcast) => {
		
		//Get All Post Info
		const podcastLink = podcast.link;
		const podcastImg = podcast.podcast_img;
		const podcastTitle = podcast.podcast_title;
		const podcastCategory = podcast.podcast_category;
		const podcastCategorySlug = podcast.podcast_category_slug;

		//Create Clone of template and get all template fields
		const clone = podcastsTemplate.content.cloneNode(true);
		
		const templateLink = clone.querySelector('.podcast-info .post-meta a');
		const templateImg = clone.querySelector('.podcast-info .podcast-img');
		const templateTitle = clone.querySelector('.podcast-info .post-meta h3');
		const templateCategory = clone.querySelector('.podcast-info .post-meta .category');
		
		//Assign Posts fields to template fields
		templateLink.href = podcastLink;
		templateImg.src = podcastImg;
		templateTitle.textContent = podcastTitle;
		templateCategory.textContent = podcastCategory;
		templateCategory.classList.add(podcastCategorySlug);

		return clone;
	}
	
	
	// Load More
	
	loadMoreBtn.addEventListener('click', async (event) => {
		event.preventDefault();
		
		// Offset is equal to all the posts on the page minus the templates (1 templates)
		const offset = podcastsContainer.children.length + latestPodcastsContainer.children.length - 1;
		
		const response = await fetch(`/wp-json/lead_forensics/v1/podcasts?offset=${offset}`);

		if (response.ok) {

			const data = await response.json();

			console.log(data)
			data.podcasts.forEach((podcast) => {
				const newPodcast = createPost(podcast);
				podcastsContainer.append(newPodcast);
			})
			
			if(data.noMorePosts) {
				//Remove Load More button if there are no more posts
				loadMoreBtn.parentElement.remove();
			}

		} 
	});
}

window.addEventListener('load', initPodcasts);