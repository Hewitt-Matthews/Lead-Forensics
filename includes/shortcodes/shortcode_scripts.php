<?php

// Call in swiper scripts if certain shortcodes are used that requires it
function swiper_loop_scripts() {
    global $post;
	
    if (
		(is_a( $post, 'WP_Post' ) && (
			has_shortcode( $post->post_content, 'caseStudyReviews') )
		) || 
		is_singular('services')
	   ) {
		wp_enqueue_script( 'swiper', get_stylesheet_directory_uri() . '/swiper/swiper-bundle.min.js', array(), '1.0.0', true );
		wp_enqueue_script( 'swiper-options', get_stylesheet_directory_uri() . '/swiper/swiper-options.js', array(), '1.0.0', true );
		wp_enqueue_style( 'swiper_styles', get_stylesheet_directory_uri() . '/swiper/swiper-bundle.css');
    }
}
//add_action( 'wp_enqueue_scripts', 'swiper_loop_scripts');

// Call in splide scripts if certain shortcodes are used that requires it
function splide_loop_scripts() {
    global $post;
	
    if ( (is_a( $post, 'WP_Post' ) && 
		  	( 
			  has_shortcode( $post->post_content, 'clientLogos') ||
			  has_shortcode( $post->post_content, 'caseStudyReviews')
			) ) || 
		is_singular('services') ) {
		wp_enqueue_script( 'splide-slider', get_stylesheet_directory_uri() . '/splide-slider/dist/js/splide.min.js', array(), '1.0.0', true );
		wp_enqueue_script( 'splide-slider-autoscroll', get_stylesheet_directory_uri() . '/splide-slider/dist/js/splide-extension-auto-scroll.min.js', array(), '1.0.0', true );
 		wp_enqueue_script( 'splide-options', get_stylesheet_directory_uri() . '/splide-slider/splide-options.js', array(), '1.0.0', true );
		wp_enqueue_style( 'splide_styles', get_stylesheet_directory_uri() . '/splide-slider/dist/css/splide-core.min.css');
    }
}
add_action( 'wp_enqueue_scripts', 'splide_loop_scripts');
	
	
// // // // // // // // // // // // 
// 
// 
// 
// Shortcode/Loop Styles and Scripts Funtions
// 
// 
// 
//  // // // // // // // // // // // 


// Call in testimonial styles if certain shortcodes are used that requires them
function testimonial_loop_styles() {
    global $post;
	
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'testimonialsLoop') ) {
		wp_enqueue_style( 'testimonial_loop_styles', get_stylesheet_directory_uri() . '/css/testimonial-loop-styles.css');
    }
}
add_action( 'wp_enqueue_scripts', 'testimonial_loop_styles');

// Call in partners scripts if certain shortcodes are used that requires them
function posts_scripts() {
    global $post;
	
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, '') ) {
		  wp_enqueue_style( 'post_parent_styles', get_stylesheet_directory_uri() . '/css/blog-parent.css');
    }
}
add_action( 'wp_enqueue_scripts', 'posts_scripts');


// Call in contact form styles if certain shortcodes are used that requires them
function contact_forms_styles() {
    global $post;
	
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'gravityform') ) {
		wp_enqueue_style( 'contact_styles', get_stylesheet_directory_uri() . '/css/contact-forms.css', array(), THEME_VERSION );
    }
}
add_action( 'wp_enqueue_scripts', 'contact_forms_styles');

// Call in client logo styles if certain shortcodes are used that requires them
function client_logo_loop_styles() {
    global $post;
	
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'clientLogos') ||
	   is_singular('services')
	   ) {
		wp_enqueue_style( 'client_logo_loop_styles', get_stylesheet_directory_uri() . '/css/client-logos.css');
    }
}
add_action( 'wp_enqueue_scripts', 'client_logo_loop_styles');

// Call in case studies styles if certain shortcodes are used that requires them
function case_studies_styles() {
    global $post;
	
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'caseStudies') ||
		is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'caseStudiesGrid') ||
	   	is_singular('services') || is_singular('case-studies')
	   ) {
		wp_enqueue_style( 'case_studies_styles', get_stylesheet_directory_uri() . '/css/case-studies.css');
    }
}
add_action( 'wp_enqueue_scripts', 'case_studies_styles');

// Call in case studies styles if certain shortcodes are used that requires them
function case_studies_filter() {
    global $post;
	
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'caseStudiesGrid')) {
		wp_enqueue_script( 'case_studies_filter', get_stylesheet_directory_uri() . '/js/case-studies-filter.js');
    }
}
add_action( 'wp_enqueue_scripts', 'case_studies_filter');

// Call in pricing table styles if certain shortcodes are used that requires them
function pricing_table_styles() {
    global $post;
	
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'pricingTable') ) {
		wp_enqueue_style( 'pricing_table_styles', get_stylesheet_directory_uri() . '/css/pricing-table.css');
		wp_enqueue_script( 'pricing_table_script', get_stylesheet_directory_uri() . '/js/pricing-table.js');
    }
}
add_action( 'wp_enqueue_scripts', 'pricing_table_styles');

// Call in faq styles if certain shortcodes are used that requires them
function faqs_styles() {
    global $post;
	
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'faqs') ) {
		wp_enqueue_style( 'faqs_styles', get_stylesheet_directory_uri() . '/css/faqs.css');
		wp_enqueue_script( 'faqs_script', get_stylesheet_directory_uri() . '/js/faqs.js');
    }
}
add_action( 'wp_enqueue_scripts', 'faqs_styles');

// Call in wista video styles if certain shortcodes are used that requires them
function wistia_video_styles() {
    global $post;
	
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'featuredVideo')) {
		wp_enqueue_style( 'wistia_video_styles', get_stylesheet_directory_uri() . '/css/wistia-videos.css');
		wp_enqueue_script( 'wistia_video_script', get_stylesheet_directory_uri() . '/js/wistia-videos.js');
    }
}
add_action( 'wp_enqueue_scripts', 'wistia_video_styles');

// Call in webinar_child_styles and wista video styles on webinar child pages
function webinar_child_styles() {
    global $post;
	
    if ( is_singular('webinars') ) {
		wp_enqueue_style( 'webinar_child_styles', get_stylesheet_directory_uri() . '/css/webinar-child.css', array(), THEME_VERSION);
		wp_enqueue_script( 'webinar_child_script', get_stylesheet_directory_uri() . '/js/webinar-child.js', array(), THEME_VERSION);
		wp_enqueue_style( 'wistia_video_styles', get_stylesheet_directory_uri() . '/css/wistia-videos.css');
		wp_enqueue_script( 'wistia_video_script', get_stylesheet_directory_uri() . '/js/wistia-videos.js');		
    }
}
add_action( 'wp_enqueue_scripts', 'webinar_child_styles');



?>