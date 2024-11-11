<?php


// // // // // // // // // // // // 
// 
// 
// 
// Shortcode Funtions
// 
// 
// 
//  // // // // // // // // // // // 


//Build Shortcode to Loop Over testimonials for testimonials swiper on home page
//
add_shortcode( 'testimonialsLoop', 'testimonals_loop_func' );
function testimonals_loop_func( $atts ) {
    
	ob_start();
    $query = new WP_Query( array(
        'post_type' => 'testimonials',
        'posts_per_page' => -1,
    ) );
	
    if ( $query->have_posts() ) { 
		?>	

		  <div class="testimonial-swiper swiper-container">
			<div class="quote-icons"></div>
			<div class="swiper-wrapper">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<?php 
						$testimonial_info = get_field_object('testimonial_info');
						$testimonial_text = $testimonial_info['value']['testimonial_text'];
						$testimonial_author = $testimonial_info['value']['testimonial_author'];
						$testimonial_author_role = $testimonial_info['value']['testimonial_author_role'];
					?>
					<div class="swiper-slide">	
								<p class="testimonial"><?= $testimonial_text ?></p>
								<div class="testimonial-author">
									<p><?= $testimonial_author ?></p>
									<p><?= $testimonial_author_role ?></p>
								</div>
					</div>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</div>
			<div class="swiper-scrollbar"></div>
 			<div class="swiper-button-next"></div>
      		<div class="swiper-button-prev"></div>
		  </div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};


//Build Shortcode to Loop Over featured Client Logos for Logos loop
add_shortcode( 'clientLogos', 'client_logos_loop_func' );

function client_logos_loop_func( $atts ) {
    
	ob_start();
    $query = new WP_Query( array(
        'post_type' => 'client-logos',
        'posts_per_page' => -1,
    ) );
	
    if ( $query->have_posts() ) { 
		?>	

		<div class="splide">
			<div class="client-logos-container splide__track">
				<ul class="splide__list">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<?php $featuredImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
					<?php $featuredImgAltText = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>
					<li class="splide__slide">
						<img loading="lazy" src="<?= $featuredImg[0] ?>" alt="<?= $featuredImgAltText ?>">
					</li>
				<?php endwhile;
				wp_reset_postdata(); ?>
				</ul>
			</div>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};

//Build Shortcode to Loop Over and show G2 Badges
add_shortcode( 'g2Badges', 'g2_badges_loop_func' );

function g2_badges_loop_func( $atts ) {
    
	ob_start();
	
    if ( $g2_badges = get_field('g2_badges', 'option') ) { 
		?>	

		<div class="g2-badges-container">
			<?php foreach ( $g2_badges as $badge ) : ?>
				
				<?= wp_get_attachment_image( $badge['badge_image'], "large", true, array( "loading" => "lazy" ) ); ?>
			
			<?php endforeach;
			wp_reset_postdata(); ?>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};


//Build Shortcode to Loop Over Case Studies for  Case Studies loop on homepage and individual Case Study pages
add_shortcode( 'faqs', 'faqs_func' );

function faqs_func( $atts ) {
    
	ob_start();
	
	if ($atts['category']) {
		$category = $atts['category'];
	}
	
    $query = new WP_Query( array(
        'post_type' => 'faqs',
        'posts_per_page' => -1,
		'tax_query' => (isset($category) && !empty($category)) ? [
			[
				'taxonomy' => 'question_categories',
				'field'    => 'slug',
				'terms'    => $category,
				'operator' => 'IN'
			],
		] : null
    ) );
	
    if ( $query->have_posts() ) { 
		?>	

		<div class="faqs-container">
			
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			
				<?php $faq_title = get_the_title();
						$faq_answer = get_field('answer');
				?>
			   	
				
				<div class="question-container">
					<div class="question">
						<h3><?= $faq_title ?></h3>
						<div class="question-toggle">
							<div class="icon">
								<div class="line one"></div>
								<div class="line two"></div>
							</div>					
						</div>
					</div>
			  		<div class="answer hidden">
						<p><?= $faq_answer ?></p>
					</div>
			  	</div>
			
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};

//Build Shortcode for wista video
add_shortcode( 'featuredVideo', 'featured_video_func' );

function featured_video_func( $atts ) {
    
	ob_start();

	?>
    
	<?php if ($video_id = get_field('video')['wistia_video_id']): ?>
	
		<?php if(!is_front_page()) : ?>

			<div class="video-container" data-videoID="<?= $video_id ?>"> 
				
				<div class="image-overlay" style="background: url(<?= get_field('video')['video_thumbnail']['sizes']['large'] ?>)">
					<div class="play-button"></div>
				</div>

				<script src="https://fast.wistia.com/embed/medias/<?= $video_id ?>.jsonp" async></script>
				<script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>

				<div class="wistia_responsive_padding" style="padding: 56.25% 0 0 0; position: relative;">
					<div class="wistia_responsive_wrapper" style="height: 100%; left: 0; position: absolute; top: 0; width: 100%;">
						<div class="wistia_embed wistia_async_<?= $video_id ?> seo=false videoFoam=true" style="height: 100%; position: relative; width: 100%;">
							<div class="wistia_swatch" style="height: 100%; left: 0; opacity: 0; overflow: hidden; position: absolute; top: 0; transition: opacity 200ms; width: 100%;"><img style="filter: blur(5px); height: 100%; object-fit: contain; width: 100%;" src="https://fast.wistia.com/embed/medias/<?= $video_id ?>/swatch" alt="video thumbnail" aria-hidden="true" onload="this.parentNode.style.opacity=1;" /></div>
						</div>
					</div>
				</div>

			</div>
	
		<?php else : ?>

			<div class="wistia" data-embed="<?= $video_id ?>" data-thumb="<?= get_field('video')['video_thumbnail']['sizes']['medium'] ?>">
					<div class="play-button"></div>
			</div>

		<?php endif; ?>

	<?php endif; ?>
					
    <?php $myvariable = ob_get_clean();
    return $myvariable;						 
};


//Build Shortcode to Loop Over product features for product features page
add_shortcode( 'productFeatures', 'product_features_func' );

function product_features_func( $atts ) {
	
	ob_start(); 

	if (have_rows('features')) : ?>

		<div class="benefits-container">

			<?php while( have_rows('features') ): the_row(); ?>
			
				<?php
					$benefit_title = get_sub_field('benefit_title');
					$benefit_desc = get_sub_field('benefit_description');
					$benefit_gif = get_sub_field('benefit_gif');
				?>
			
				<div class="benefit">

					<?php if( get_row_layout() == 'features_gif_with_image' ): ?>

						<?php $benefit_image = get_sub_field('benefit_image')['sizes']['large']; ?>

						<div class="image-with-gif" style="background: url(<?= $benefit_image ?>) ;">
							<img class="gif" src="<?= $benefit_gif?>">
						</div>

					<?php elseif( get_row_layout() == 'features_gif_only' ): ?>

						<div class="gif-only">
							<img class="gif" src="<?= $benefit_gif?>">
						</div>

					<?php endif; ?>
					
										
					<div class="content">
						
						<h2><?= $benefit_title ?></h2>
						<p><?= $benefit_desc ?></p>
						
						<?php if($demo_link = get_sub_field('show_demo_link')) : ?> 
							<a id="demo-btn" href="#" class="lf-btn demo-link">Request a Demo<span class='et-pb-icon'>&#x35;</span></a>
						<?php endif; ?>

					</div>

				</div>
			
			<?php endwhile; ?>
			
		</div>

	<?php 
	endif;
	$myvariable = ob_get_clean();
	return $myvariable;
	
}


//Build Shortcode to Loop Over compliance certs for grid on compliance page
add_shortcode( 'complianceGrid', 'compliance_grid_func' );

function compliance_grid_func( $atts ) {
    
	ob_start();
	
    if ( $certificates = get_field('certificates') ) { 
		?>	

		<div class="compliance-container">
			
			<?php foreach ( $certificates as $certificate ) : ?>
			
				<?php 	$certificate_title = $certificate['name'];
						$certificate_short_desc = $certificate['description'];
						$certificate_link = $certificate['link_to_page'] ? $certificate['page_link'] : $certificate['pdf'];
				?>
			   	
				
				<div class="certificate">
					<div class="head">
						<h3><?= $certificate_title ?></h3>
					</div>
			  		<div class="meta">
						<p><?= $certificate_short_desc ?></p>
						<a href="<?= $certificate_link ?>" class="lf-btn" target="_blank">Read more<span class='et-pb-icon'>&#x35;</span></a>
					</div>
			  	</div>
			
			<?php endforeach; ?>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};




//Build Shortcode to Grab Header Menus
add_shortcode( 'headerMenu', 'header_menu_func' );
function header_menu_func( $atts ) {
    
	ob_start();

	$menuID = 5;
	
	if($atts['menu'] == "2") {
		$menuID = 13;
	}  elseif($atts['menu'] == "3") {
		$menuID = 14;
	}

		?>	

	  <div class="header-menu">
		
		  <?php wp_nav_menu( array( 'menu' => $menuID ) );?>
		  
	  </div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
};

//Build Shortcode to Grab Header
add_shortcode( 'header', 'header_func' );
function header_func( $atts ) {
    
	ob_start();
		?>	
	
	<div class="desktop-menu">

		<?= do_shortcode('[headerMenu]') ?>

		<div class="contact-menu">

			<?php wp_nav_menu( array( 'menu' => 3 ) );?>

		</div>

<!-- 		<form role="search" method="get" class="et_pb_searchform" action="/">
			<div>
				<label class="screen-reader-text" for="s">Search for:</label>
				<input type="text" name="s" placeholder="Search website" class="et_pb_s" style="padding-right: 44px;">
				<input type="hidden" name="et_pb_searchform_submit" value="et_search_proccess">
				<input type="hidden" name="et_pb_include_posts" value="yes">
				<input type="hidden" name="et_pb_include_pages" value="yes">
				<input type="submit" value="⚲" class="et_pb_searchsubmit" style="">
			</div>
		</form> -->

<!-- 		<a id="demo-btn" class="demo-btn" href="#"><p>Try for Free<span class='et-pb-icon'>&#x35;</span></p></a>
 -->
<?php
// Fetch the ACF field values from the options page
$header_demo_button_url = get_field('header_demo_button_url', 'option');
$header_demo_button_text = get_field('header_demo_button_text', 'option') ?: 'Click Here';
$header_demo_link_new_tab = get_field('header_demo_link_new_tab', 'option');
$header_demo_popup_form = get_field('header_demo_popup_form', 'option');
$header_demo_popup_script = get_field('header_demo_popup_script', 'option');

// Determine if target="_blank" should be added
$target_attribute = $header_demo_link_new_tab ? ' target="_blank"' : '';

// Set up the link attributes
$button_attributes = '';
$onclick_event = '';
if ($header_demo_button_url) {
    $button_attributes .= ' href="' . esc_url($header_demo_button_url) . '"' . $target_attribute;
}
if ($header_demo_popup_form && !empty($header_demo_popup_script)) {
    $onclick_event = ' onclick="openHubSpotPopup(); return false;"';
}
?>

<a class="demo-btn"<?php echo $button_attributes . $onclick_event; ?>>
    <p><?php echo esc_html($header_demo_button_text); ?><span class='et-pb-icon'>&#x35;</span></p>
</a>

<?php if ($header_demo_popup_form && !empty($header_demo_popup_script)): ?>
    <div id="pop-up-form" class="et_pb_module et_pb_code et_pb_code_0 iframe-popup-white">
        <div>
            <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/embed/v2.js"></script>
            <script type="text/javascript">
                function openHubSpotPopup() {
                    var popupForm = document.getElementById('pop-up-form');
                    popupForm.classList.toggle('visible');
                    <?php echo wp_kses_post($header_demo_popup_script); ?>
                }
            </script>
        </div>
    </div>
<?php endif; ?>

<style>
a.demo-btn p {
    display: inline;
}
#iframe-popup-white {
    display: none;
}
#iframe-popup-white.visible {
    display: block;
}
</style>
	</div>

	<div class="mobile-menu">
		
		<div class="menu-btn">
			<div class="line one"></div>
			<div class="line two"></div>
			<div class="line three"></div>
		</div>
		
		<div class="menu">
			
			<div class="nav-head">

				<img src="/wp-content/uploads/2022/01/LF_Logo_White-01-min.png">
				
				<div class="menu-btn">
					<div class="line one"></div>
					<div class="line two"></div>
					<div class="line three"></div>
				</div>

			</div>
			
			<?= do_shortcode('[headerMenu]') ?>
			
<!-- 			<a id="demo-btn" class="demo-btn" href="#">Get a Demo<span class='et-pb-icon'>&#x35;</span></a> -->
<?php
// Fetch the ACF field values from the options page
$header_demo_button_url = get_field('header_demo_button_url', 'option');
$header_demo_button_text = get_field('header_demo_button_text', 'option') ?: 'Click Here';
$header_demo_link_new_tab = get_field('header_demo_link_new_tab', 'option');
$header_demo_popup_form = get_field('header_demo_popup_form', 'option');
$header_demo_popup_script = get_field('header_demo_popup_script', 'option');

// Determine if target="_blank" should be added
$target_attribute = $header_demo_link_new_tab ? ' target="_blank"' : '';

// Set up the link attributes
$button_attributes = '';
$onclick_event = '';
if ($header_demo_button_url) {
    $button_attributes .= ' href="' . esc_url($header_demo_button_url) . '"' . $target_attribute;
}
if ($header_demo_popup_form && !empty($header_demo_popup_script)) {
    $onclick_event = ' onclick="openHubSpotPopup(); return false;"';
}
?>

<a class="demo-btn"<?php echo $button_attributes . $onclick_event; ?>>
    <p><?php echo esc_html($header_demo_button_text); ?><span class='et-pb-icon'>&#x35;</span></p>
</a>

<?php if ($header_demo_popup_form && !empty($header_demo_popup_script)): ?>
    <div id="pop-up-form" class="et_pb_module et_pb_code et_pb_code_0 iframe-popup-white">
        <div>
            <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/embed/v2.js"></script>
            <script type="text/javascript">
                function openHubSpotPopup() {
                    var popupForm = document.getElementById('pop-up-form');
                    popupForm.classList.toggle('visible');
                    <?php echo wp_kses_post($header_demo_popup_script); ?>
                }
            </script>
        </div>
    </div>
<?php endif; ?>

<style>
a.demo-btn p {
    display: inline;
}
#iframe-popup-white {
    display: none;
}
#iframe-popup-white.visible {
    display: block;
}
</style>





			
		</div>
		
	</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
};

//Build Shortcode to Grab Footer
add_shortcode( 'footer', 'footer_func' );
function footer_func( $atts ) {
    
	ob_start();
		?>	

	<div class="footer-container">
	
		<div class="menus">
			<?= do_shortcode('[footerMenu]') ?>
			<?= do_shortcode('[footerMenu menu="2"]') ?>
			<?= do_shortcode('[footerMenu menu="3"]') ?>
			<?= do_shortcode('[footerMenu menu="4"]') ?>
		</div>
 
		<div class="links">
			
			<form role="search" method="get" class="et_pb_searchform" action="/">
				<div>
					<label class="screen-reader-text" for="s">Search for:</label>
					<input type="text" name="s" placeholder="Search website" class="et_pb_s" style="padding-right: 44px;">
					<input type="hidden" name="et_pb_searchform_submit" value="et_search_proccess">
					<input type="hidden" name="et_pb_include_posts" value="yes">
					<input type="hidden" name="et_pb_include_pages" value="yes">
					<input type="submit" value="⚲" class="et_pb_searchsubmit" style="">
				</div>
			</form>

			<?php
// Fetch the ACF field values from the options page
$header_demo_button_url = get_field('header_demo_button_url', 'option');
$header_demo_button_text = get_field('header_demo_button_text', 'option');
$header_demo_link_new_tab = get_field('header_demo_link_new_tab', 'option');

// Check if the fields have values before rendering the HTML
if ($header_demo_button_url && $header_demo_button_text):
    // Determine if target="_blank" should be added
    $target_attribute = $header_demo_link_new_tab ? ' target="_blank"' : '';
?>
			<a class="demo-btn" href="<?php echo esc_url($header_demo_button_url); ?>"<?php echo $target_attribute; ?>><p><?php echo esc_html($header_demo_button_text); ?><span class='et-pb-icon'>&#x35;</span></p>
</a>
<?php endif; ?>
			
			<?php if($social_accounts = get_field('social_media', 'option')) : ?>
			
				<div class="social-icons">
					
					<?php foreach($social_accounts as $account) : ?>
					
						<?php 
							$social_icon;
							$tiktok = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2859 3333" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd"><path d="M2081 0c55 473 319 755 778 785v532c-266 26-499-61-770-225v995c0 1264-1378 1659-1932 753-356-583-138-1606 1004-1647v561c-87 14-180 36-265 65-254 86-398 247-358 531 77 544 1075 705 992-358V1h551z" style="fill: #fff;"/></svg>';
	
							if($account['platform'] == 'facebook'){ $social_icon = "<span class='et-pb-icon'>&#xe093;</span>"; }
							if($account['platform'] == 'twitter'){ $social_icon = "<span class='et-pb-icon'>&#xe094;</span>"; }
							if($account['platform'] == 'instagram'){ $social_icon = "<span class='et-pb-icon'>&#xe09a;</span>"; }
							if($account['platform'] == 'linkedin'){ $social_icon = "<span class='et-pb-icon'>&#xe09d;</span>"; }
							if($account['platform'] == 'youtube'){ $social_icon = "<span class='et-pb-icon'>&#xe0a3;</span>"; }
							if($account['platform'] == 'tiktok'){ $social_icon = "<span>" . $tiktok . "</span>"; }
						?>
					
					
						<a href="<?= $account['link'] ?>" target="_blank" class="<?= $account['platform'] ?>"><?= $social_icon ?></a>
					
					<?php endforeach; ?>

				</div>
			
			<?php endif; ?>
			
			<?php if($accreditations = get_field('accreditations', 'option')) : ?>
			
				<div class="accreditations">
					
					<?php foreach($accreditations as $accreditation) : ?>
					
						<a href="/compliance/"><img src="<?= $accreditation['logo'] ?>" alt="<?= $accreditation['accreditation_name'] ?>"></a>
					
					<?php endforeach; ?>

				</div>
			
			<?php endif; ?>
			
		</div>
		
	</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
};

//Build Shortcode to Grab Footer Menus
add_shortcode( 'footerMenu', 'footer_menu_func' );
function footer_menu_func( $atts ) {
    
	ob_start();

	$menuID = 9;
	$menuTitle = "Product";
	
	if($atts['menu'] == "2") {
		$menuID = 10;
		$menuTitle = "Customers";
	}  elseif($atts['menu'] == "3") {
		$menuID = 11;
		$menuTitle = "Resources";
	} elseif($atts['menu'] == "4") {
		$menuID = 12;
		$menuTitle = "About Us";
	} elseif($atts['menu'] == "legal") {
		$menuID = 31;
		$menuTitle = "";
	}

		?>	

	  <div class="footer-menu">
		
		  <?php if($menuTitle) : ?>
		  	<h3><?= $menuTitle ?></h3>
		  <?php endif; ?>
		  <?php wp_nav_menu( array( 'menu' => $menuID ) );?>
		  
	  </div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
};

//Build Shortcode to create calendly pop up
//add_shortcode( 'calendlyPopUp', 'calendly_embed_func' );
function calendly_embed_func( $atts ) {
    
	ob_start(); 
	global $post;
	
	?>	

	<!-- Calendly inline widget begin -->
	<div class="calendly-inline-widget" style="min-width:320px;height:580px;" data-auto-load="false">
	<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
	<script>
			
			Calendly.initInlineWidget({
					url: 'https://calendly.com/tomcleverly/lead-forensics-trial-setup',
					utm: {
						 utmCampaign: "Calendly Website Embed",
						 utmSource: "Wesbite",
						 utmMedium: "Direct",
						 utmContent: "<?= get_the_permalink( $post->ID ) ?>"
					}
				});
		
	</script>
	</div>
	<!-- Calendly inline widget end -->

    <?php 
	wp_reset_postdata();
	$myvariable = ob_get_clean();
    return $myvariable;
};


?>