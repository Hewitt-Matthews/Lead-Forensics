<?php

//Build Shortcode to show URL input for revenue calculator
add_shortcode( 'revenueCalculator', 'revenue_calculator_func' );

function revenue_calculator_func( $atts ) {
    
	ob_start();
	
	get_template_part('template-parts/calculator/url-input');
	
    return ob_get_clean();

};

//Build Shortcode to show results for revenue calculator
add_shortcode( 'revenueCalculatorResults', 'revenue_results_func' );

function revenue_results_func( $atts ) {
    
	ob_start();
	
	get_template_part('template-parts/calculator/results');
	
    return ob_get_clean();

};

//Build Shortcode to show results for sticky-sidebar
add_shortcode( 'stickySidebar', 'sticky_sidebar_func' );

function sticky_sidebar_func( $atts ) {
    
	ob_start();
	
	get_template_part('template-parts/calculator/sticky-sidebar');
	
    return ob_get_clean();

};