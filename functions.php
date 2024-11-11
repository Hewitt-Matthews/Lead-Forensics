<?php 

//Include all shortcode files
foreach (glob(__DIR__ . "/includes/shortcodes/*.php") as $filename) {
    include $filename;
}

$theme = wp_get_theme();
define('THEME_VERSION', $theme->Version);

add_action( 'wp_enqueue_scripts', 'my_enqueue_assets' ); 

function my_enqueue_assets() { 
	
	global $post;
	
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css', array(), THEME_VERSION ); 
	wp_enqueue_style( 'nav-style', get_stylesheet_directory_uri().'/css/navbar.css', array(), THEME_VERSION  ); 
	wp_enqueue_style( 'effra-font-style', 'https://use.typekit.net/zya6azt.css' ); 
	
	wp_enqueue_script( 'global_js', get_stylesheet_directory_uri() . '/js/all-pages.js', array('jquery'), THEME_VERSION, true );

	if( is_front_page() ) {
		wp_enqueue_style( 'homepage-styles', get_stylesheet_directory_uri().'/css/homepage-styles.css' ); 
	} elseif( is_singular( 'post' ) ) {
		wp_enqueue_style( 'blog_child_page-styles', get_stylesheet_directory_uri().'/css/blog-child.css', array(), THEME_VERSION ); 
		wp_enqueue_script( 'blog_child_js', get_stylesheet_directory_uri() . '/js/blog-child.js');
	} elseif( is_home() || is_page( 349 ) ) {
		wp_enqueue_style( 'blog_parent_page-styles', get_stylesheet_directory_uri().'/css/blog-parent.css', array(), THEME_VERSION ); 
		wp_enqueue_script( 'post_filter_js', get_stylesheet_directory_uri() . '/js/posts-filter.js', array(), THEME_VERSION);
	} elseif( is_singular('services') || is_page( 1111 ) ) {
		wp_enqueue_style( 'services-styles', get_stylesheet_directory_uri().'/css/services.css' );
		
		if( is_page( 1111 ) ) {
			wp_enqueue_style( 'product-features-styles', get_stylesheet_directory_uri().'/css/product-features-page.css' );
		} 
		
	} elseif( is_singular('case-studies') ) {
		wp_enqueue_style( 'case-study-styles', get_stylesheet_directory_uri().'/css/case-study-single.css' );
	} elseif( is_page( 960 ) ) {
		wp_enqueue_style( 'webinar-parent-styles', get_stylesheet_directory_uri().'/css/webinar-parent.css' );
		wp_enqueue_script( 'webinars_filter_js', get_stylesheet_directory_uri() . '/js/webinars-filter.js');
	} elseif( is_page( 7136 ) ) {
		wp_enqueue_script( 'podcasts_filter_js', get_stylesheet_directory_uri() . '/js/podcasts-filter.js', array(), THEME_VERSION);
		wp_enqueue_style( 'podcast-parent-styles', get_stylesheet_directory_uri().'/css/podcast-parent.css', array(), THEME_VERSION );
	} elseif(is_singular('podcasts') || is_tax('podcast_categories')){
		wp_enqueue_style( 'podcast-parent-styles', get_stylesheet_directory_uri().'/css/podcast-parent.css', array(), THEME_VERSION );
	} elseif( is_singular('integrations') ) {
		wp_enqueue_style( 'integrations-child-styles', get_stylesheet_directory_uri().'/css/integrations-child.css', array(), THEME_VERSION );
	} elseif( is_page( 1030 ) ) {
		wp_enqueue_style( 'integrations-parent-styles', get_stylesheet_directory_uri().'/css/integrations-parent.css' );
		wp_enqueue_script( 'integrations_js', get_stylesheet_directory_uri() . '/js/integrations.js');
	} elseif( is_page( 2014 ) ) {
		wp_enqueue_style( 'contact-styles', get_stylesheet_directory_uri().'/css/contact.css' );
	} elseif( is_page( 1111 ) ) {
		wp_enqueue_style( 'product-features-styles', get_stylesheet_directory_uri().'/css/product-features-page.css' );
	} elseif ( is_search() ) {
		wp_enqueue_style( 'search-results-styles', get_stylesheet_directory_uri().'/css/search-results.css' );
	}


} 

