<?php

require_once __DIR__ . '/../../functions.php';

// Create shortcode to grab featured blog post for blog page
add_shortcode( 'latestPosts', 'latest_posts_func' );

function latest_posts_func( $atts ) {
    
	ob_start();
	
	$category_name = is_home() ? 'blog' : 'news';
	$page_heading = $category_name == 'blog' ? get_field('page_heading', 334) : get_field('page_heading', 349);
	$page_subheading = $category_name == 'blog' ? get_field('page_subheading', 334) : get_field('page_subheading', 349);
	
    $query = new WP_Query( array(
        'post_type' => 'post',
        'posts_per_page' => 3,
		'category_name' => $category_name,
    ) );
	
    if ( $query->have_posts() ) { 
		?>	
	
		<div class="page-title">
			<h1><?= $page_heading ?> </h1>
			<p><?= $page_subheading ?> </p>
		</div>

		<div class="latest-posts">
			<?php $count = 1; while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php $featuredImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
					$categories = get_the_category();
					$post_category;
					$post_category_slug;
					foreach ($categories as $category) {
						if ($category->category_parent) {
							$parent_cat = get_category($category->category_parent)->slug;
							if($category_name == $parent_cat) {
								$post_category = $category->name;
								$post_category_slug = $category->slug;
							}
						}
					}
				?>
			
				<?php if($count == 1) : ?>

					<div class="latest-post">
						<img src="<?= $featuredImg[0] ?>">
						<div class="post-meta">
							<h2><?= get_the_title(); ?></h2>
							<p><?= limit_text(get_the_excerpt(), 30) ?>...</p>
							<a href="<?= the_permalink(); ?> " class="lf-btn red">Read more<span class='et-pb-icon'>&#x35;</span></a>
						</div>
					</div>
			
				<?php else : ?>
			
					<div class="post">
						<img src="<?= $featuredImg[0] ?>">
						<div class="post-meta">
							<p class="category <?= $post_category_slug ?>"><?= $post_category ?></p>
							<h2><?= get_the_title(); ?></h2>
							<p><?= limit_text(get_the_excerpt(), 30) ?>...</p>
							<a href="<?= the_permalink(); ?> " class="lf-btn">Read more<span class='et-pb-icon'>&#x35;</span></a>
						</div>
					</div>
			
				<?php endif; ?>
			  	
			<?php $count++; endwhile;
			wp_reset_postdata(); ?>
		</div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};



//Build Shortcode to Loop Over post categories
add_shortcode( 'postCategories', 'display_post_categories_func' );

function display_post_categories_func( ) {
    
	ob_start();
    $partners_category = get_terms(
		array('category'),
		array(
				'hide_empty'    => true,
				'orderby'       => 'name',
				'order'         => 'ASC',
			)
	); ?>
	
	<ul class="cat-list">
		<li><a class="cat-list_item active" href='#' data-slug="">All</a></li>

	<?php foreach($partners_category as $category) : ?>
		<li><a class="cat-list_item" href="#" data-slug="<?= $category->slug; ?>"><?= $category->name; ?></a></li>
	<?php endforeach; ?>
	
	</ul>

    <?php 	$myvariable = ob_get_clean();
    		return $myvariable;
};

//Build Shortcode to Loop Over Blog categories for blog filter on blog page
add_shortcode( 'blogCategories', 'blog_filter_func' );

function blog_filter_func( $atts ) {
    
	ob_start();
	
	get_template_part('template-parts/blog/blog', 'category-filter');
	
    return ob_get_clean();

};


//Build Shortcode to Loop Over posts categories for news page loop
add_shortcode( 'blogGrid', 'post_grid_loop_func' );

function post_grid_loop_func( ) {
	
	ob_start();
	
    get_template_part('template-parts/blog/blog', 'grid');
	
	return ob_get_clean();

};

//Build Shortcode to fetch blog author
add_shortcode( 'blogAuthor', 'blog_author_func' );

function blog_author_func( ) {
	
	ob_start();
	
    get_template_part('template-parts/blog/blog', 'author');
	
	return ob_get_clean();

};


// REST API
// ----------------------------------------------------

function getBlogPosts() {
	$posts = array();
	$category = htmlspecialchars($_GET["category"]);
	$offset = htmlspecialchars($_GET["offset"]);
	$posts_per_page = 5;
	$page = htmlspecialchars($_GET["page"]);
	
	if(!$category) {
		$category = $page == "blog" ? 'blog' : 'news';
	} elseif($category == "all") {
		
		$category = $page == "blog" ? 'blog' : 'news';
		
	}
	
	
	$query = new WP_Query([
		'post_type' => 'post',
		'posts_per_page' => 999,
		'offset' => (isset($offset) && !empty($offset)) ? $offset : 0,
		'category_name' => $category
	]); 
	
	$count = 0;

	while ( $query->have_posts() ) : $query->the_post();
	
		$categories = get_the_category();
	
		if($count < $posts_per_page ) {
			array_push($posts, array(
				"featuredImg" => wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ),
				"featuredImgAltText" => get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ),
				"title" => html_entity_decode(get_the_title()),
				"link" => get_the_permalink(),
				"excerpt" => strip_tags(limit_text(get_the_excerpt(), 30)),
				"categories" => $categories,
			));
			$count++;
		}
	
	endwhile;

	return array(
		"posts" => $posts,
		"post_count" => $query->post_count,
		"count" => $count,
		"category" => $category,
		"offset" => $offset,
		"noMorePosts" => $query->post_count <= $posts_per_page
	);

}


