const unhideSections = () => {

	const hiddenSections = document.querySelectorAll('.et_pb_section.hidden');
	
	hiddenSections.forEach((section) => {
		section.classList.remove('hidden');
	})
	
}
window.onload = function() {
    var iframe = document.getElementById('launcher');
    if (iframe) {
        iframe.parentNode.removeChild(iframe);
    }
};

const updateSearchIcon = () => {
	
	const searchIcon = "⚲";
	
	const searchInput = document.querySelector('header .et_pb_searchsubmit');
	
	searchInput.value = searchIcon;
	
}

const mobileNav = () => {
	
	
	// Open/close menu
	const menuBtns = document.querySelectorAll('header .mobile-menu .menu-btn');
	
	const toggleMenu = () => {

		const menuLines = document.querySelectorAll('header .mobile-menu .menu-btn .line');
		const menu = document.querySelector('header .mobile-menu .menu');
		const bodyContent = document.querySelector('#et-main-area');
		const headerLogo = document.querySelector('.et_pb_image_0_tb_header img');
		
		menuLines.forEach((line) => {
			line.classList.toggle('active');
		})
		
		headerLogo.classList.toggle('active');
		menu.classList.toggle('active');
		bodyContent.classList.toggle('active');
	}
	
	menuBtns.forEach((btn) => {
		btn.addEventListener('click', toggleMenu);
	})
		
	
	//Open/close sub menus
	
	const menuItemsWithChildren = document.querySelectorAll('header .mobile-menu #menu-primary-menu-1>.menu-item-has-children');
	const allListItems = document.querySelectorAll('header .mobile-menu #menu-primary-menu-1>li');
	
	
	const toggleMenuItem = (e) => {

		
		const menuItem = e.target.nodeName == "LI" ? e.target.firstElementChild : e.target ;
		const currentListItem = menuItem.parentElement;
		const listParent = menuItem.parentElement.parentElement;
		
		//Add Faded Class to all list items
		allListItems.forEach((listItem) => {
			
			listItem.classList.remove('faded');
			
			if(listItem !== currentListItem) {
				listItem.classList.add('faded');
			}
			
		})
		
		const subMenu = menuItem.nextElementSibling,
			  subMenuHeight = subMenu.scrollHeight;
		
		if(!subMenu.style.maxHeight){
			
			//Remove any max height attributes on all list items before opening new one
			menuItemsWithChildren.forEach((childMenuItem) => {
				const subMenu = childMenuItem.querySelector('.sub-menu');
				subMenu.removeAttribute('style');
			})
			listParent.classList.add('open');
			subMenu.setAttribute('style', `max-height: ${subMenuHeight}px; transform: scale(1);`);
		} else {
			subMenu.removeAttribute('style');
			listParent.classList.remove('open');
		}
		
	}
	
	menuItemsWithChildren.forEach((child) => {
		child.addEventListener('click', toggleMenuItem);
		child.addEventListener('touchstart', toggleMenuItem);
	})
	
	
}

const menuButtonsPreventDefualt = () => {
	
	const menuItems = document.querySelectorAll('#menu-primary-menu>li>a');
	
	const preventScroll = (e) => {
		e.preventDefault();
	}
	
	menuItems.forEach((item) => {
		item.addEventListener('click', preventScroll);
		item.addEventListener('touchstart', preventScroll);
	})
	
	
}

const formPopUp = () => {
	
	const forms = document.querySelectorAll('#pop-up-form');
	
	if(forms) {
		
		forms.forEach((form) => {
				
			const formButton = !form.classList.contains('demo') ? form.previousElementSibling : 0;

			const showForm = (e) => {

				e.preventDefault();

				document.body.appendChild(form);

				form.classList.add('visible');

			}

			const hideForm = (e) => {

				if(e.target.id == "pop-up-form") {
					form.classList.remove('visible');
					formButton.parentElement.appendChild(form);
				}

			}
			
			if(formButton) {
				form.addEventListener('click', hideForm);		
				formButton.addEventListener('click', showForm);
			} else {
				return;
			}
			
		})
		
	} else {
		return;
	}
	
}

const getADemoPopUp = () => {
	
// 	const demoBtns = document.querySelectorAll('#demo-btn');
// 	const demoPopUp = document.querySelector('#pop-up-form.demo');
	const demoParent = demoPopUp.parentElement;
	
	const showDemoForm = (e) => {

		e.preventDefault();
		document.body.appendChild(demoPopUp);
		demoPopUp.classList.add('visible');
		
	}
	
	const hideForm = (e) => {
				
		if(e.target.id == "pop-up-form") {
			demoPopUp.classList.remove('visible');
			demoParent.appendChild(demoPopUp);
		}

	}
	
	demoBtns.forEach((btn) => {
		btn.addEventListener('click', showDemoForm);
	})
	demoPopUp.addEventListener('click', hideForm);
	
	
	//Free Trial Form on pricing page
	const freeTrialBtns = document.querySelectorAll('#free-trial-btn');
	const freeTrialPopUp = document.querySelector('#pop-up-form.demo.pricing');
	
	if (freeTrialPopUp) {
		
		const showFreeTrailForm = (e) => {

			e.preventDefault();
			document.body.appendChild(freeTrialPopUp);
			freeTrialPopUp.classList.add('visible');

		}

		const hideFreeTrailForm = (e) => {

			if(e.target.id == "pop-up-form") {
				freeTrialPopUp.classList.remove('visible');
				demoParent.appendChild(freeTrialPopUp);
			}

		}


		freeTrialBtns.forEach((btn) => {
			btn.addEventListener('click', showFreeTrailForm);
		})
		freeTrialPopUp.addEventListener('click', hideFreeTrailForm);
		
	}
	
	
}

//window.addEventListener('load', unhideSections);
window.addEventListener('load', updateSearchIcon);
window.addEventListener('load', mobileNav);
window.addEventListener('load', menuButtonsPreventDefualt);
//window.addEventListener('load', formPopUp);
//window.addEventListener('load', getADemoPopUp);
formPopUp();
getADemoPopUp();