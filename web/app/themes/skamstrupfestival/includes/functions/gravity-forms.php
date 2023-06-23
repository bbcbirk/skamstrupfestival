<?php
// filter the Gravity Forms button type
// From: https://docs.gravityforms.com/gform_submit_button/#1-change-input-to-button-
add_filter( 'gform_submit_button', 'form_submit_button', 10, 2 );

function form_submit_button( $button, $form ) {
	// fetch all attributes from input element except value attribute
	preg_match( '/<input([^\/>]*)\s\/*>/', $button, $button_match );
	$button_atts = str_replace(
		[
			"value='" . $form['button']['text'] . "' ",
			"class='",
		],
		[
			'',
			"class='skamstrupfestival-button ",
		],
		$button_match[1] ?? ''
	);
	return '<button' . $button_atts . '>' .
		'<span>' . ( $form['button']['text'] ?: __( 'Submit' ) ) . '</span>' .
		'</button>';
}
