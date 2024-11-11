<?php

//Build Shortcode to Loop Over podcasts for recent webinars loop
add_shortcode( 'recentPodcasts', 'recent_podcasts_loop_func' );

function recent_podcasts_loop_func( ) {
	
	ob_start();
	
    $query = new WP_Query([
		'post_type' => 'podcasts',
		'posts_per_page' => 3,
		'post__not_in' => array(get_the_id()),
		'order' => 'DESC',
	]);
	
    if ( $query->have_posts() ) { 
		?>

		<div class="podcasts-container">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php 	$podcast_info = get_field('podcast');
						$featuredImg = $podcast_info['podcast_thumbnail']['sizes']['large'];
			    		$featuredImgAltText = $podcast_info['podcast_title'] . ' image';
						$post_title = $podcast_info['podcast_title'];
						$post_excerpt = $podcast_info['podcast_description'];
						$post_link = get_the_permalink();
						$categories = get_the_terms(get_the_ID(), 'podcast_categories');
						$post_category = $categories[0]->name;
						$post_category_slug = $categories[0]->slug;
						$post_category_url = get_term_link($categories[0], 'podcast_categories');
				?>

				<div class="podcast-info">
			  		<img src="<?= $featuredImg ?>" alt="<?= $featuredImgAltText ?>">
					<div class="post-meta">
						<p class="category <?= $post_category_slug ?>"><a href="<?= $post_category_url ?>"><?= $post_category ?></a></p>
						<h3><?= $post_title ?></h3>
						<?php if($post_excerpt) : ?><p><?= $post_excerpt ?></p><?php endif; ?>
						<a href="<?= $post_link ?>" class="lf-btn">Listen Now<span class='et-pb-icon'>&#x35;</span></a>
					</div>
			  	</div>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>

    <?php return ob_get_clean();
    }
};




//Build Shortcode to Loop Over past podcasts for past podcasts loop
add_shortcode( 'pastPodcasts', 'past_podcasts_loop_func' );

function past_podcasts_loop_func( ) {
    
	ob_start();
	
    $query = new WP_Query([
		'post_type' => 'podcasts',
		'posts_per_page' => 3,
		'post__not_in' => array(get_the_id()),
		'offset' => 3,
		'order' => 'DESC',
	]);
	
    if ( $query->have_posts() ) { 
		?>	

		<div class="podcasts-container past">
			<template class="podcast-template">
				<div class="podcast-info">
			  		<img class="podcast-img">
					<div class="post-meta">
						<p class="category"></p>
						<h3 class="post-title"></h3>
						<p class="post-excerpt"></p>
						<a class="post-link lf-btn">Listen Now<span class='et-pb-icon'>&#x35;</span></a>
					</div>
			  	</div>
			</template>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php 	$podcast_info = get_field('podcast');
						$featuredImg = $podcast_info['podcast_thumbnail']['sizes']['large'];
			    		$featuredImgAltText = $podcast_info['podcast_title'] . ' image';
						$post_title = $podcast_info['podcast_title'];
						$post_excerpt = $podcast_info['podcast_description'];
						$post_link = get_the_permalink();
						$categories = get_the_terms(get_the_ID(), 'podcast_categories');
						$post_category = $categories[0]->name;
						$post_category_slug = $categories[0]->slug;
						$post_category_url = get_term_link($categories[0], 'podcast_categories');
				?>

				<div class="podcast-info">
			  		<img src="<?= $featuredImg ?>" alt="<?= $featuredImgAltText ?>">
					<div class="post-meta">
						<p class="category <?= $post_category_slug ?>"><a href="<?= $post_category_url ?>"><?= $post_category ?></a></p>
						<h3><?= $post_title ?></h3>
						<?php if($post_excerpt) : ?><p><?= $post_excerpt ?></p><?php endif; ?>
						<a href="<?= $post_link ?>" class="lf-btn">Listen Now<span class='et-pb-icon'>&#x35;</span></a>
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

function getPastPodcasts() {
	$podcasts = array();
	$offset = htmlspecialchars($_GET["offset"]);
	$posts_per_page = 3;
	
    $query = new WP_Query([
        'post_type' => 'podcasts',
        'posts_per_page' => $posts_per_page,
        'offset' => ( isset( $offset ) && !empty( $offset ) ) ? $offset : 0,
        'order' => 'DESC',
    ]);

	while ( $query->have_posts() ) : $query->the_post();
	
	$categories = get_the_terms(get_the_ID(), 'podcast_categories');
	$post_category = $categories[0]->name;
	$post_category_slug = $categories[0]->slug;
	
		array_push($podcasts, array(
			"podcast_title" => get_the_title(),
			"podcast_category" => $post_category,
			"podcast_category_slug" => $post_category_slug,
			"podcast_img" => get_field('podcast')['podcast_thumbnail']['sizes']['large'],
			"link" => get_the_permalink(),
		));
	
	endwhile;

    return array(
        "podcasts" => $podcasts,
        "offset" => $offset,
        "noMorePosts" => $query->post_count < $posts_per_page
    );

}


// /wp-json/lead_forensics/v1/podcasts/
add_action( 'rest_api_init', function () {
  register_rest_route( 'lead_forensics/v1', '/podcasts/', array(
    'methods' => 'GET',
    'callback' => 'getPastPodcasts',
  ));
});




//Build Shortcode for featured podcast
add_shortcode( 'featuredPodcast', 'featured_podcast_func' );

function featured_podcast_func( $atts ) {
    
	ob_start();
	
	$podcast_id = get_field('podcast')['podcast_id'];
		
	?>
    
	<?php if ($podcast_id): ?>
	
	<?= $podcast_id ?>

	<?php endif; ?>
					
    <?php $myvariable = ob_get_clean();
    return $myvariable;						 
};





//Build Shortcode to Loop Over podcasts for categories
add_shortcode( 'recentPodcastsCategory', 'recent_podcasts_category_loop_func' );

function recent_podcasts_category_loop_func() {
    ob_start();
    
    $current_category = get_queried_object();
    
    $query = new WP_Query([
        'post_type' => 'podcasts',
        'posts_per_page' => -1,
        'order' => 'DESC',
        'tax_query' => [
            [
                'taxonomy' => 'podcast_categories',
                'field' => 'term_id',
                'terms' => $current_category->term_id,
            ],
        ],
    ]);
    
    if ($query->have_posts()) { ?>
        <div class="podcasts-container">
            <?php while ($query->have_posts()) : $query->the_post();
                $podcast_info = get_field('podcast');
                $featuredImg = $podcast_info['podcast_thumbnail']['sizes']['large'];
                $featuredImgAltText = $podcast_info['podcast_title'] . ' image';
                $post_title = $podcast_info['podcast_title'];
                $post_excerpt = $podcast_info['podcast_description'];
                $post_link = get_the_permalink();
                $categories = get_the_terms(get_the_ID(), 'podcast_categories');
                $post_category = $categories[0]->name;
                $post_category_slug = $categories[0]->slug;
            ?>
            <div class="podcast-info">
                <img src="<?= $featuredImg ?>" alt="<?= $featuredImgAltText ?>">
                <div class="post-meta">
                    <p class="category <?= $post_category_slug ?>"><?= $post_category ?></p>
                    <h3><?= $post_title ?></h3>
                    <?php if ($post_excerpt) : ?><p><?= $post_excerpt ?></p><?php endif; ?>
                    <a href="<?= $post_link ?>" class="lf-btn">Listen Now<span class='et-pb-icon'>&#x35;</span></a>
                </div>
            </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
    <?php
        return ob_get_clean();
    }
}