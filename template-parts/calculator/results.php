<?php

wp_enqueue_script( 'revenue_results_js', get_stylesheet_directory_uri() . '/js/revenue-results.js', array('jquery'), THEME_VERSION);

?>

<style>

	h1, p {
		text-align: center;
		color: #fff;
	}
	
	@property --conversion {
	  syntax: '<percentage>';
	  initial-value: 0%;
	  inherits: false;
	}
	
	@property --leads {
	  syntax: '<percentage>';
	  initial-value: 0%;
	  inherits: false;
	}
	
	@property --traffic {
	  syntax: '<percentage>';
	  initial-value: 0%;
	  inherits: false;
	}
	
	@property --opportunities {
	  syntax: '<percentage>';
	  initial-value: 0%;
	  inherits: false;
	}
	
	@property --noLeads {
	  syntax: '<percentage>';
	  initial-value: 0%;
	  inherits: false;
	}
	
	@property --revenue {
	  syntax: '<percentage>';
	  initial-value: 0%;
	  inherits: false;
	}
	
	@property --noRevenue {
	  syntax: '<percentage>';
	  initial-value: 0%;
	  inherits: false;
	}
	
	.pie-charts {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(min(300px, 100%), 1fr));
		gap: 2em;
		margin-top: 5em;
	}
	
	
	.pie-container {
    	position: relative;
	}

	.pie-container > div {
		position: absolute;
		top: 0;
		color: #fff;
		max-width: 100px;
		text-align: center;
		line-height: 1;
	}
	
	.pie-container > div.potential {
		left: 80%;
		top: 10%;
	}
	
	.pie-container > div.potential + .line {
		top: 40%;
		left: 73%;
		transform: rotate(141deg);
	}

	.pie-container > div.conversion {
		left: 42%;
		top: -10%;
	}
	
	.pie-container > div.conversion + .line {
		top: 22%;
		left: 45.5%;
		transform: rotate(100deg);
	}
	
	.pie-container > div.traffic {
		top: 0%;
	}
	
	.pie-container > div.traffic + .line {
		top: 37%;
		left: 13%;
		transform: rotate(45deg);
	}
	
	.pie-container > div.new-opportunities {
		top: 0%;
		left: 80%;
	}
	
	.pie-container > div.new-opportunities + .line {
		top: 31%;
		left: 71%;
		transform: rotate(141deg);
	}
	
	.pie-container > div.revenue-increase {
		top: 5%;
		left: 80%;
	}
	
	.pie-container > div.revenue-increase + .line {
		top: 36%;
		left: 73%;
		transform: rotate(141deg);
	}
	
	.pie-container > div > span {
		font-size: 32px;
		font-weight: 600;
		line-height: 1.5;
	}
	
	.pie-container .line {
		height: 1px;
		width: 0px;
		background-color: #fff;
		display: block;
		position: absolute;
		animation: lineGrow 500ms linear forwards;
	}
	
	.pie-chart {
		position: relative;
		min-height: 350px;
		clip-path: circle(30% at 50% 50%);
	}
	
	.pie-chart.visitors {
		background: conic-gradient( #47AF72 0, #47AF72 var(--conversion), #58E096 0, #58E096 var(--leads), rgb(255, 255, 255, 50%) 0, rgb(255, 255, 255, 50%) var(--traffic) );
		animation: animateVisitors 2.5s linear forwards;
	}
	
	.pie-chart.opportunities {
		background: conic-gradient( #58E096 0, #58E096 var(--opportunities), rgb(255, 255, 255, 50%) 0, rgb(255, 255, 255, 50%) var(--noLeads) );
		animation: animateOpportunities 2.5s linear forwards;
	}
	
	.pie-chart.revenue {
		background: conic-gradient( #58E096 0, #58E096 var(--revenue), rgb(255, 255, 255, 50%) 0, rgb(255, 255, 255, 50%) var(--noRevenue) );
		animation: animateRevenue 2.5s linear forwards;
	}

	.pie-chart span:after {
		display: inline-block;
		content: "";
		width: 0.8em;
		height: 0.8em;
		margin-left: 0.4em;
		height: 0.8em;
		border-radius: 0.2em;
		background: currentColor;
	}
	
	@keyframes lineGrow {
		
		100% {
			width: 50px;
		}
		
	}
	
	@keyframes animateVisitors {
		
		100% {
			--conversion: 2%;
			--leads: 30%;
			--traffic: 68%;
		}
		
	}
	
	@keyframes animateOpportunities {
		
		100% {
			--opportunities: 66%;
			--noLeads: 33%;
		}
		
	}
	
	/* 	Revenue */
	
	#page-container .order-value {
		max-width: 500px;
		margin: 0 auto;
		text-align: center;
	}
	
	#page-container .order-value input[type="number"] {
    	margin: 1em auto;
		text-align: center;
		display: block;
		border: none;
		padding: 1em;
		border-radius: 50px;
		width: 80%;
		max-width: 300px;
		font-size: 17px;
	}
	
	#page-container .order-value h2 {
		color: #fff;
	}
	
	#page-container .order-value .gform_footer input[type="submit"] {
		border: none;
		font-size: 18px;
		font-weight: 600;
		color: #fff;
		padding: 0.75em 1.5em;
		border-radius: 50px;
		background-color: #59E297;
		margin: 0 auto;
		line-height: 1;
		transition: 250ms;
	}
	
	#page-container .order-value .gform_footer input[type="submit"]:hover {
		cursor: pointer;
		background-color: #33b16c;
	}
	
	.validation_message {
		display: block!important;
	}
	
	h2.gform_submission_error.hide_summary {
		color: #c02b0a!important;
		padding: 0;
	}
	
	.gform_confirmation_message {
		color: #fff;
	}

</style>

<?php 

$old_leads = get_field('old_leads', 'option');
$new_leads = get_field('new_leads', 'option');
$opportunities = get_field('opportunities', 'option');

?>

<h1><span class="website-name">You</span> could generate <span class="number-of-leads">0</span> leads</h1>
<p>Based on an average <?= $new_leads ?>% lead to opportunity conversion rate, that's <span class="number-of-opportunities">x</span> new monthly opportunities.</p>

<div class="pie-charts" data-old-leads="<?= $old_leads ?>" data-new-leads="<?= $new_leads ?>" data-opportunities="<?= $opportunities ?>">
	
	<div class="pie-container">
		<figure class="pie-chart visitors"></figure>
		<div class="traffic"><span>?</span><br>Estimated website visitors</div>
		<span class="line"></span>
		<div class="conversion"><span><?= $opportunities ?>%</span><br>Website conversion</div>
		<span class="line"></span>
		<div class="potential"><span><?= $new_leads ?>%</span><br>Potential customers</div>
		<span class="line"></span>
	</div>
	
	<div class="pie-container">
		<figure class="pie-chart opportunities"></figure>
		<div class="new-opportunities"><span>?</span><br>New opportunities</div>
		<span class="line"></span>
	</div>
	
	<div class="pie-container">
		<figure class="pie-chart revenue"></figure>
		<div class="revenue-increase"><span>?</span><br>Revenue increase</div>
		<span class="line"></span>
	</div>
	
</div>

<div class="order-value">
	
	<p>Average Order Value</p>
	
	<?php gravity_form( 20, false, false, false, '', true ); ?>
	
	<h2>Input your average order value above to see your revenue potential.</h2>
	
</div>