function defer_parsing_of_js( $url ) {
    if ( is_user_logged_in() ) return $url; //don't break WP Admin
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    return str_replace( ' src', ' defer src', $url );
}
add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );


// Create Options page
if( function_exists('acf_add_options_page') ) {
		
	acf_add_options_page(array(
		'page_title' 	=> 'Lead Forensics Plans',
		'menu_title'	=> 'Lead Forensics Plans',
		'menu_slug' 	=> 'lead-forensics-plans',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'position' 		=> '32',
		'icon_url' => 'dashicons-cart'
	));
	
	acf_add_options_page(array(
		'page_title' 	=> 'Global Options',
		'menu_title'	=> 'Global Options',
		'menu_slug' 	=> 'global-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'position' 		=> '33'
	));
	
	acf_add_options_page(array(
		'page_title' 	=> 'Footer Options',
		'menu_title'	=> 'Footer Options',
		'menu_slug' 	=> 'footer-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'position' 		=> '34'
	));
	
}

function custom_acf_styles() {
    ?>
    <style type="text/css">

    .g2-badges tbody {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(min(100%,200px), 1fr));
	}

    </style>
    <?php
}

add_action('acf/input/admin_head', 'custom_acf_styles');


// Pricing Table - Populate available options from plans page
function acf_load_available_plan_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();


    // if has rows
    if( have_rows('plans', 'option') ) {
        
        // while has rows
        while( have_rows('plans', 'option') ) {
            
            // instantiate row
            the_row();
            
            
            // vars
            $value = strtolower(get_sub_field('plan_name'));
            $label = get_sub_field('plan_name');

            
            // append to choices
            $field['choices'][ $value ] = $label;
            
        }
        
    }


    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=available_on', 'acf_load_available_plan_choices');

// Pricing Table - Populate available options from plans page
function acf_load_text_box_choices( $field ) {
    
    // reset choices
    $field['sub_fields'] = array();

    // if has rows
    if( have_rows('plans', 'option') ) {
        
        // while has rows
        while( have_rows('plans', 'option') ) {
            
            // instantiate row
            the_row();        
            
            // vars
            $plan_name_lower_case = preg_replace('/\s+/', '_', strtolower(get_sub_field('plan_name')));
            $plan_name = get_sub_field('plan_name');

            $field['sub_fields'][] = array(
                'key' => 'field_61a76' . $plan_name_lower_case,
                'label' => $plan_name . ' Text',
                'name' => $plan_name_lower_case . '_text',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'Test',
                'placeholder' => 'e.g. Max 100 leads',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            );

            
        }
        
    }


    // return the field
    return $field;
    
}

//add_filter('acf/load_field/name=checkmark_text', 'acf_load_text_box_choices');



// Pricing Table - Populate available options from plans page
function acf_load_text_box_test( $field ) {
    
    // reset choices
    $field['sub_fields'] = array(
		array(
			'key' => 'field_61a760fed070d',
			'label' => 'Essentials Text',
			'name' => 'essentials_text',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'e.g. Max 100 leads',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_61a76105d070e',
			'label' => 'Integrate Text',
			'name' => 'integrate_text',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'e.g. Up to unlimited',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
	);


    // return the field
    return $field;
    
}

//add_filter('acf/load_field/name=checkmark_text', 'acf_load_text_box_test');

/**
 * Disable Default code for CPT
 **/
function disable_cptdivi(){
	remove_action( 'wp_enqueue_scripts', 'et_divi_replace_stylesheet', 99999998 );
}
add_action('init', 'disable_cptdivi');


//Limit length of text function
function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]);
    }
    return $text;
}

/**
 *	This will hide the Divi "Project" post type.
 */
add_filter( 'et_project_posttype_args', 'mytheme_et_project_posttype_args', 10, 1 );
function mytheme_et_project_posttype_args( $args ) {
	return array_merge( $args, array(
		'public'              => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => false
	));
}

/**
 * Gravity Redirect
 */

