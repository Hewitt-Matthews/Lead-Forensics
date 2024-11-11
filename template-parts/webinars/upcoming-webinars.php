<style>

	.upcoming-webinars-container {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr));
		gap: 2em;
	}
	
	.upcoming-webinars-container .webinar {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(min(300px, 100%), 1fr));
		gap: 2em;
	}

	.upcoming-webinars-container .webinar .info {
		display: flex;
		flex-direction: column;
		gap: 1em;
		align-items: flex-start;
		justify-content: space-between;
		flex: 1;
		margin-top: 1em;
	}
	
	.upcoming-webinars-container .webinar img {
		border-radius: 5px;
   		box-shadow: var(--lfShadow);
	}

</style>

<?php

$meta_query = array(
	array(
		'key' => 'webinar_date',
		'value' => date('Ymd'),
		'type' => 'DATE',
		'compare' => '>'
	)
);

$query = new WP_Query([
	'post_type' => 'webinars',
	'posts_per_page' => 2,
	'order' => 'ASC',
	'orderby' => 'meta_value',
	'meta_key' => 'webinar_date',
	'meta_query' => $meta_query
]);

if ( $query->have_posts() ) : ?>	

	<div class="upcoming-webinars-container">
		
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<?php 	$webinar_video_info = get_field('video');
					$featuredImg = $webinar_video_info['video_thumbnail']['sizes']['large'];
					$featuredImgAltText = $webinar_video_info['video_title'] . ' image';
					$post_title = $webinar_video_info['video_title'];
					$post_excerpt = $webinar_video_info['video_description'];
					$webinar_sign_up_link = get_field('webinar_sign_up_link');
					$post_link = get_the_permalink();
			?>

			<div class="webinar">

				<img class="webinar-image" src="<?= $featuredImg ?>" alt="<?= $featuredImgAltText ?>">

				<div class="info">

					<h2><?= $post_title ?></h2>
					<p><?= strip_tags(limit_text($post_excerpt, 20)) ?>...</p>
					
					<?php if($webinar_sign_up_link): ?>
						<a href="<?= $webinar_sign_up_link ?>" class="lf-btn red">Save your seat<span class='et-pb-icon'>&#x35;</span></a>
					<?php endif; ?>
					
				</div>
				
			</div>

		<?php endwhile;
		wp_reset_postdata(); ?>
	</div>

<?php endif;