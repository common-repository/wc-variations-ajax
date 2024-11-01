<?php
/*
Plugin Name: WC Variations Ajax Fix
Plugin URI: http://northwestmediacollective.com
Description: modify Ajax to allow more variations fix for v2.4 or above
Version: 1.4
Author: Travis Buck
Author URI: http://northwestmediacollective.com
License: GPLv3
*/

/*
Default variations is 10, and this broke the dropdown on some of our stores. claudiosmweb on gethub pointed out the function to add.  This plug lets you set the number in the admin panel
*/

add_action( 'admin_menu', 'nwmc_var_ajax_add_admin_menu' );
add_action( 'admin_init', 'nwmc_var_ajax_settings_init' );


function nwmc_var_ajax_add_admin_menu(  ) { 

	add_options_page( 'WC Ajax Variations', 'WC Ajax Variations', 'manage_options', 'nwmc_var_ajax', 'nwmc_var_ajax_options_page' );

}


function nwmc_var_ajax_settings_init(  ) { 

	register_setting( 'pluginPage', 'nwmc_var_ajax_settings' );

	add_settings_section(
		'nwmc_var_ajax_pluginPage_section', 
		__( 'Enter Variations Limit' ), 
		'nwmc_var_ajax_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'nwmc_var_ajax_text_field_0', 
		__( 'Variable Limit', 'wordpress' ), 
		'nwmc_var_ajax_text_field_0_render', 
		'pluginPage', 
		'nwmc_var_ajax_pluginPage_section' 
	);


}


function nwmc_var_ajax_text_field_0_render(  ) { 

	$options = get_option( 'nwmc_var_ajax_settings' );
	?>
	<input type='text' name='nwmc_var_ajax_settings[nwmc_var_ajax_text_field_0]' value='<?php echo $options['nwmc_var_ajax_text_field_0']; ?>'>
	<?php

}


function nwmc_var_ajax_settings_section_callback(  ) { 

	echo __( 'Default number is 10 increase the variation limit example 40', 'wordpress' );

}


function nwmc_var_ajax_options_page(  ) { 

	?>
	<form action='options.php' method='post'>
		
		<h2>WC Variations Settings</h2>
		
		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>
		
	</form>
    
	<?php

}
// modified threshold

function custom_wc_ajax_variation_threshold( $qty, $product ) {
	$option = get_option('nwmc_var_ajax_settings');
	return $option['nwmc_var_ajax_text_field_0']; //changed in admin
}


add_filter( 'woocommerce_ajax_variation_threshold', 'custom_wc_ajax_variation_threshold', 10, 2 );

?>