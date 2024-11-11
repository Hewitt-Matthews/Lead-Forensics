// Truncate text beyond a given word limit
function limitText(txt, limit) {
	const words = txt.split(' ');

	if (words.length > limit) {
		return words.slice(0,limit).join(" ") + '...';
	} else {
		return txt;
	}
}

const initPosts = () => {
	
	//const latestPostsContainer = document.querySelector('.latest-posts');
	const postsContainer = document.querySelector('.posts-container');
	const postsTemplate = document.querySelector('.posts-template');
	const loadMoreBtn = document.querySelector('#load-more');

	const createPost = (post) => {
		
		//Get All Post Info
		const postLink = post.link;
		const postImgURL = post.featuredImg[0];
		const postTitle = post.title;
		const postExcerpt = limitText(post.excerpt, 30);
		const postCategories = post.categories;
		let postCategory,
			postCategorySlug;
		
		for (let category of postCategories) {

			if (category.parent) {
				postCategory = category.name;
				postCategorySlug = category.slug;
				break;
			}
			
		}

		//Create Clone of template and get all template fields
		const clone = postsTemplate.content.cloneNode(true);
		
		const templateLinks = clone.querySelectorAll('.post-link');
		const templateCategory = clone.querySelector('.post-meta .category');
		const templateImg = clone.querySelector('.post-img');
		const templateTitle = clone.querySelector('.post-title');
		const templateExcerpt = clone.querySelector('.post-excerpt');
		
		//Assign Posts fields to template fields
		templateLinks.forEach((link) => {
			link.href = postLink;
		})
		templateCategory.textContent = postCategory;
		templateCategory.classList.add(postCategorySlug);
		templateImg.src = postImgURL;
		templateTitle.textContent = postTitle;
		templateExcerpt.textContent = postExcerpt;
		

		return clone;
	}
	
	//Define Category global so we can check if it's defined in the load more func
	let category;
	const page = document.body.classList.contains('blog') ? "blog" : "news";
	
	//Filter Function
	
	const filterButtons = document.querySelectorAll('.blog-categories-container .category-button');
	
	filterButtons.forEach(btn => {
		
		btn.addEventListener('click', async (e) => {
		
			const target = e.target;
			category = target.dataset.slug;
			
			filterButtons.forEach(btn => {
				btn.classList.remove('checked');
			})

			target.classList.add('checked');
			
			const response = await fetch(`/wp-json/lead_forensics/v1/blog/posts?category=${category}&page=${page}`);

			if (response.ok) {

				const data = await response.json();
				
				postsContainer.innerHTML = "";
				postsContainer.parentElement.append(postsTemplate);

				data.posts.forEach((caseStudy) => {
					const newCaseStudy = createPost(caseStudy);
					postsContainer.append(newCaseStudy);			
				})
				
				if(data.posts.length > 3) {
					
					const isThereALoadBtn = document.querySelector('#load-case-studies');
					
					if(!isThereALoadBtn) {
						postsContainer.closest('.et_pb_column').append(loadMoreBtn.parentElement);
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
		const offset = (postsContainer.children.length);
		
		if(category) {
			response = await fetch(`/wp-json/lead_forensics/v1/blog/posts?offset=${offset}&category=${category}&page=${page}`);
		} else {
			response = await fetch(`/wp-json/lead_forensics/v1/blog/posts?offset=${offset}&page=${page}`);
		}

		if (response.ok) {

			const data = await response.json();

			data.posts.forEach((post) => {
				const newPost = createPost(post);
				postsContainer.append(newPost);
			})
			
			if(data.noMorePosts) {
				//Remove Load More button if there are no more posts
				loadMoreBtn.parentElement.remove();
			}

		} 
	});
}

window.addEventListener('load', initPosts);