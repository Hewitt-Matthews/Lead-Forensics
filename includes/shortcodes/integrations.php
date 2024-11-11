<?php 

//Build Shortcode to Loop Over integrations for integrations loops
add_shortcode( 'integrations', 'integrations_loop_func' );

function integrations_loop_func( $atts ) {
	
	ob_start();
	
	//Default to essentials if no plan selected
	$category = $atts['plan'] ? $atts['plan'] : 'essentials';
	
    $query = new WP_Query([
		'post_type' => 'integrations',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'integration_plans',
				'field'    => 'slug',
				'terms'    => $category,
			),
		),
	]);
	
    if ( $query->have_posts() ) : ?>
	
		<div class="integrations-container <?= $category ?> <?= $query->post_count >= 6 ? 'truncated' : '' ?>">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php 	$integration_logo = get_field('logo')['sizes']['medium'];
						$integration_name = get_the_title();
						$integration_short_desc = get_field('short_description');
			    		$integration_link = get_the_permalink();
						$via_zapier = get_field('via_zapier');
				?>

				<div class="integration">
			  		<img src="<?= $integration_logo ?>" alt="<?= $integration_name ?> logo">
					<div>
						<h3><?= $integration_name ?>
							<?php if ($via_zapier) : ?>
							<span>via Zapier</span>
							<?php endif; ?>
						</h3>
						<p><?= $integration_short_desc ?></p>
						<a href="<?= $integration_link ?>" class="lf-btn">Learn more<span class='et-pb-icon'>&#x35;</span></a>
					</div>
			  	</div>
			
			<?php endwhile;
			wp_reset_postdata(); ?>
			
			<?php if($query->post_count >= 6) : ?>
		
				<div class="see-more-container">
					<a href="#see-more" class="lf-btn">See more<span class='et-pb-icon'>&#x35;</span></a>
				</div>		
			
			<?php endif; ?>
			
		</div>

	<?php else : ?>
		<h3>There are currently no integrations to show. Please check back later.</h3>
    <?php 
	endif;
	$myvariable = ob_get_clean();
    return $myvariable;
};

//Build Shortcode to Loop Over integrations for related integrations loop on integrations pages
add_shortcode( 'relatedIntegrations', 'related_integrations_loop_func' );

function related_integrations_loop_func( ) {
	
	ob_start();
	
	$terms = get_the_terms(get_the_ID(), 'integration_plans');
	
    $query = new WP_Query([
		'post_type' => 'integrations',
		'posts_per_page' => 3,
		'post__not_in' => array( get_the_ID() ),
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'integration_plans',
				'field'    => 'slug',
				'terms'    => $terms[0]->slug,
			),
		),
	]);
	
    if ( $query->have_posts() ) : ?>
	
		<div class="related-integrations-container <?= $terms[0]->slug ?>">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php 	$integration_logo = get_field('logo')['sizes']['medium'];
						$integration_name = get_the_title();
						$integration_short_desc = get_field('short_description');
			    		$integration_link = get_the_permalink();
						$via_zapier = get_field('via_zapier');
				?>

				<div class="integration">
			  		<img src="<?= $integration_logo ?>" alt="<?= $integration_name ?> logo">
					<div>
						<h3><?= $integration_name ?>
							<?php if ($via_zapier) : ?>
							<span>via Zapier</span>
							<?php endif; ?>
						</h3>
						<p><?= $integration_short_desc ?></p>
						<a href="<?= $integration_link ?>" class="lf-btn">Learn more<span class='et-pb-icon'>&#x35;</span></a>
					</div>
			  	</div>
			
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>

	<?php else : ?>
		<h3>There are currently no integrations to show. Please check back later.</h3>
    <?php 
	endif;
	$myvariable = ob_get_clean();
    return $myvariable;
};


//Build Shortcode to check if integration is delivered via Zapier
add_shortcode( 'viaZapier', 'via_zapier_func' );

function via_zapier_func( $atts ) {
	
	ob_start();
	
	$via_zapier = get_field('via_zapier');
	
	if ($via_zapier) : ?>
		
		<script>
	
			const integrationTitle = document.querySelector('.integration-title h1');
			
			const span = document.createElement("span");
			const node = document.createTextNode("via Zapier");
			
			span.appendChild(node);
			integrationTitle.appendChild(span);

		</script>
		
	<?php endif;
	
	return ob_get_clean();
	
}


//Build Shortcode to create instuructions list on integrations pages
add_shortcode( 'instructionsList', 'instructions_list_func' );

function instructions_list_func( $atts ) {
    
	ob_start();
	
	$instructions = get_field('instructions');
	
    if ( $instructions ) { 
		?>	

		<ul class="instructions-container">

			<?php foreach($instructions as $instruction) : ?>
	
				<?php 
					$list_item = $instruction['list_item'];
					$extra_info = $instruction['extra_info'];
					$extra_info_text = $instruction['text'];
				?>
				
				<li><?= $list_item ?></li>
				<?php if($extra_info && $extra_info_text) : ?>
					<p><b><?= $extra_info_text ?></b></p>
				<?php endif; ?>

			<?php endforeach; ?>
				
			
		</ul>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};

//Build Shortcode to create "What you'll need" box on integrations pages
add_shortcode( 'whatYoullNeed', 'what_youll_need_func' );

function what_youll_need_func( $atts ) {
    
	ob_start();
	
	$what_youll_need = get_field('what_youll_need');
	$logo = get_field('logo')['sizes']['medium'];
	
    if ( $what_youll_need ) { 
		?>	

		<div class="what-youll-need">
			
			<img src="<?= $logo ?>" alt="<?= get_the_title(); ?> logo">
			
			<h3>What you'll need</h3>

			<ul>

				<?php foreach($what_youll_need as $list_item) : ?>

					<li><?= $list_item['list_item'] ?></li>

				<?php endforeach; ?>

			</ul>
			
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};