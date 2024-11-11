<?php

$category_name = is_home() ? 'blog' : 'news';

$query = new WP_Query([
	'post_type' => 'post',
	'posts_per_page' => 9,
	'category_name' => $category_name,
]);

if ( $query->have_posts() ) : ?>	

	<div class="posts-container" data-category="<?= $category_name ?>">
		<template class="posts-template">
			<div class="post-info">
				<img class="post-img">
				<div class="post-meta">
					<p class="category"></p>
					<h3 class="post-title"></h3>
					<p class="post-excerpt"></p>
					<a class="post-link lf-btn">Read more<span class='et-pb-icon'>&#x35;</span></a>
				</div>
			</div>
		</template>
		<?php $count = 1; while ( $query->have_posts() ) : $query->the_post(); ?>
		
			<?php if($count == 6) {
	 			get_template_part('template-parts/blog/blog', 'cta');
			} ?>
		
			<?php 	$featuredImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
					$featuredImgAltText = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
					$post_title = get_the_title();
					$post_excerpt = get_the_excerpt();
					$post_link = get_the_permalink();
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
			<div class="post-info">
				<img src="<?= $featuredImg[0] ?>" alt="<?= $featuredImgAltText ?>">
				<div class="post-meta">
					<p class="category <?= $post_category_slug ?>"><?= $post_category ?></p>
					<h3><?= $post_title ?></h3>
					<p><?= strip_tags(limit_text($post_excerpt, 30)) ?>...</p>
					<a href="<?= $post_link ?>" class="lf-btn">Read more<span class='et-pb-icon'>&#x35;</span></a>
				</div>
			</div>
		<?php $count++; endwhile;
		wp_reset_postdata(); ?>
	</div>

<?php endif; ?>