<?php

$categories = get_categories( array(
    'hide_empty' => false,
	'parent' => is_home() ? 14 : 15
) );
	
if ( $categories ) : ?>	

    <style>
	
		
		.blog-categories-container {
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 1em;
			flex-wrap: wrap;
			max-width: 700px;
			margin: 0 auto 2em;
		}
		
		.blog-categories-container h2 {
			color: #aaa;
			text-align: center;
			font-size: min(24px, 8vw)!important;
    		padding: 0;
		}

        .blog-categories-container .category-button {
            padding: 0.5rem 1rem;
			border-radius: 5px;
			box-shadow: 0 0 10px -7px #000;
			line-height: 1;
			background: #fff;
			font-weight: 500;
			transition: 250ms;
        }

        .blog-categories-container .category-button:hover,
		.blog-categories-container .category-button.checked {
            background: var(--lfGradient);
            color: #fff;
            cursor: pointer;
        }
		
		.blog-grid-container .case-study.hidden {
			display: none;
		}


    </style>

    <div class="blog-categories-container">
		
		<h2>Filter by:</h2>
        
        <div class="category-button" data-slug="all">
            All
        </div>
        
        <?php foreach ( $categories as $category ) : ?>

            <div class="category-button" data-slug="<?= $category->slug ?>">
                <?= $category->name ?>
            </div>
    
        <?php endforeach;?>
    
    </div>

<?php endif; ?>