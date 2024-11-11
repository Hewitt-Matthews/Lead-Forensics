<style>

	.calculator-container form {
    	max-width: 800px;
		margin: 0 auto;
		color: #fff;
		text-align: center;
	}
	
	.calculator-container .gform_wrapper.gravity-theme .gfield input.large {
		border: none;
		border-radius: 50px;
		padding: 1em 2em;
	}
	
	.calculator-container .gfield_radio {
  	 	max-width: 200px;
		margin: 0 auto;
		text-align: left;
	}
	
	.calculator-container .gform_footer input[type="submit"] {
		font-size: 16px!important;
		padding: 0.75rem 2rem!important;
		color: #fff;
		border-radius: 50px;
		font-weight: 700;
		font-family: 'effra', sans-serif;
		border: solid 1px #fff!important;
		background-color: RGBA(255,255,255,0);
		margin: 0 auto!important;
	}
	
	.calculator-container .gform_footer input[type="submit"]:hover {
		text-decoration: underline;
		cursor: pointer;
	}
	
	.calculator-container .validation_message {
		display: block!important;
	}

</style>

<?php gravity_form( 19, false, false, false, '', false ); ?>