<?php

$post_id = get_the_ID();
$post_author = get_the_terms( $post_id, 'post_authors' );

$post_author_name = $post_author[0]->name;
$post_author_first_name = explode(" ", $post_author_name)[0];
$post_author_desc = $post_author[0]->description;
$post_author_role = get_field('role', 'post_authors' . '_' . $post_author[0]->term_id);
$post_author_image = get_field('image', 'post_authors' . '_' . $post_author[0]->term_id);
$post_author_linkedin = get_field('linkedin', 'post_authors' . '_' . $post_author[0]->term_id);
$post_author_linkedin_icon = '<a href="' . $post_author_linkedin . '" target="_blank"><span class="et-pb-icon">&#xe09d;</span></a>';
?>

<style>

	.post_author {
		display: grid;
		align-items: center;
		--imageSize: 200px;
		grid-template-columns: var(--imageSize) 1fr;
		gap: 1em;
		margin-top: 3em;
	}
	
	.post_author .author-image {
		position: relative;
		border-radius: 50%;
		width: var(--imageSize);
		height: var(--imageSize);
		padding: 2px;
    	background: var(--lfGradient);
	}
	
	.post_author .author-image img {
		border-radius: 50%;
	}
	
	.post_author .author-info p:last-of-type {
		font-weight: 600;
		font-size: 20px;
	}
	
	.post_author .author-info p:last-of-type span {
		background: #0072b1;
		padding: 4px;
		color: #fff;
		border-radius: 5px;
		font-size: 17px;
	}
	
	.speech-bubble {
		--bubbleBorder: 15px;
		position: absolute;
		left: 0;
		top: 0;
		transform: translateX(-60%);
		background: var(--lfGradient);
		border-radius: var(--bubbleBorder);
		padding: 2px;
	}
	
	.speech-bubble p {
		position: relative;
		font-size: 22px;
		background: #fff;
		border-radius: calc(var(--bubbleBorder) - 3px);
		font-weight: bold;
		padding: 0.8rem 1rem!important;
		line-height: 1;
		--speechPointWidth: 30px;
		--speechPointHeight: 20px;
	}
	
	.speech-bubble p::after,
	.speech-bubble p::before {
		content: "";
		position: absolute;
		top: 100%;
		right: 13%;
		width: var(--speechPointWidth);
		height: var(--speechPointHeight);
		clip-path: polygon(65% 0, 65% 12%, 100% 12%, 100% 100%, 0 0);
	}
	
		
	.speech-bubble p::before {
		background: linear-gradient(90deg, #c00d3f 0%,var(--lfRed) 100%);
	}
	
		
	.speech-bubble p::after {
		background: #fff;
		transform: scale(0.8) translateX(1px);
   		transform-origin: top;
	}

	@media only screen and (max-width: 980px) {
		
		.post_author {
			grid-template-columns: 1fr;
		}
		
		.post_author .author-image {
			transform: translateX(min(50%, 20vw));
		}
		
	}
	
</style>

<div class="post_author">

	<div class="author-image">

		<div class="speech-bubble">
			<p>I wrote this!</p>
		</div>

		<img src="<?= $post_author_image['sizes']['medium'] ?>" alt="Author image of <?= $post_author_name ?>">
	</div>
	
	<div class="author-info">

		<h3>Meet <?= $post_author_first_name ?>!</h3>
		<p><?= $post_author_desc ?></p>
		<p><?= $post_author_name ?> <?= $post_author_linkedin ? $post_author_linkedin_icon : "" ?> - <?= $post_author_role ?></p>
		
	</div>
		
</div>