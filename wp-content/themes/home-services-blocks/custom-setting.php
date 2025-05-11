<?php 

function home_services_blocks_add_admin_menu() {
    add_menu_page(
        'Theme Settings', // Page title
        'Theme Settings', // Menu title
        'manage_options', // Capability
        'home-services-blocks-theme-settings', // Menu slug
        'home_services_blocks_settings_page' // Function to display the page
    );
}
add_action( 'admin_menu', 'home_services_blocks_add_admin_menu' );

function home_services_blocks_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Theme Settings', 'home-services-blocks' ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'home_services_blocks_settings_group' );
            do_settings_sections( 'home-services-blocks-theme-settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function home_services_blocks_register_settings() {
    register_setting( 'home_services_blocks_settings_group', 'home_services_blocks_enable_animations' );

    add_settings_section(
        'home_services_blocks_settings_section',
        __( 'Animation Settings', 'home-services-blocks' ),
        null,
        'home-services-blocks-theme-settings'
    );

    add_settings_field(
        'home_services_blocks_enable_animations',
        __( 'Enable Animations', 'home-services-blocks' ),
        'home_services_blocks_enable_animations_callback',
        'home-services-blocks-theme-settings',
        'home_services_blocks_settings_section'
    );
}
add_action( 'admin_init', 'home_services_blocks_register_settings' );

function home_services_blocks_enable_animations_callback() {
    $checked = get_option( 'home_services_blocks_enable_animations', true );
    ?>
    <input type="checkbox" name="home_services_blocks_enable_animations" value="1" <?php checked( 1, $checked ); ?> />
    <?php
}

