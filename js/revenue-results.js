const initResults = () => {
	
	const apiKey = '6cacca3a988f720385bd4e78c3d01171b02c0e5f';
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	const websiteTraffic = urlParams.get('visits');
	const websiteURL = urlParams.get('url');	
	const headingURL = document.querySelector('h1 .website-name');
	
	//Get Calculation Values
	const newLeadsPercentage = document.querySelector('.pie-charts').dataset.newLeads / 100;
	const oldLeadsPercentage = document.querySelector('.pie-charts').dataset.oldLeads / 100;
	const opportunitiesPercentage = document.querySelector('.pie-charts').dataset.opportunities / 100;
	
	//Set Web Address if applicable
	if(websiteURL) {
		headingURL.textContent = websiteURL;
	}
	
	//Set Revenue Style Template
	let style = document.createElement('style');
	style.type = 'text/css';
	const keyFrames = '\
	@keyframes animateRevenue {\
		100% {\
			--revenue: REVENUE_REPLACE;\
			--noRevenue: NOREVENUE_REPLACE;\
		}\
	}';
	
	//Set Number of Leads
	const leadsSpan = document.querySelector('.number-of-leads');
		
		//2% of Website visitors - Current Leads
	const currentLeads = Math.ceil(parseInt(websiteTraffic.replace(/,/g, '')) * oldLeadsPercentage);	
		
		//30% of Website visitors - LF Leads
	const maximumLeads = Math.ceil(parseInt(websiteTraffic.replace(/,/g, '')) * newLeadsPercentage);	
	leadsSpan.textContent = maximumLeads;
	
	//Set Pie Website Visitors
	const pieWebVisitors = document.querySelector('.pie-container .traffic>span');
	pieWebVisitors.textContent = websiteTraffic;
	
	//Set New Opportunities
	const headerNewOpportunities = document.querySelector('.number-of-opportunities');
	const pieNewOpportunities = document.querySelector('.new-opportunities>span');
		//2% of Leads
	const opportunities = Math.ceil(maximumLeads * opportunitiesPercentage);
	headerNewOpportunities.textContent = opportunities;
	pieNewOpportunities.textContent = opportunities;
	
	//Set Revenue Potential
	const averageOrder = document.querySelector('.order-value input[type="number"]');
	const result = document.querySelector('.order-value h2');
	const gravityFormBody = document.querySelector('.gform_body');
	gravityFormBody.appendChild(result);
	
	const updateRevenuePotential = (e) => {
		
		const value = e.target.value;
		
		//Get Estimated Current Revenue
		const currentOpportunities = Math.ceil(currentLeads * opportunitiesPercentage);
		const estimatedRevenue = value * currentOpportunities;
		
		const revenuePotential = value * opportunities;
	
		const percetangeIncrease = Math.round(parseFloat((revenuePotential / estimatedRevenue) * 100));
		
		//Set Revenue Increase
		const revenueIncrease = document.querySelector('.revenue-increase>span');
		
		const formattedRevenue = (revenuePotential).toLocaleString(
			undefined,
			{ minimumFractionDigits: 0 }
		);
		
		style.innerHTML = keyFrames.replace(/REVENUE_REPLACE/g, "100%").replace(/NOREVENUE_REPLACE/g, "0%");
		document.getElementsByTagName('head')[0].appendChild(style);
		
		const setBgOfRevenue = () => {
			const revenuePie = document.querySelector('.pie-chart.revenue');
			revenuePie.setAttribute('style', 'background: #58E096;')	
		}
		
		const myTimeout = setTimeout(setBgOfRevenue, 2500);

		revenueIncrease.textContent = `${percetangeIncrease}%`;
		result.textContent = `Revenue Potential = £${formattedRevenue}`;
		
	}
	
	averageOrder.addEventListener('input', updateRevenuePotential)
	
	jQuery(document).on('gform_confirmation_loaded', function(event, formId){
		
		const orderValueHeading = document.querySelector('.order-value>p');
		orderValueHeading.after(result);
		
	});
	
	//
	// Below here was the OG code for the API fetch. Keeping it here just in case it needs to be used down the line.
	//
	
	//const apiURL = `https://endpoint.sitetrafficapi.com/pay-as-you-go/?key=${apiKey}&host=${urlWithoutProtocol.replace('www.','')}`;
	
	async function fetchData() {
		
		const response = await fetch(apiURL);
		
		console.log(response);
		
		if (response.ok) {
			
			const leadsSpan = document.querySelector('.number-of-leads');
			
			const data = await response.json();

			const visitors = data.data.estimations.visitors.monthly;
			console.dir(visitors);
			
			const numberOfLeads = parseInt(visitors);
			
			leadsSpan.textContent = numberOfLeads;
			console.log(data.data);

		} 
		
	}
	
	
	//fetchData();
}

initResults();

//window.addEventListener('load', initResults)