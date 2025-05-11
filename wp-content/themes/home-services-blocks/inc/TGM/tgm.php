<?php
	
load_template( get_template_directory() . '/inc/TGM/class-tgm-plugin-activation.php' );

/**
 * Recommended plugins.
 */
function home_services_blocks_register_recommended_plugins() {
	$plugins = array(
		array(
			'name'             => __( 'Ovation Elements', 'home-services-blocks' ),
			'slug'             => 'ovation-elements',
			'required'         => false,
			'force_activation' => false,
		)
	);
	$config = array();
	home_services_blocks_tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'home_services_blocks_register_recommended_plugins' );