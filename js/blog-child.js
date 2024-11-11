const removePostPaddingIfNoContents = () => {
	
	const contentsList = document.querySelector('.contents-list');
	
	if(!contentsList) {
		
		const postContentRow = document.querySelector('#post-content-row>div');
		const postHero = document.querySelector('.et_pb_section_0_tb_body>div');
		
		postContentRow.setAttribute('style', 'padding-top: 0;');
		postHero.setAttribute('style', 'padding-bottom: 0;');
		
	}
	
}

window.addEventListener('load', removePostPaddingIfNoContents);