// /wp-json/lead_forensics/v1/blog/posts/
add_action( 'rest_api_init', function () {
  register_rest_route( 'lead_forensics/v1', '/blog/posts/', array(
    'methods' => 'GET',
    'callback' => 'getBlogPosts',
  ));
});

//Build Shortcode to display share links for single blog page
add_shortcode( 'socialShare', 'social_buttons' );

function social_buttons() {
	ob_start();
    global $post;
    $permalink = get_permalink($post->ID);
    $title = get_the_title();
    if(is_single() && !is_page()) { ?>
        <div class="share">
				<span>Share</span>
				<a target="_blank"  href="https://www.facebook.com/sharer/sharer.php?u=<?= $permalink ?>"
				onclick="window.open(this.href, \'facebook-share\',\'width=580,height=296\');return false;"><span class='et-pb-icon'>&#xe093;</span></a>
				<a target="_blank"  href="http://twitter.com/share?text=<?= $title ?>&url=<?= $permalink ?>"
				onclick="window.open(this.href, \'twitter-share\', \'width=550,height=235\');return false;"><span class='et-pb-icon'>&#xe094;</span></a>
				<a target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $permalink ?>"
				onclick="window.open(this.href, \'linkedin-share\', \'width=490,height=530\');return false;"><span class='et-pb-icon'>&#xe09d;</span></a>
		</div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}

//Build Shortcode to display related posts loop for single blog page
add_shortcode( 'relatedPosts', 'related_posts_loop_func' );

function related_posts_loop_func( $atts ) {
    
	ob_start();
	$current_categories = get_the_category();
	$current_post_category;
	
	foreach($current_categories as $category) {
		if(!$category->category_parent) {
			$current_post_category = $category->term_id;
		}
	}
	
	$all_categories = get_categories();
	$parent_categories = array();
	
	foreach($all_categories as $category) {
		
		if(!$category->category_parent) {
			if($category->term_id != $current_post_category) {
				array_push($parent_categories, $category->term_id);
			}
		}
		
	}
	
    $query = new WP_Query( array(
        'post_type' => 'post',
        'posts_per_page' => 3,
		'post__not_in' => array(get_the_ID()),
		'category__not_in' => $parent_categories,
    ) );
	
    if ( $query->have_posts() ) { 
		?>	

		<div class="related-posts-container">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php 	$featuredImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			    		$featuredImgAltText = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
						$post_title = get_the_title();
						$post_link = get_the_permalink();
						$categories = get_the_category();
						$post_category = $categories[1]->name;
						$post_category_slug = $categories[1]->slug;
						foreach ($categories as $category) {
							if ($category->category_parent) {
								
									$post_category = $category->name;
									$post_category_slug = $category->slug;
								
							}
						}
				?>
				<div class="post-info">
			  		<img src="<?= $featuredImg[0] ?>" alt="<?= $featuredImgAltText ?>">
					<div class="post-meta">
						<p class="category <?= $post_category_slug ?>"><?= $post_category ?></p>
						<h3><?= $post_title ?></h3>
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

//Build Shortcode to display related posts loop for single blog page
add_shortcode( 'relatedPostsWidget', 'related_posts_widget_loop_func' );

function related_posts_widget_loop_func( $atts ) {
    
	ob_start();
	
	$category_slug = get_the_category()[1]->slug;
	$category_name = get_the_category()[1]->name;
	$posts_to_show = get_sub_field('posts_to_show') ? get_sub_field('posts_to_show') : 3;
	
    $query = new WP_Query( array(
        'post_type' => 'post',
        'posts_per_page' => $posts_to_show,
		'post__not_in' => array(get_the_ID()),
		'category_name' => $category_name,
    ) );
	
    if ( $query->have_posts() ) { 
		?>	

		<div class="related-posts-container">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php 	$featuredImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
			    		$featuredImgAltText = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
						$post_title = get_the_title();
						$post_link = get_the_permalink();
				?>		
				<div class="post-info">
			  		<img src="<?= $featuredImg[0] ?>" alt="<?= $featuredImgAltText ?>">
					<div class="post-meta">
						<p class="category <?= $category_slug ?>"><?= $category_name ?></p>
						<h3><?= $post_title ?></h3>
						<a href="<?= $post_link ?>" class="lf-btn">Find out more<span class='et-pb-icon'>&#x35;</span></a>
					</div>
			  	</div>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};


//Build Shortcode to generate blog post contents list
add_shortcode( 'blogPostContents', 'blog_post_contents_func' );

function blog_post_contents_func( $atts ) {
	 
	ob_start();
	
	$show_post_contents = get_field('show_contents');
	$post_contents_list = get_field('contents');
	
	if ( $post_contents_list && $show_post_contents ) : ?>	

	
		<h3>Contents</h3>
		<ol class="contents-list">
			
			<?php $count = 1; foreach($post_contents_list as $content_item ) : ?>
			
				<li><span><?= $count ?></span><a href="#<?= $content_item['content_link'] ?>"><?= $content_item['content_title'] ?></a></li>
			
			<?php $count++; endforeach; ?>
			
		</ol>

	   
	<?php endif;
    return ob_get_clean();
};

//Build Shortcode to generate free trial widget
add_shortcode( 'freeTrialWidget', 'free_trial_widget_func' );

function free_trial_widget_func( $atts ) {
	 
	ob_start(); ?>

	<div class="free-trial-widget widget">
		
		<div class="head">
			<h3>Need more leads?</h3>
		</div>
		<div class="widget-info body">
			<p>98% of your website vistors don't inquire. We tell you who they are, in real time.</p>
			<p>Get started today and super-charge your business growth.</p>
			<a id="demo-btn" href="#free-trial" class="lf-btn red">Set up your free trial<span class='et-pb-icon'>&#x35;</span></a>
		</div>

	</div>
	   
	<?php
    return ob_get_clean();
};


//Build Shortcode to generate widget for blog posts
add_shortcode( 'blogPostWidgets', 'blog_post_widgets_func' );

function blog_post_widgets_func( $atts ) {
	 
	ob_start();
	
	if( have_rows('sidebar_widgets') ): ?>

		<?php while( have_rows('sidebar_widgets') ): the_row(); ?>
			
			<?php if( get_row_layout() == 'about_lead_forensics' ): ?>

				<?php $button_text = get_field('blog_widget_buttons', 'option')['about_lead_forensics']['button_text'];
						$button_link = get_field('blog_widget_buttons', 'option')['about_lead_forensics']['button_link'];
				?>

				<div class="about-lf-widget widget">
					
					<div class="logo" style="background: url(/wp-content/uploads/2021/11/portakabin-background-image.jpg.jpg)">
						<img src="/wp-content/uploads/2021/11/LF_Logo_White-01.png" alt="lead forensics logo">
					</div>

					<div class="widget-info">

						<h4>About Lead Forensics</h4>
						<p>Lead Forensics is a multi award-winning B2B website visitor identification software that eliminates the need for on-site inquiries and instantly increases website conversion.</p>
						<a href="<?= $button_link ? $button_link : "/pricing" ?>" class="lf-btn"><?= $button_text ? $button_text : "Find out more" ?><span class='et-pb-icon'>&#x35;</span></a>

					</div>

				</div>
				
			<?php elseif( get_row_layout() == 'try_lead_forensics' ): ?>

				<?php $button_text = get_field('blog_widget_buttons', 'option')['try_lead_forensics']['button_text'];
						$button_link = get_field('blog_widget_buttons', 'option')['try_lead_forensics']['button_link'];
						$show_demo_form = get_field('blog_widget_buttons', 'option')['try_lead_forensics']['show_demo_form'];
						$show_custom_form = get_field('blog_widget_buttons', 'option')['try_lead_forensics']['show_custom_form'];
						$show_custom_form_shortcode = get_field('blog_widget_buttons', 'option')['try_lead_forensics']['custom_form_shortcode'];
				?>

				<div class="try-lf-widget widget">
					<div class="head">
						<h3>Discover the identity of your website visitors - and convert them to sales.</h3>
					</div>
					<div class="widget-info body">
						<p>Take your <b>free, no obligation trial</b> of Lead Forensics and uncover the leads you didn't know you had.</p>
						<a href="<?= $button_link && !$show_demo_form && !$show_custom_form ? $button_link : "/pricing" ?>" <?= $show_demo_form && !$show_custom_form ? "id='demo-btn'" : "" ?> class="lf-btn red"><?= $button_text ? $button_text : "Try Lead Forensics" ?><span class='et-pb-icon'>&#x35;</span></a>
						<?php if(!$show_demo_form && $show_custom_form) : ?>
							<div id="pop-up-form">
								<div>
									
									<?= do_shortcode($show_custom_form_shortcode); ?>
									
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>

			<?php elseif( get_row_layout() == 'tools' ): ?>

				<div class="lf-tools-widget widget">
					<h4>Tools</h4>
					<p>Tool 1</p>
					<p>Tool 2</p>
					<p>Tool 3</p>
					<p>Tool 4</p>
					<p>Tool 5</p>
					<p>Tool 6</p>
				</div>

			<?php elseif( get_row_layout() == 'related_posts' ): ?>

				<div class="related-posts-widget widget">
					
					<?= do_shortcode('[relatedPostsWidget]') ?>
					
				</div>

			<?php endif; ?>

		<?php endwhile; ?>
	   
	<?php endif;
    return ob_get_clean();
};