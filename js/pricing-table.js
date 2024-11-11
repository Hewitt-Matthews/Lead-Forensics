const initPricing = () => {
	
	const 	expandButton = document.querySelector('.lf-btn.see-more'),
			hiddenRows = document.querySelectorAll('.table-row.hidden'),
		  	tableFooter = document.querySelector('.comparison-table-footer.table-expand');
	
	const expandTable = (e) => {
		e.preventDefault();
		
		hiddenRows.forEach((row) => {
			row.classList.remove('hidden');
		})
		
		tableFooter.remove();
		
	}
	
	expandButton.addEventListener('click', expandTable);
}

window.addEventListener('load', initPricing);