<?php

$terms = get_terms( array(
    'taxonomy' => 'case_study_categories',
    'hide_empty' => true,
) );
	
if ( $terms ) : ?>	

    <style>
		
		.case-studies-categories-container {
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 1em;
			flex-wrap: wrap;
			max-width: 700px;
			margin: 0 auto 2em;
		}
		
		.case-studies-categories-container h2 {
			flex: 100%;
			text-align: center;
			font-size: min(24px, 8vw)!important;
    		padding: 0;
		}

        .case-studies-categories-container .category-button {
           	padding: 0.5rem 1rem;
			border-radius: 5px;
			box-shadow: 0 0 10px -7px #000;
			line-height: 1;
			background: #fff;
			font-weight: 500;
			transition: 250ms;
        }

        .case-studies-categories-container .category-button:hover,
		.case-studies-categories-container .category-button.checked {
            background: var(--lfGradient);
            color: #fff;
            cursor: pointer;
        }
		
		.case-studies-grid-container .case-study.hidden {
			display: none;
		}


    </style>

    <div class="case-studies-categories-container">
		
		<h2>Filter by:</h2>
        
        <div class="category-button" data-slug="all">
            All
        </div>
        
        <?php foreach ( $terms as $term ) : ?>

            <div class="category-button" data-slug="<?= $term->slug ?>">
                <?= $term->name ?>
            </div>
    
        <?php endforeach;?>
    
    </div>

<?php endif; ?>