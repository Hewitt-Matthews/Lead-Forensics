<?php

//Build Shortcode to create pricing pable on pricing page
add_shortcode( 'plansGrid', 'plans_grid_func' );
function plans_grid_func( $atts ) {
    
	ob_start(); 
	
	if($plans = get_field('plans', 'option') ) : ?>	

		<div class="plans-container">
			
		<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/embed/v2.js"></script>
			
			<?php $count = 1; foreach($plans as $plan) : ?>
			
				<div class="plan">

					<div class="head">
						
						<h2>Plan <?= $count ?> : <?= $plan['plan_name'] ?></h2>
						<p><?= $plan['plan_description'] ?></p>

					</div>
					
					<div class="info">
					
						<div class="benefits">

							<p><?= $plan['plan_benefit_title'] ?></p>

							<ul class="benefits-list">

								<?php foreach($plan['plan_benefits'] as $benefit) : ?>

									<li><?= $benefit['benefit'] ?></li>

								<?php endforeach; ?>

							</ul>

						</div>
	
						<div class="buttons">
							
							<a href="<?= $plan['plan_demo_link'] ?>" class="lf-btn">Speak to an expert<span class='et-pb-icon'>&#x35;</span></a>
							<div id="pop-up-form" class="expert-popup">
								<div>
									<?php if ( $plan['plan_name'] == "Essential" ) {
		
											echo '<script>hbspt.forms.create({ region: "na1", portalId: "23462658", formId: "bf268138-8154-4ab2-949a-2fbbc60c4a3d" });</script>';
								
										} elseif( $plan['plan_name'] == "Automate" ) {
											
											echo '<script>hbspt.forms.create({ region: "na1", portalId: "23462658", formId: "bf268138-8154-4ab2-949a-2fbbc60c4a3d" });</script>';
									
										}
									?>
								</div>
							</div>
							
							<a href="<?= $plan['plan_demo_link'] ?>" class="lf-btn red">Take my free trial<span class='et-pb-icon'>&#x35;</span></a>
							<div id="pop-up-form" class="iframe-popup">
								<div>
									
									<?php if ( $plan['plan_name'] == "Essential" ) {
		
											echo '<div class="meetings-iframe-container" data-src=https://meetings.hubspot.com/concierge-team/2?embed=true></div><script type="text/javascript" src=https://static.hsappstatic.net/MeetingsEmbed/ex/MeetingsEmbedCode.js></script>';
								
										} elseif( $plan['plan_name'] == "Automate" ) {
											
											echo '<div class="meetings-iframe-container" data-src=https://meetings.hubspot.com/concierge-team/2?embed=true></div><script type="text/javascript" src=https://static.hsappstatic.net/MeetingsEmbed/ex/MeetingsEmbedCode.js></script>';
									
										}
									?>
									
								</div>
							</div>
						
						</div>
					
					</div>

				</div>
			
			<?php $count++; endforeach; ?>
			
		</div>

    <?php 
	endif;
	$myvariable = ob_get_clean();
    return $myvariable;
};

//Build Shortcode to create pricing pable on pricing page
add_shortcode( 'pricingTable', 'pricing_table_func' );
function pricing_table_func( $atts ) {
    
	ob_start(); 

	$plans = get_field('plans', 'option');
	$rows_to_show = get_field('rows_to_show');
	
	if($pricing_table_row = get_field('table_rows') ) : ?>	

		<table class="comparison-table">
			
			<tr>
				<th class="empty-cell"></th>
				
				<?php if ($plans) : ?>
				
					<?php foreach($plans as $plan) : ?>
						<th><?= $plan['plan_name'] ?></th>
					<?php endforeach; ?>
				
				<?php endif; ?>
			</tr>
			
			<?php $count = 1; foreach($pricing_table_row as $row) : ?>
			
				<tr class="table-row <?= $count > $rows_to_show ? "hidden" : "" ; ?>">

					<td>
						<div class="benefit-desc <?= $row['benefit_short_description'] ? "underline" : "" ?>">
							<?= $row['benefit_name'] ?>
							<?php if($row['benefit_short_description']) : ?>
								<p class="benefit-desc-hover"><?= $row['benefit_short_description'] ?></p>
							<?php endif; ?>
						</div>
					</td>
					
					<?php if(!$row['show_text_instead_of_checkmark']) : ?>
					<!-- Check Marks -->
						<?php foreach($plans as $plan) : ?>

							<?php if( in_array(strtolower($plan['plan_name']), $row['available_on']) ) : ?>

								<td><div class="available-tick"></div></td>

							<?php else : ?>
					
								<td><div class="not-available-line"></div></td>

							<?php endif; ?>

						<?php endforeach; ?>
					
					<?php endif; ?>
					
					<?php if($row['show_text_instead_of_checkmark']) : ?>
					<!-- Text -->
						<?php foreach($plans as $plan) : ?>

							<!-- <pre><?php print_r($row) ?></pre> -->
							<td><?= $row['checkmark_text'] ?></td>

						<?php endforeach; ?>
					
					<?php endif; ?>
					
				</tr>
			
			<?php $count++; endforeach; ?>
			
			<tr class="comparison-table-footer table-expand">
				<td colspan=3>
					<a href="#" class="lf-btn see-more">See more<span class='et-pb-icon'>&#x35;</span></a>
				</td>
			</tr>
			
		</table>

    <?php 
	endif;
	$myvariable = ob_get_clean();
    return $myvariable;
};