add_filter( 'gform_confirmation', function ( $confirmation, $form, $entry, $ajax ) {
    GFCommon::log_debug( __METHOD__ . '(): running.' );
 
    $forms = array( 2 ); 
 
    if ( ! in_array( $form['id'], $forms ) ) {
        return $confirmation;
    }
 
    if ( isset( $confirmation['redirect'] ) ) {
        $url          = esc_url_raw( $confirmation['redirect'] );
        GFCommon::log_debug( __METHOD__ . '(): Redirect to URL: ' . $url );
        $confirmation = "<div class='failed-download'>If you've not been redirected to your download, you can view it here: <a href='{$url}' target='_blank'>Download</a></div>";
        $confirmation .= "<script type=\"text/javascript\">window.open('$url', '_blank');</script>";
    }
 
    return $confirmation;
}, 10, 4 );

// __gtm_campaign_url capture for Gravity Forms

add_filter( 'gform_field_value___gtm_campaign_url', 'populate___gtm_campaign_url' );
function populate___gtm_campaign_url( $value) {
	return $_COOKIE['__gtm_campaign_url'];
}

// ADDS A SPAN TAG AFTER THE GRAVITY FORMS BUTTON
// aria-hidden is added for accessibility (hides the icon from screen readers)
add_filter( 'gform_submit_button', 'dw_add_span_tags', 10, 2 );
function dw_add_span_tags ( $button, $form ) {

	return $button .= "<span aria-hidden='true'></span>";

}
	
// Custom cookies block script

function cli_scripts_list() {
 $scripts = array(
  array(
      'id' => 'leadforensic',
      'label' => 'Leadforensic',
      'key' => array('secure.leadforensics.com/js/sc/'),
      'category' => 'analytics',
      'status' => 'yes',
  ),
  array(
      'id' => 'leadforensic_tracker',
      'label' => 'Leadforensic Tracker',
      'key' => array('tracker.leadforensics.com/js/'),
      'category' => 'analytics',
      'status' => 'yes',
  ),
  array(
      'id' => 'leadforensic_v3track',
      'label' => 'Leadforensic v3track',
      'key' => array('v3track.leadforensics.com/js/'),
      'category' => 'analytics',
      'status' => 'yes',
  ),
  array(
      'id' => 'analytics_custom',
      'label' => 'Analytics Custom',
      'key' => array('cdn.segment.com/analytics.js'),
      'category' => 'analytics',
      'status' => 'yes',
  ),
  array(
      'id' => 'wisepops',
      'label' => 'Wisepops',
      'key' => array('loader.wisepops.com/get-loader.js'),
      'category' => 'analytics',
      'status' => 'yes',
  ),
  array(
      'id' => 'g2_crowd',
      'label' => 'G2 Crowd',
      'key' => array('tracking.g2crowd.com/attribution_tracking/conversions'),
      'category' => 'analytics',
      'status' => 'yes',
  ),
  array(
	  'id' => 'whizeos',
	  'label' => 'Whizeos',
	  'key' => array('services.whizeo.com/widgets/init.js'),
	  'category' => 'analytics',
	  'status' => 'yes',
  ),
 );
 return $scripts;
}
add_filter( 'cli_extend_script_blocker', 'cli_scripts_list', 10, 1 );

function wt_cli_alter_regex_patterns( $regex_array ){
 $regex_array['regexPatternScriptType'] = '/<script(?s)[^>]*?(type=(?:"|\')(.*?)(?:"|\')).*?>/';

 return $regex_array;
}
add_filter( 'wt_cli_script_blocker_regex_patterns', 'wt_cli_alter_regex_patterns', 10, 1 );


function hm_tutorial_video_menu() {
	add_menu_page(
		__( 'HM Help Hub', 'help-hub' ),
		__( 'HM Help Hub', 'help-hub' ),
		'manage_options',
		'hm-help-hub',
		'hm_help_hub_contents',
		'https://hewittmatthews.co.uk/wp-content/uploads/2022/06/white-favicon.png',
		3
	);
}
add_action( 'admin_menu', 'hm_tutorial_video_menu' );

function hm_help_hub_contents() {
	
	get_template_part('template-parts/admin/tutorial-videos'); 
	
}

?>