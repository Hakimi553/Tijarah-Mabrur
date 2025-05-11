<?php
/**
 * Home Services Blocks: Customizer
 *
 * @subpackage Home Services Blocks
 * @since 1.0
 */

function home_services_blocks_customize_register( $wp_customize ) {

    wp_enqueue_style('customizercustom_css', esc_url( get_template_directory_uri() ). '/inc/customizer/customizer.css');

    // Pro Section
    $wp_customize->add_section('home_services_blocks_pro', array(
        'title'    => __('HOME SERVICES PREMIUM', 'home-services-blocks'),
        'priority' => 1,
    ));
    $wp_customize->add_setting('home_services_blocks_pro', array(
        'default'           => null,
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new Home_Services_Blocks_Pro_Control($wp_customize, 'home_services_blocks_pro', array(
        'label'    => __('HOME SERVICES PREMIUM', 'home-services-blocks'),
        'section'  => 'home_services_blocks_pro',
        'settings' => 'home_services_blocks_pro',
        'priority' => 1,
    )));
}
add_action( 'customize_register', 'home_services_blocks_customize_register' );


define('HOME_SERVICES_BLOCKS_PRO_LINK',__('https://www.ovationthemes.com/products/home-maintenance-wordpress-theme','home-services-blocks'));

define('HOME_SERVICES_BLOCKS_BUNDLE_BTN',__('https://www.ovationthemes.com/products/wordpress-bundle','home-services-blocks'));

/* Pro control */
if (class_exists('WP_Customize_Control') && !class_exists('Home_Services_Blocks_Pro_Control')):
    class Home_Services_Blocks_Pro_Control extends WP_Customize_Control{

    public function render_content(){?>
        <label style="overflow: hidden; zoom: 1;">
            <div class="col-md upsell-btn">
                <a href="<?php echo esc_url( HOME_SERVICES_BLOCKS_PRO_LINK ); ?>" target="blank" class="btn btn-success btn"><?php esc_html_e('UPGRADE HOME SERVICES PREMIUM','home-services-blocks');?> </a>
            </div>
            <div class="col-md">
                <img class="home_services_blocks_img_responsive " src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png">
            </div>
            <div class="col-md">
                <ul style="padding-top:10px">
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Responsive Design', 'home-services-blocks');?> </li>                 
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Demo Importer', 'home-services-blocks');?> </li>
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Section Reordering', 'home-services-blocks');?> </li>
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Contact Page Template', 'home-services-blocks');?> </li>
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Multiple Blog Layouts', 'home-services-blocks');?> </li>
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Unlimited Color Options', 'home-services-blocks');?> </li>
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Cross Browser Support', 'home-services-blocks');?> </li>
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Detailed Documentation Included', 'home-services-blocks');?> </li>
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('WPML Compatible (Translation Ready)', 'home-services-blocks');?> </li>
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Woo-commerce Compatible', 'home-services-blocks');?> </li>
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Full Support', 'home-services-blocks');?> </li>
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('10+ Sections', 'home-services-blocks');?> </li>
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('SEO Friendly', 'home-services-blocks');?> </li>
                    <li class="upsell-home_services_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Supper Fast', 'home-services-blocks');?> </li>
                </ul>
            </div>
            <div class="col-md upsell-btn upsell-btn-bottom">
                <a href="<?php echo esc_url( HOME_SERVICES_BLOCKS_BUNDLE_BTN ); ?>" target="blank" class="btn btn-success btn"><?php esc_html_e('WP Theme Bundle (120+ Themes)','home-services-blocks');?> </a>
            </div>
        </label>
    <?php } }
endif;