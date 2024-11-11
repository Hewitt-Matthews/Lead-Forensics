<?php


//Build Shortcode to get key speakers for section on webinars pages
add_shortcode( 'keySpeakers', 'webinars_key_speakers_func' );

function webinars_key_speakers_func( $atts ) {
    
	ob_start();
	
	$key_speakers = get_field('speakers_list');
	
    if ( $key_speakers ) { 
		?>	

		<h2>Key Speakers</h2>

		<div class="speakers-container">

			<?php foreach($key_speakers as $speaker) : ?>
	
				<?php 
					$speaker_name = $speaker['name'];
					$speaker_role = $speaker['role'];
					$speaker_company = $speaker['company'];
					$speaker_image = $speaker['image']['sizes']['medium'];
				?>
				
				
				<div class="speaker">
					
					<div class="head">
						<h3><?= $speaker_name ?></h3>
						<p><?= $speaker_role ?></p>
						<p><?= $speaker_company ?></p>
					</div>
					
					<img src="<?= $speaker_image ?>">
				
				</div>

			<?php endforeach; ?>
				
			
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};

//Build Shortcode to Loop Over webinars for recent webinars loop
add_shortcode( 'recentsWebinars', 'recent_webinars_loop_func' );

function recent_webinars_loop_func( ) {
	
	ob_start();
	
	$meta_query = array(
		array(
			'key' => 'webinar_date',
			'value' => date('Ymd'),
			'type' => 'DATE',
			'compare' => '<='
		)
	);
	
    $query = new WP_Query([
		'post_type' => 'webinars',
		'posts_per_page' => is_singular( 'webinars' ) ? 3 : 4,
		'post__not_in' => array(get_the_ID()),
		'order' => 'DESC',
		'orderby' => 'meta_value',
		'meta_key' => 'webinar_date',
		'meta_query' => $meta_query
	]);
	
    if ( $query->have_posts() ) { 
		?>	
		<div class="webinars-container">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php 	$webinar_video_info = get_field('video');
						$featuredImg = $webinar_video_info['video_thumbnail']['sizes']['large'];
			    		$featuredImgAltText = $webinar_video_info['video_title'] . ' image';
						$post_title = $webinar_video_info['video_title'];
						$post_excerpt = $webinar_video_info['video_description'];
						$post_link = get_the_permalink();
						$categories = get_the_terms(get_the_ID(), 'webinar_categories');
						$post_category = $categories[0]->name;
						$post_category_slug = $categories[0]->slug;
				?>

				<div class="webinar-info">
			  		<img src="<?= $featuredImg ?>" alt="<?= $featuredImgAltText ?>">
					<div class="post-meta">
						<p class="category <?= $post_category_slug ?>"><?= $post_category ?></p>
						<h3><?= $post_title ?></h3>
						<p><?= limit_text($post_excerpt, 30) ?>...</p>
						<a href="<?= $post_link ?>" class="lf-btn">Read more<span class='et-pb-icon'>&#x35;</span></a>
					</div>
			  	</div>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};

//Build Shortcode to Loop Over past webinars for past webinars loop
add_shortcode( 'pastWebinars', 'past_webinars_loop_func' );

function past_webinars_loop_func( ) {
    
	ob_start();
	
	$meta_query = array(
		array(
			'key' => 'webinar_date',
			'value' => date('Ymd'),
			'type' => 'DATE',
			'compare' => '<='
		)
	);
	
    $query = new WP_Query([
		'post_type' => 'webinars',
		'posts_per_page' => 4,
		'offset' => 4,
		'order' => 'DESC',
		'orderby' => 'meta_value',
		'meta_key' => 'webinar_date',
		'meta_query' => $meta_query
	]);
	
    if ( $query->have_posts() ) { 
		?>	

		<div class="webinars-container past">
			<template class="webinars-template">
				<div class="webinar-info">
			  		<img class="webinar-img">
					<div class="post-meta">
						<p class="category"></p>
						<h3 class="post-title"></h3>
						<p class="post-excerpt"></p>
						<a class="post-link lf-btn">Read more<span class='et-pb-icon'>&#x35;</span></a>
					</div>
			  	</div>
			</template>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php 	$webinar_video_info = get_field('video');
						$featuredImg = $webinar_video_info['video_thumbnail']['sizes']['large'];
			    		$featuredImgAltText = $webinar_video_info['video_title'] . ' image';
						$post_title = $webinar_video_info['video_title'];
						$post_excerpt = $webinar_video_info['video_description'];
						$post_link = get_the_permalink();
						$categories = get_the_terms(get_the_ID(), 'webinar_categories');
						$post_category = $categories[0]->name;
						$post_category_slug = $categories[0]->slug;
				?>

				<div class="webinar-info">
			  		<img src="<?= $featuredImg ?>" alt="<?= $featuredImgAltText ?>">
					<div class="post-meta">
						<p class="category <?= $post_category_slug ?>"><?= $post_category ?></p>
						<h3><?= $post_title ?></h3>
						<p><?= strip_tags(limit_text($post_excerpt, 30)) ?>...</p>
						<a href="<?= $post_link ?>" class="lf-btn">Read more<span class='et-pb-icon'>&#x35;</span></a>
					</div>
			  	</div>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};

// REST API
// ----------------------------------------------------

function getPastWebinars() {
	$webinars = array();
	$offset = htmlspecialchars($_GET["offset"]);
	$posts_per_page = 4;
	
	$meta_query = array(
		array(
			'key' => 'webinar_date',
			'value' => date('Ymd'),
			'type' => 'DATE',
			'compare' => '<='
		)
	);
	
	$query = new WP_Query([
		'post_type' => 'webinars',
		'posts_per_page' => $posts_per_page,
		'offset' => (isset($offset) && !empty($offset)) ? $offset : 0,
		'order' => 'DESC',
		'orderby' => 'meta_value',
		'meta_key' => 'webinar_date',
		'meta_query' => $meta_query
	]); 

	while ( $query->have_posts() ) : $query->the_post();
	
		$categories = get_the_terms(get_the_ID(), 'webinar_categories');
		$webinar_category = $categories[0]->name;
		$webinar_category_slug = $categories[0]->slug;
	
		array_push($webinars, array(
			"webinar_video_info" => get_field('video'),
			"webinar_category_name" => $webinar_category,
			"webinar_category_slug" => $webinar_category_slug,
			"link" => get_the_permalink(),
		));
	
	endwhile;

	return array(
		"webinars" => $webinars,
		"offset" => $offset,
		"noMorePosts" => $query->post_count < $posts_per_page
	);

}


// /wp-json/lead_forensics/v1/webinars/
add_action( 'rest_api_init', function () {
  register_rest_route( 'lead_forensics/v1', '/webinars/', array(
    'methods' => 'GET',
    'callback' => 'getPastWebinars',
  ));
});


//Build Shortcode to get upcoming webinar info
add_shortcode( 'upcomingWebinar', 'upcoming_webinar_func' );

function upcoming_webinar_func( $atts ) {
    
	ob_start();
	
	$upcoming_webinar_info = get_field('upcoming_webinar');
	
    if ( $upcoming_webinar_info ) { 
		?>	

		<div class="upcoming-webinar">
	
			<?php 
				$webinar_image = $upcoming_webinar_info['webinar_image']['sizes']['large'];
				$webinar_title = $upcoming_webinar_info['webinar_title'];
				$webinar_desc = $upcoming_webinar_info['webinar_description'];
				$button_text = $upcoming_webinar_info['button_text'] ? $upcoming_webinar_info['button_text'] : "Save your seat";
				$webinar_link = $upcoming_webinar_info['sign_up_link'];
			?>

			<img class="webinar-image" src="<?= $webinar_image ?>">

			<div class="info">
				
				<h2><?= $webinar_title ?></h2>
				<p><?= $webinar_desc ?></p>
				<a href="<?= $webinar_link ?>" class="lf-btn red"><?= $button_text ?><span class='et-pb-icon'>&#x35;</span></a>

			</div>

			
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};

//Build Shortcode to get upcoming webinar info
add_shortcode( 'upcomingWebinars', 'upcoming_webinars_loop_func' );

function upcoming_webinars_loop_func( ) {
	
	ob_start();
	
	get_template_part('template-parts/webinars/upcoming-webinars');

    return ob_get_clean();
 
};
