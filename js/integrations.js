const initIntegrations = () => {
	
	const integrationsGrids = document.querySelectorAll('.integrations-container.truncated');
	
	integrationsGrids.forEach((truncatedGrid) => {
		
		const seeMoreBtn = truncatedGrid.querySelector('.see-more-container a');
		const maxHeight = truncatedGrid.scrollHeight;
		
		const seeMoreIntegrations = (e) => {
			e.preventDefault();
			e.target.parentElement.remove();
			truncatedGrid.classList.remove('truncated');
		}
		
		seeMoreBtn.addEventListener('click', seeMoreIntegrations);
		
	})
	
}

window.addEventListener('load', initIntegrations)