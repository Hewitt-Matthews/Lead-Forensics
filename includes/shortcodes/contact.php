<?php 

//Build Shortcode to Loop Over teams for contact page
add_shortcode( 'contactTeams', 'contact_page_teams_func' );

function contact_page_teams_func( $atts ) {
    
	ob_start();
    $teams = get_field('teams');
	
    if ( $teams ) { 
		?>	

		<div class="teams-container">
			
			<?php foreach ( $teams as $team ) : ?>
			
				<?php $team_title = $team['team_name'];
						$team_desc = $team['team_description'];
						$team_button_text = $team['button']['button_text'];
						$team_link = $team['button']['button_link'];
						$contact_form_id = $team['contact_form']
				?>
			   	
				
				<div class="team">
					<div class="head">
						<h3><?= $team_title ?></h3>
					</div>
			  		<div class="meta">
						<p><?= $team_desc ?></p>
						<a href="<?= $team_link ?>" class="lf-btn"><?= $team_button_text ?><span class='et-pb-icon'>&#x35;</span></a>
						<div id="pop-up-form">
							<div>
								<?= do_shortcode('[gravityforms id="' . $contact_form_id . '"  ajax="true"]') ?>
							</div>
						</div>
					</div>
			  	</div>
			
			<?php endforeach; wp_reset_postdata(); ?>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};

//Build Shortcode to Loop Over offices for contact page
add_shortcode( 'contactOffices', 'contact_page_offices_func' );

function contact_page_offices_func( $atts ) {
    
	ob_start();
    $offices = get_field('offices');
	
    if ( $offices ) { 
		?>	

		<div class="offices-container">
			
			<?php foreach ( $offices as $office ) : ?>
			
				<?php 	
						$office_image = $office['image']['sizes']['large'];
						$office_name = $office['office_name'];
						$office_address = $office['address'];
						$office_phone = $office['phone'];
						$map_link = $office['map_link'];
				?>
			   	
				
				<div class="office">
					<div class="head" style="background: url(<?= $office_image ?>)"></div>
			  		<div class="meta">
						<h3><?= $office_name ?></h3>
						<p><?= $office_address ?></p>
						<a href="tel: <?= $office_phone ?>" class="phone"><?= $office_phone ?></a>
						<a href="<?= $map_link ?>" class="lf-btn" target="_blank">View on map<span class='et-pb-icon'>&#x35;</span></a>
					</div>
			  	</div>
			
			<?php endforeach; wp_reset_postdata(); ?>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
};