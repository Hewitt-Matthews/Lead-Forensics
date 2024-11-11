<?php

$show_video = get_field('show_video');

?>

<?php if(!$show_video) : 

	$image = get_field('featured_image')['sizes']['large'];

?>

	<style>

		.case-study-img {
			box-shadow: var(--lfShadow);
			border-radius: 5px;
		}

	</style>

	<img src="<?= $image ?>" alt="Image for the <?= get_the_title() ?> case study" class="case-study-img">

<?php else : 
		 
wp_enqueue_style( 'wistia_video_styles', get_stylesheet_directory_uri() . '/css/wistia-videos.css');
wp_enqueue_script( 'wistia_video_script', get_stylesheet_directory_uri() . '/js/wistia-videos.js');

?>

	<?= do_shortcode('[featuredVideo]') ?>

<?php endif; ?>