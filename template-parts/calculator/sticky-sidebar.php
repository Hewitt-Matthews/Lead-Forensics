<?php
// Show sidebar by default, hide only when checkbox is checked
if (!get_field('hide_sticky_sidebar')) : ?>

<style>

    .sticky-sidebar {
		position: fixed;
		width: 200px;
		top: 58%;
		right: 0;
		transform-origin: top;
		transform: rotateZ(270deg) translateY(31px);
    	transition: 300ms;
		display: block;
    }
	
	.sticky-sidebar.active {
		transform: rotateZ(270deg) translateY(-250px);
	}
	
	.sticky-sidebar .title-container:hover {
		cursor: pointer;
	}
	
	.sticky-sidebar .arrow {
		--arrowSize: 17px;
		display: inline-block;
		height: var(--arrowSize);
		width: var(--arrowSize);
		clip-path: polygon(50% 0, 100% 50%, 50% 100%, 35% 85%, 71% 50%, 35% 15%);
		background-color: red;
		position: absolute;
		top: 33px;
		right: 10px;
		transform: rotate(90deg);
	}

    .sticky-sidebar .title-container,
	.sticky-sidebar .content-container {
		background: linear-gradient(90deg,#5b00ce 0%,#fe0000 100%);
		padding: 2px 2px 0px 2px;
		transform: translateY(2px);
		z-index: 10;
		position: relative;
    }
	
	.sticky-sidebar .title-container {
		border-radius: 2rem 2rem 0 0;
	}

	.sticky-sidebar .content-container {
		border-radius: 2rem 0 0 0;
		width: 250px;
		height: 285px;
		transform: translateX(-50px);
		z-index: 2;
	}
	
	.sticky-sidebar .title-container .title {
		padding: 1em 1.5em 0.5em 0.75em;
		background-color: #fff;
		border-radius: 1.9rem 1.9rem 0 0;
	}
	
	.sticky-sidebar .content-container .content {
		background-color: #fff;
		padding: 1em;		
	}
	
    .sticky-sidebar .title-container .title p {
        font-size: 20px;
        background: -webkit-linear-gradient(0deg,#5b00ce 0%,#fe0000 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
		text-align: center;
		font-weight: 700;
		line-height: 1;
    }
	
	.sticky-sidebar .content-container .content {
		transform: rotateZ(90deg) translate(140px, -106px);
		transform-origin: top;
		border-radius: 0 0 0 1.9rem;
		width: 280px;
		height: calc(100% - 38px);
	}
	
	.sticky-sidebar .content-container .content .gform_required_legend {
		display: none;
	}
	
	.sticky-sidebar .content-container .content .gform_footer.top_label {
		justify-content: center;
	}
	
	.sticky-sidebar .content-container .content .gform_footer.top_label input[type=submit] {
		border-radius: 50px;
		border: none;
		background: linear-gradient(90deg,#5b00ce 0%,#fe0000 100%);
		color: #fff;
		font-size: 20px;
		font-weight: 800;
		padding: 0.25rem 1rem;
	}
	
	.sticky-sidebar .content-container .content .gform_footer.top_label input[type=submit]:hover {
		cursor: pointer;
		text-decoration: underline;
	}
	
	.sticky-sidebar .content-container .content .gform_validation_errors {
		display: none;
	}
	
	.sticky-sidebar .gform_confirmation_message {
		padding: 0;
		font-size: 15px;
		line-height: 1.4;
	}

</style>

<div class="sticky-sidebar">

    <div class="title-container">

        <div class="title"><p>Show me my B2B website visitors</p><span class="arrow"></span></div>
		
	 </div>
	
	 <div class="content-container">

        <div class="content">

            <?= do_shortcode('[gravityform id="21" title="false" description="false" ajax="true"]') ?>

        </div>

    </div>

</div>

<script>


	window.addEventListener('load', () => {
		
		const sidebar = document.querySelector('.sticky-sidebar .title-container');
		
		const toggleSidebar = (e) => {
			
			sidebar.parentElement.classList.toggle('active');
			
		}
		
		sidebar.addEventListener('click', toggleSidebar);
		
	})

</script>

<?php else: ?>
<style>
    .sticky-sidebar {
        display: none !important;
    }
</style>
<?php endif; ?>