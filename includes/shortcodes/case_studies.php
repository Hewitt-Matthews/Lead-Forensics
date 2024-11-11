<?php 

//Build Shortcode to Loop Over Case Studies for  Case Studies loop on homepage and individual Case Study pages
add_shortcode( 'caseStudies', 'case_studies_loop_func' );

function case_studies_loop_func( $atts ) {
    
	ob_start();
    $query = new WP_Query( array(
        'post_type' => 'case-studies',
        'posts_per_page' => 3,
		'post__not_in' => array(get_the_ID()),
    ) );
	
    if ( $query->have_posts() ) { 
		?>	

		<div class="case-studies-container">
			
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			
				<?php $case_study_title = get_field('case_study_title');
						$case_study_logo = get_field('company_logo')['sizes']['medium'];
						$case_study_image = get_field('featured_image')['sizes']['medium'];
						$case_study_link = get_the_permalink();
				?>
			   	
				
				<div class="case-study">
					<div class="head" style="background: url(<?= $case_study_image ?>);">
						<img src="<?= $case_study_logo ?>" alt="Image for <?= $case_study_title ?>" loading="lazy">
					</div>
			  		<div class="meta">
						<h3><?= $case_study_title ?></h3>
						<a href="<?= $case_study_link ?>" class="lf-btn">Read More<span class='et-pb-icon'>&#x35;</span></a>
					</div>
			  	</div>
			
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};


//Build Shortcode to create side bar widget for induvidual case studys
add_shortcode( 'caseStudySidebarWidget', 'case_studies_sidebar_widget_func' );

function case_studies_sidebar_widget_func( $atts ) {
    
	ob_start();
	
	$widget_info = get_field('sidebar_widget_info');
	$client_logo = get_field('company_logo')['sizes']['medium'];
	$widget_bg = $widget_info['widget_image']['sizes']['medium'];
	$widget_text = $widget_info['widget_information'];
	
    if ( $widget_info ) { 
		?>	

		<div class="sidebar-widget">
			
			<div class="logo" style="background: url(<?= $widget_bg ?>)">
				<img src="<?= $client_logo ?>" alt="<?= get_the_title() ?> logo">
			</div>
			
			<div class="widget-info">
				
				<?php foreach($widget_text as $info_block) : ?>
				
					<div class="info-block">
						
						<h4><?= $info_block['title'] ?></h4>
						<p><?= $info_block['text'] ?></p>
						
					</div>
				
				<?php endforeach; ?>
				
			</div>
			
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};

//Build Shortcode to create case study stats boxes for induvidual case studys
add_shortcode( 'caseStudyStats', 'case_studies_stats_func' );

function case_studies_stats_func( $atts ) {
    
	ob_start();
	
	$statistics = get_field('statistic_box');
	
    if ( $statistics ) { 
		?>	

		<div class="statistics-container">
				
			<?php foreach($statistics as $statistic_info) : ?>

				<div class="stat-block">

					<h3><span><?= $statistic_info['headline_stat'] ?></span><?= $statistic_info['headline_text'] ?></h3>
					<p><?= $statistic_info['copy_text'] ?></p>

				</div>

			<?php endforeach; ?>
			
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};

//Build Shortcode to Loop Over Case Studies categories for Case Studies filter on Case Study page
add_shortcode( 'caseStudiesCategories', 'case_studies_categories_func' );

function case_studies_categories_func( $atts ) {
    
	ob_start();
	
	get_template_part('template-parts/case-studies/content', 'category-filter');
	
    return ob_get_clean();

};

//Build Shortcode to fetch image or video for hero on each Case Study page
add_shortcode( 'caseStudyHeroMedia', 'case_studies_media_func' );

function case_studies_media_func( $atts ) {
    
	ob_start();
	
	get_template_part('template-parts/case-studies/content', 'hero-media');
	
    return ob_get_clean();

};

//Build Shortcode to Loop Over Case Studies for Case Studies grid on Case Study page
add_shortcode( 'caseStudiesGrid', 'case_studies_grid_func' );

function case_studies_grid_func( $atts ) {
    
	ob_start();
    $query = new WP_Query( array(
        'post_type' => 'case-studies',
        'posts_per_page' => 4,
		'post__not_in' => array(get_the_ID()),
    ) );
	
    if ( $query->have_posts() ) { 
		?>	

		<template class="case-study-template">
			<a href="" class="case-study">
				<div class="bg-image"></div>
				<img>
				<h3></h3>
			</a>
		</template>

		<div class="case-studies-grid-container">
			
			<?php $count = 1; while ( $query->have_posts() ) : $query->the_post(); ?>
			
				<?php $case_study_title = get_field('case_study_title');
						$case_study_logo = get_field('company_logo')['sizes']['medium'];
						$case_study_image = get_field('featured_image')['sizes']['large'];
						$case_study_link = get_the_permalink();
						$case_study_colour = get_field('case_study_colour');
						$case_study_category = get_the_terms( $post->ID, 'case_study_categories' )[0]->slug;
				?>

					<a href="<?= $case_study_link ?>"
					   class="case-study"
					   data-category="<?= $case_study_category ?>"
					   style="background: linear-gradient(0deg, <?= $case_study_colour ?> 0%, rgba(0, 0, 0, 0.3) 100%);">
						<div class="bg-image" style="background: url(<?= $case_study_image ?>);"></div>
						<img src="<?= $case_study_logo ?>">
						<h3><?= $case_study_title ?><span class='et-pb-icon'>&#x35;</span></h3>
					</a>
	
			
			<?php $count++; endwhile; wp_reset_postdata(); ?>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};

//Build Shortcode to Loop Over featured case study reviews for case study page
add_shortcode( 'caseStudyReviews', 'case_study_reviews_func' );

function case_study_reviews_func( $atts ) {
    
	ob_start();
	$reviews = get_field('reviews');
	$top_reviews = [];
	$bottom_reviews = [];
	
	foreach ($reviews as $k => $v) {
		
		if ($k % 2 == 0) {
			array_push($top_reviews, $v);
		} else {
			array_push($bottom_reviews, $v);
		}
		
	} ?>
	
	
   <?php if ( $top_reviews ) : ?>	

		<div class="case-study-swiper top splide">
			<div class="splide__track">
				<div class="splide__list">	
					<?php foreach ( $top_reviews as $review ) : ?>
						<?php 
							$review_info = $review['review_text'];
							$reviewer_name = $review['reviewer_name'];
							$review_location = $review['review_location'];
						?>
						<div class="splide__slide">	
							<div class="review">

								<p><?= $review_info ?></p>
								<div class="review-author">
									<p><?= $reviewer_name ?></p>
									<p><?= $review_location ?></p>
								</div>

							</div>
						</div>
					<?php endforeach; ?>
					</div>
			</div>
		</div>
				
    <?php endif; ?>

	<?php if ( $bottom_reviews ) : ?>	

		<div class="case-study-swiper bottom splide">
			<div class="splide__track">
				<div class="splide__list">	
					<?php foreach ( $bottom_reviews as $review ) : ?>
						<?php 
							$review_info = $review['review_text'];
							$reviewer_name = $review['reviewer_name'];
							$review_location = $review['review_location'];
						?>
						<div class="splide__slide">	
							<div class="review">

								<p><?= $review_info ?></p>
								<div class="review-author">
									<p><?= $reviewer_name ?></p>
									<p><?= $review_location ?></p>
								</div>

							</div>
						</div>
					<?php endforeach; ?>
					</div>
			</div>
		</div>
				
    <?php endif; ?>
	
	<?php $myvariable = ob_get_clean();
    return $myvariable;
};

//
//
//Rest API
//
//


function getCaseStudies() {
	$case_studies = array();
	$offset = htmlspecialchars($_GET["offset"]);
	$posts_per_page = 4;
	$category = htmlspecialchars($_GET["category"]);
	
	if($category == "all") {
		$category = NULL;
	}
	
	$query = new WP_Query([
		'post_type' => 'case-studies',
		'posts_per_page' => $posts_per_page,
		'offset' => (isset($offset) && !empty($offset)) ? $offset : 0,
		'tax_query' => $category ? array(
        	array(
				'taxonomy' => 'case_study_categories',
				'field'    => 'slug',
				'terms'    => $category,
			),
		) : NULL,
	]); 

	while ( $query->have_posts() ) : $query->the_post();
	
		array_push($case_studies, array(
			"featuredImg" => get_field('featured_image')['sizes']['large'],
			"title" => get_field('case_study_title'),
			"logo" => get_field('company_logo')['sizes']['medium'],
			"link" => get_the_permalink(),
			"colour" => get_field('case_study_colour'),
			"category" => get_the_terms( $post->ID, 'case_study_categories' )[0]->slug,
		));
	
	endwhile;

	return array(
		"case_studies" => $case_studies,
		"category" => $category,
		"offset" => $offset,
		"noMorePosts" => $query->post_count < $posts_per_page
	);

}

// /wp-json/lead_forensics/v1/case-studies/
add_action( 'rest_api_init', function () {
  register_rest_route( 'lead_forensics/v1', '/case-studies/', array(
    'methods' => 'GET',
    'callback' => 'getCaseStudies',
  ));
});