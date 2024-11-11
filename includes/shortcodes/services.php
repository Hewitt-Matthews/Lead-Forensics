<?php 

//Build Shortcode to Loop Over services for services loop on homepage
add_shortcode( 'servicesLoop', 'services_loop_func' );

function services_loop_func( $atts ) {
    
	ob_start();
    $query = new WP_Query( array(
        'post_type' => 'services',
        'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
    ) );
	
    if ( $query->have_posts() ) { 
		?>	

		<div class="services-container">
			
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			
				<?php $service_title = get_the_title();
						$service_icon = get_field('service_icon');
						$service_short_desc = get_field('service_description_short');
						$service_link = get_the_permalink();
				?>
			   	
				
				<div class="service">
					<div class="head">
						<h3><?= $service_title ?></h3>
						<img src="<?= $service_icon ?>" alt="Icon for <?= $service_title ?>" loading="lazy">
					</div>
			  		<div class="meta">
						<p><?= $service_short_desc ?></p>
						<a href="<?= $service_link ?>" class="lf-btn">Read More<span class='et-pb-icon'>&#x35;</span></a>
					</div>
			  	</div>
			
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};


//Build Shortcode to Loop Over services for services loop on homepage
add_shortcode( 'servicesBenefits', 'services_benefits_func' );

function services_benefits_func( $atts ) {
	
	ob_start(); 

	if (have_rows('benefits')) : ?>

		<div class="benefits-container">

			<?php while( have_rows('benefits') ): the_row(); ?>
			
				<?php
					$benefit_title = get_sub_field('benefit_title');
					$benefit_desc = get_sub_field('benefit_description');
					$benefit_gif = get_sub_field('benefit_gif')['sizes']['large'];
				?>
			
				<div class="benefit">

					<?php if( get_row_layout() == 'benefits_gif_with_image' ): ?>

						<?php $benefit_image = get_sub_field('benefit_image')['sizes']['large']; ?>

						<div class="image-with-gif" style="background: url(<?= $benefit_image ?>) ;">
							<img class="gif" src="<?= $benefit_gif?>" alt="<?= get_sub_field('benefit_gif')['alt'] ?>">
						</div>

					<?php elseif( get_row_layout() == 'benefits_gif_only' ): ?>

						<div class="gif-only">
							<img class="gif" src="<?= $benefit_gif?>" alt="<?= get_sub_field('benefit_gif')['alt'] ?>">
						</div>

					<?php endif; ?>
					
										
					<div class="content">
						
						<h2><?= $benefit_title ?></h2>
						<p><?= $benefit_desc ?></p>
						
						<?php if( get_sub_field('show_case_study_link') && $case_study_link = get_sub_field('related_case_study') ) : ?> 
							<a href="<?= $case_study_link ?>" class="lf-btn case-study-link">See case study<span class='et-pb-icon'>&#x35;</span></a>
						<?php endif; ?>
						
						<?php if($demo_link = get_sub_field('show_demo_link')) : ?> 
							<a id="demo-btn" href="#" class="lf-btn demo-link">Request a demo<span class='et-pb-icon'>&#x35;</span></a>
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