<?php

/**
 * Plugin Name:	  Horizontal Slider With Scroll
 * Plugin URI:	  https://plugins.hirewebxperts.com/horizontal-slider-with-scroll/
 * Description:	  Horizontal slider with Mouse's scroll feature using which you can slide the images left to right or vice versa.
 * Version: 	  1.3
 * Author: 		  Coder426
 * Author URI:	  https://profiles.wordpress.org/coder426/
 * Text Domain:   horizontal-slider-with-scroll
 * Domain Path:	  /languages
 * License:       GPLv2 or later
 * License URI:   http://www.gnu.org/licenses/gpl-2.0.txt
 * License: 	  GPL2
 */

if (!defined('ABSPATH')) {
	exit;
}

/** 
 ** Plugin details
 ** Define plugin url path
 ** Version 1.3
 **/
define('HSS_VER', rand());
define('HSS_NAME', 'horizontal-slider-with-scroll');
define('HSS_JS', plugin_dir_url(__FILE__) . 'assets/js/');
define('HSS_CSS', plugin_dir_url(__FILE__) . 'assets/css/');
define('HSS_IMG', plugin_dir_url(__FILE__) . 'assets/images/');
define('HSS_LIBS', plugin_dir_url(__FILE__) . 'assets/libs/');
define('HSS_INC', dirname(__FILE__) . '/include/');


/** 
 ** Setting link to pluign
 ** Wordpress Function - add_filter()
 ** Wordpress Hook - plugin_action_links_Plugin_FILE_NAME
 **/
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'hss_add_plugin_page_settings_link');
function hss_add_plugin_page_settings_link($links)
{
	$links[] = '<a href="' . admin_url('admin.php?page=horizontal-slider-with-scroll') . '">' . __('Settings', HSS_NAME) . '</a>';
	return $links;
}

/** 
 ** Admin Dashboard Style And Script
 ** Wordpress Function - add_action()
 ** Wordpress Hook - admin_enqueue_scripts
 **/
add_action('admin_enqueue_scripts', 'hss_add_admin_scripts', 99);
function hss_add_admin_scripts($hook)
{
	if (isset($_GET['page']) && $_GET['page'] == 'horizontal-slider-with-scroll') {
		/** 
		 ** Admin Dashboard Style
		 **/
		wp_enqueue_style(HSS_NAME . '_bootstrap_min', HSS_CSS . 'bootstrap.min.css', array(), HSS_VER);
		wp_enqueue_style(HSS_NAME . '_jQuery-ui', HSS_CSS . 'jQuery-ui.css', array(), HSS_VER);
		wp_enqueue_style(HSS_NAME . '_fontawesome_min', HSS_CSS . 'all.css', array(), HSS_VER);
		wp_enqueue_style(HSS_NAME . '-owl-carousel-css', HSS_LIBS . '/owl-carousel/css/owl.carousel.min.css', array(), rand());
		wp_enqueue_style(HSS_NAME . '-owl-carousel-theme', HSS_LIBS . '/owl-carousel/css/owl.theme.default.min.css', array(), rand());
		wp_enqueue_style(HSS_NAME . '_admin', HSS_CSS . 'admin.css', array(), HSS_VER);

		/** 
		 ** Admin Dashboard Script
		 **/
		wp_enqueue_script('jquery');
		if (!did_action('wp_enqueue_media')) {
			wp_enqueue_media();
		}
		wp_enqueue_script(HSS_NAME . 'popper', HSS_JS . 'popper.js', array('jquery'), HSS_VER, true);
		wp_enqueue_script(HSS_NAME . '_bootstrap_min', HSS_JS . 'bootstrap.min.js', array('jquery'), HSS_VER, true);
		wp_enqueue_script(HSS_NAME . '_bootstrap_bundle_min', HSS_JS . 'bootstrap.bundle.min.js', array('jquery'), HSS_VER, true);
		wp_enqueue_script(HSS_NAME . '-owl-carousel-js', HSS_LIBS . '/owl-carousel/js/owl.carousel.min.js', array(), rand(), true);
		wp_enqueue_script(HSS_NAME . '_admin', HSS_JS . 'admin.js', array('jquery'), HSS_VER, true);

		wp_enqueue_script('jquery-ui-tabs');
	}
}

/** 
 ** Frontend Style And Script
 ** Wordpress Function - add_action()
 ** Wordpress Hook - wp_enqueue_scripts
 **/
add_action('wp_enqueue_scripts', 'hss_add_front_scripts', 99);
function hss_add_front_scripts($hook)
{
	/** 
	 ** Frontend Style
	 **/
	wp_enqueue_style(HSS_NAME . '_front', HSS_CSS . 'front.css', array(), HSS_VER);
	wp_enqueue_style(HSS_NAME . 'app', HSS_CSS . 'app.css', array(), HSS_VER);

	/** 
	 ** Frontend Script
	 **/
	wp_enqueue_script('jquery');
	if (!did_action('wp_enqueue_media')) {
		wp_enqueue_media();
	}
	wp_enqueue_script('jquery-ui');
	wp_enqueue_script(HSS_NAME . 'libs', HSS_JS . 'libs.js', array('jquery'), HSS_VER, true);
	wp_enqueue_script(HSS_NAME . 'underscore', site_url() . '/wp-includes/js/underscore.min.js', array('jquery'), HSS_VER, true);
	wp_enqueue_script(HSS_NAME . '_front', HSS_JS . 'front.js', array('jquery'), HSS_VER, true);


	$admin_url = strtok(admin_url('admin-ajax.php', (is_ssl() ? 'https' : 'http')), '?');
	wp_localize_script(HSS_NAME . '_front', 'hss_vars', array(
		'ajaxurl' => $admin_url,
		'pluginurl' => '',
		'ajax_public_nonce' => wp_create_nonce('ajax_public_nonce'),
	));
	wp_enqueue_script(HSS_NAME . '_app', HSS_JS . 'app.js', array('jquery'), HSS_VER, true);
}

/** 
 ** Admin Dashboard Horizontal Slider With Scroll Top Level Menu
 ** Wordpress Hook - admin_menu
 **/
add_action('admin_menu', 'hss_main_menu');
function hss_main_menu()
{
	add_menu_page(__('Horizontal Slider With Scroll Page', 'horizontal-slider-with-scroll'), __('HSS', 'horizontal-slider-with-scroll'), 'manage_options', 'horizontal-slider-with-scroll', '', 'dashicons-slides', 2);
	add_submenu_page('hss', __('Horizontal Slider With Scroll Settings', 'horizontal-slider-with-scroll'), __('Horizontal Slider With Scroll Settings', 'horizontal-slider-with-scroll'), 'manage_options', 'horizontal-slider-with-scroll', 'hss_main_menu_html');
	do_action('hss_add_item_extend');
}

/** 
 ** Admin Dashboard Plugin Setting Page HTML
 **/
function hss_main_menu_html()
{
	if (isset($_POST["hsscroll-nonce"]) && wp_verify_nonce($_POST["hsscroll-nonce"], basename(__FILE__))) {
		$s_save = false;
		if (isset($_GET) && !empty($_GET['page']) && $_GET['page'] == 'horizontal-slider-with-scroll') {
			$nonce = $_POST['hsscroll-nonce'];
			$final_settings = array();

			if (is_array($_POST['hss_setting'])) {

				foreach ($_POST['hss_setting'] as $key => $value) {
					$final_settings[sanitize_key($key)] = sanitize_text_field($value);
				}

				$final_settings['hss_dimension'] = array(
					"width" => sanitize_text_field($_POST['hss_dimension']['width']),
					"height" => sanitize_text_field($_POST['hss_dimension']['height']),
				);

				// sanitize url
				if (!empty($_POST['hss_gallery_image'])) {
					$final_settings['hss_gallery_image'] = array_map("esc_url_raw", $_POST['hss_gallery_image']);
				}

				$finaldata['hss_setting'] = $final_settings;
				update_option('_hsscroll_settings', $finaldata);
				$s_save = true;
			}
		} // end if isset($_GET)       
	}

	$settings = get_option('_hsscroll_settings');
	if (isset($settings['hss_setting']) && !empty($settings['hss_setting'])) {
		$settings = $settings['hss_setting'];
	}

	// Choose setting 
	if (isset($settings['hss_choose_setting']) && !empty($settings['hss_choose_setting']) && $settings['hss_choose_setting'] == "on") {
		$hss_choose_setting =  "on";
		$posttype = "active";
		$imagetype = "hide";
	} else {
		$hss_choose_setting =  "";
		$posttype = "hide";
		$imagetype = "active";
	}

	// hss_mobile_setting  
	if (isset($settings['hss_mobile_setting']) && !empty($settings['hss_mobile_setting']) && $settings['hss_mobile_setting'] == "on") {
		$hss_mobile_setting =  "on";
		$checked = 'checked="checked"';
	} else {
		$hss_mobile_setting =  "";
		$checked = '';
	}

	// Description Setting
	if (isset($settings['hss_desc_on_off']) && !empty($settings['hss_desc_on_off']) && $settings['hss_desc_on_off'] == "on") {
		$desc_status = 'active';
		$hss_desc_on_off = 'on';
	} else {
		$desc_status = 'hide';
		$hss_desc_on_off = 'of';
	}

	// Read More Setting
	if (isset($settings['hss_post_button']) && !empty($settings['hss_post_button']) && $settings['hss_post_button'] == "on") {
		$hss_post_button =  "on";
		$btn_status = "active";
	} else {
		$hss_post_button =  "";
		$btn_status = "hide";
	}

?>
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-xl-6 p-0">
				<section class="my-3 mainsec">
					<form method="POST" action="<?php echo admin_url() . 'admin.php?page=horizontal-slider-with-scroll'; ?>" id="hss_form">
						<div class="container-fluid ps-md-0"> 
							<?php
															if (isset($s_save) && !empty($s_save) && $s_save == 'true') {
															?>
								<div class="row">
									<div class="col-12 p-0">
										<div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible mx-0 my-2">
											<p><strong><?php echo __('Settings saved', 'horizontal-slider-with-scroll'); ?>.</strong></p>
										</div>
									</div>
								</div> <?php
															}
										?> <div class="row">
								<div class="col-12 p-0">
									<h5><?php echo __('Horizontal Slider With Scroll', 'horizontal-slider-with-scroll'); ?></h5>
								</div>
							</div>
							<div class="row">
								<!-- First Column Start-->
								<!-- Choose type (With Post  / With Images) Start-->
								<div class="col-12 mb-3 colbox">
									<div class="row my-3 align-items-center g-xl-0 g-3">
										<!--Choose Setting Start-->
										<div class="col-xl-12 p-0">
											<div class="fields_wrap">
												<div class="field_item">
													<label class="form-check-label"><?php echo __('Choose Slider Type (With Images / With Post)', 'horizontal-slider-with-scroll'); ?>
														:</label>
													<label class="switch">
														<input type="checkbox" class="dimension hsscheck" id="choose_setting" name="hss_setting[hss_choose_setting]" value="<?php echo esc_html($hss_choose_setting); ?>">
														<span class="slider round"></span>
													</label>
												</div>

												<div class="field_item dimensionsec">
													<label class="form-check-label"><?php echo __('Items Dimensions', 'horizontal-slider-with-scroll'); ?> : <span class="dashicons dashicons-editor-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Width x Height"></span></label>
													<div>
														<input type="number" value="<?php if (isset($settings['hss_dimension']['width']) && !empty($settings['hss_dimension']['width'])) {
																						echo esc_html($settings['hss_dimension']['width']);
																					} else {
																						echo "326";
																					} ?>" class="dimension" name="hss_dimension[width]" />
														<span>x</span>
														<input type="number" value="<?php if (isset($settings['hss_dimension']['height']) && !empty($settings['hss_dimension']['height'])) {
																						echo esc_html($settings['hss_dimension']['height']);
																					} else {
																						echo "510";
																					} ?>" class="dimension" name="hss_dimension[height]" />
													</div>

												</div>

												<div class="field_item">
													<label class="form-check-label"><?php echo __('Mobile Slide', 'horizontal-slider-with-scroll'); ?>:</label>
													<label class="switch">
														<input type="checkbox" class="dimension hsscheck" id="mobile_setting" name="hss_setting[hss_mobile_setting]" value="<?php echo esc_html($hss_mobile_setting); ?>" <?php echo $checked; ?> />
														<span class="slider round"></span>
													</label>
												</div>

												<div class="field_item">
													<label class="form-check-label"><?php echo __('Shortcode', 'horizontal-slider-with-scroll'); ?>
														:</label>
													<input type="text" value="[hss]" id="shortcodetext" />
												</div>

												<div>
													<input type="submit" name="save" value="<?php echo __('Save', 'horizontal-slider-with-scroll'); ?>" class="btn btn-success" />
													<?php wp_nonce_field(basename(__FILE__), "hsscroll-nonce"); ?> <a href="https://hirewebxperts.com/contact/" class="btn btn-info text-white"><?php echo __('Support', 'horizontal-slider-with-scroll'); ?></a>
												</div>
											</div>
										</div>
										<!--Shortcode End-->
									</div>
								</div>
								<!-- Choose type (With Post  / With Images) End-->
								<!-- Custom image Start-->
								<div class="col-12 hss_custom_image p-0 <?php echo $imagetype; ?>">
									<div class="row">
										<div class="col-12 brdrigt p-0">
											<div id="card_box" class="mb-3">
												<?php
												if (isset($settings['hss_gallery_image']) && is_array($settings['hss_gallery_image'])) {
													foreach ($settings['hss_gallery_image'] as $url) {
														echo '<div id="card_" class="cards"><img src="' . esc_url_raw($url) . '"/><input type="hidden" name="hss_gallery_image[]" value="' . esc_url_raw($url) . '"/><span class="dashicons dashicons-remove removeicon"></span></div>';
													}
												}
												?>
											</div>
											<div id="card_upload_button">
												<button type="button" id="upload-btn" class="btn btn-info py-1 px-3 h6 upload zebra_tooltips text-white" data-toggle="tooltip" data-placement="top" title="Upload Logo"><span class="dashicons dashicons-upload mt-1"></span><?php echo __('Upload Image', 'horizontal-slider-with-scroll'); ?></button>
											</div>
										</div>
									</div>
								</div>
								<!-- Custom image End-->
							</div>
							<div class="row hss_post_type <?php echo esc_html($posttype); ?>">
								<!-- Post Type Start -->
								<!-- Advance Settings Start -->
								<div class="col-xl-6 col-md-6 px-0 pe-md-2 mb-3">
									<div class="row p-3 colbox">
										<div class="col-12 p-0">
											<h6 class="brdrbtm px-0">
												<?php echo __('Advance Settings', 'horizontal-slider-with-scroll'); ?></h6>
											<!-- Description Show/Hide-->
											<div class="row mt-2">
												<div class="col-12 d-flex justify-content-between p-0">
													<label class="form-check-label"><?php echo __('Description', 'horizontal-slider-with-scroll'); ?>
														:</label>
													<label class="switch">
														<input type="checkbox" class="dimension hsscheck" id="desc_on_off" name="hss_setting[hss_desc_on_off]" value="<?php echo esc_html($hss_desc_on_off); ?>">
														<span class="slider round"></span>
													</label>
												</div>
											</div>
											<!-- Post Auther, Date, Category-->
											<div class="row mt-2">
												<div class="col-12 d-flex justify-content-between p-0">
													<label class="form-check-label"><?php echo __('Post Terms', 'horizontal-slider-with-scroll'); ?>
														:</label>
													<label class="switch">
														<input type="checkbox" class="dimension hsscheck" id="post_terms" name="hss_setting[hss_post_terms]" value="<?php if (isset($settings['hss_post_terms']) && !empty($settings['hss_post_terms']) && $settings['hss_post_terms'] == "on") {
																																										echo "on";
																																									} ?>">
														<span class="slider round"></span>
													</label>
												</div>
											</div>
											<!-- Button-->
											<div class="row mt-2">
												<div class="col-12 d-flex justify-content-between p-0">
													<label class="form-check-label"><?php echo __('Read More Button', 'horizontal-slider-with-scroll'); ?>
														:</label>
													<label class="switch">
														<input type="checkbox" class="dimension hsscheck" id="post_button" name="hss_setting[hss_post_button]" value="<?php echo esc_html($hss_post_button); ?>">
														<span class="slider round"></span>
													</label>
												</div>
											</div>
											<!-- Card Hover-->
											<div class="row mt-2">
												<div class="col-12 d-flex justify-content-between p-0">
													<label class="form-check-label"><?php echo __('Card Hover Effect', 'horizontal-slider-with-scroll'); ?>
														:</label>
													<label class="switch">
														<input type="checkbox" class="dimension hsscheck" id="cardhover" name="hss_setting[hss_cardhover]" value="<?php if (isset($settings['hss_cardhover']) && !empty($settings['hss_cardhover']) && $settings['hss_cardhover'] == "on") {
																																										echo "on";
																																									} ?>">
														<span class="slider round"></span>
													</label>
												</div>
											</div>
											<!--On Card Hover Description-->
											<div class="row mt-2 hvreffct">
												<div class="col-12 d-flex justify-content-between p-0">
													<label class="form-check-label"><?php echo __('Hover Description', 'horizontal-slider-with-scroll'); ?>
														:</label>
													<label class="switch">
														<input type="checkbox" class="dimension hsscheck" id="cardhover_desc" name="hss_setting[hss_cardhover_desc]" value="<?php if (isset($settings['hss_cardhover_desc']) && !empty($settings['hss_cardhover_desc']) && $settings['hss_cardhover_desc'] == "on") {
																																												echo "on";
																																											} ?>">
														<span class="slider round"></span>
													</label>
												</div>
											</div>
											<!--On Card Hover Terms-->
											<div class="row mt-2 hvreffct">
												<div class="col-12 d-flex justify-content-between p-0">
													<label class="form-check-label"><?php echo __('Hover Terms', 'horizontal-slider-with-scroll'); ?>
														:</label>
													<label class="switch">
														<input type="checkbox" class="dimension hsscheck" id="cardhover_terms" name="hss_setting[hss_cardhover_terms]" value="<?php if (isset($settings['hss_cardhover_terms']) && !empty($settings['hss_cardhover_terms']) && $settings['hss_cardhover_terms'] == "on") {
																																													echo "on";
																																												} ?>">
														<span class="slider round"></span>
													</label>
												</div>
											</div>
											<!--On Card Hover button-->
											<div class="row mt-2 hvreffct">
												<div class="col-12 d-flex justify-content-between p-0">
													<label class="form-check-label"><?php echo __('Hover Button', 'horizontal-slider-with-scroll'); ?>
														:</label>
													<label class="switch">
														<input type="checkbox" class="dimension hsscheck" id="cardhover_button" name="hss_setting[hss_cardhover_button]" value="<?php if (isset($settings['hss_cardhover_button']) && !empty($settings['hss_cardhover_button']) && $settings['hss_cardhover_button'] == "on") {
																																													echo "on";
																																												} ?>">
														<span class="slider round"></span>
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- Advance Settings End -->
								<!-- Custom Setting Start -->
								<div class="col-xl-6 col-md-6 px-0 ps-md-2 mb-3">
									<div class="row p-3 colbox">
										<div class="col-12 brdrigt p-0">
											<h6 class="brdrbtm px-0">
												<?php echo __('Custom Settings', 'horizontal-slider-with-scroll'); ?></h6>
											<div class="row mt-2">
												<div class="col-6 p-0">
													<label class="form-check-label"><?php echo __('Select Post Type', 'horizontal-slider-with-scroll'); ?>
														:</label>
												</div>
												<div class="col-6 p-0">
													<?php
													$args = array(
														'public'   => true,
														'_builtin' => false,
													);

													$output = 'names'; // names or objects, note names is the default
													$operator = 'and'; // 'and' or 'or'

													$defaultpost = array('post' => 'post');

													$post_types = get_post_types($args, $output, $operator);
													$post_types = array_merge($defaultpost, $post_types);
													unset($post_types['hss']);
													echo "<select name='hss_setting[hss_custom_post_type]'>";
													echo "<option value=''>--Select Post Type--</option>";
													foreach ($post_types  as $post_type) {
														if (isset($settings['hss_custom_post_type']) && $settings['hss_custom_post_type'] == esc_html($post_type)) {
															$selected =  "selected='selected'";
														} else {
															$selected = '';
														}
														echo '<option value="' . esc_html($post_type) . '" ' . esc_html($selected) . '>' . ucwords(str_replace('_', ' ', esc_html($post_type))) . '</option>';
													}
													echo "</select>";
													?>
												</div>
											</div>
											<div class="row mt-2">
												<div class="col-6 p-0">
													<label class="form-check-label"><?php echo __('Number of post', 'horizontal-slider-with-scroll'); ?>
														:</label>
												</div>
												<div class="col-6 p-0">
													<input type="number" value="<?php if (isset($settings['hss_numpost']) && !empty($settings['hss_numpost'])) {
																					echo esc_html($settings['hss_numpost']);
																				} else {
																					echo "10";
																				} ?>" class="dimension" name="hss_setting[hss_numpost]" min="-1" max="999" required />
												</div>
											</div>
											<div class="row mt-2 <?php echo esc_html($desc_status); ?> descstus">
												<div class="col-6 p-0">
													<label class="form-check-label"><?php echo __('Desciption Length', 'horizontal-slider-with-scroll'); ?>
														:</label>
												</div>
												<div class="col-6 p-0">
													<input type="number" class="dimension" name="hss_setting[hss_desclength]" value="<?php if (isset($settings['hss_desclength']) && !empty($settings['hss_desclength'])) {
																																			echo esc_html($settings['hss_desclength']);
																																		} else {
																																			echo "30";
																																		} ?>" />
												</div>
											</div>
											<div class="row mt-2  <?php echo esc_html($btn_status); ?> btnlbl">
												<div class="col-6 p-0">
													<label class="form-check-label"><?php echo __('Button Label', 'horizontal-slider-with-scroll'); ?>
														:</label>
												</div>
												<div class="col-6 p-0">
													<input type="text" class="dimension" name="hss_setting[hss_button_label]" value="<?php if (isset($settings['hss_button_label']) && !empty($settings['hss_button_label'])) {
																																			echo esc_html($settings['hss_button_label']);
																																		} else {
																																			echo "Read More";
																																		} ?>" />
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- Custom Setting End -->
								<!-- Post Type End -->

							</div>
						</div>
					</form>

				</section>

			</div>
			<div class="col-xl-6">
				<section class="carousals hss_plugin_sidebar my-0 my-lg-3 p-3 colbox">
					<div class="row">
						<div class="col-md-6 mb-3 mb-md-0">
						<h6 class="px-0 mb-3 sec_heading"><?php echo __('How to use Horizontal Slider with Scroll?', ''); ?></h6>
								<div class="side_review colbox">
									<iframe src="https://www.youtube.com/embed/ULD6L4frvSE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
										<p class="mb-0 mt-1 p-3 vido"><a href="https://wordpress.org/support/plugin/horizontal-slider-with-scroll/reviews/" target="_blank"><?php echo __('Please Review', 'horizontal-slider-with-scroll'); ?> <span class="dashicons dashicons-thumbs-up"></span></a></p>
                                        <p class="mb-0 mt-1 p-3 vido text-end"><a href="https://www.youtube.com/channel/UClog8CJFaMUqll0X5zknEEQ" class="sub_btn" target="_blank"><?php echo __('SUBSCRIBE', 'horizontal-slider-with-scroll'); ?></a>
                                        </p>
                                        <div class="clear"></div>
								</div>
						</div>
						<div class="col-md-6">
							
						<h6 class="px-0 mb-3 sec_heading"><?php echo __('Explore Our Services', 'horizontal-slider-with-scroll'); ?></h6>
                                <div class="colbox">
                                    <div class="side_review optigif">
                                        <a href="https://1.bp.blogspot.com/-Gh_wRgDCnTc/YNxa8JzXTaI/AAAAAAAABlY/Rrbh-3PVYtYh7XWYVeeyJXHIa_wZfRUegCLcBGAsYHQ/s0/optimize-new-min.gif" target="_blank"><img src="<?php echo HSS_IMG . 'hirewebxperts.jpg' ?>" /></a>
                                        <p class="mb-0 p-3"><a href="https://plugins.hirewebxperts.com/support/" target="_blank"><?php echo __('For WordPress Design & Development | Custom Plugin Services', 'horizontal-slider-with-scroll'); ?></a>
                                        </p>
                                    </div>
                                </div>
						</div>
					</div>


					<div class="row">
						<div class="col-12">
						<h6 class="px-0 mb-3 sec_heading"><?php echo __('Try Our Other WordPress Plugins', 'horizontal-slider-with-scroll'); ?></h6>
								<div class="owl-carousel owl-theme " id="banners">
									<div class="item">
										<div class="side_review colbox">
											<a href="https://wordpress.org/plugins/woo-custom-cart-button/" target="_blank"><img src="<?php echo HSS_IMG . 'custom-add-to-cart.jpg' ?>" /></a>
											<p class="mb-0 p-3 vido55"><a href="https://wordpress.org/plugins/woo-custom-cart-button/" target="_blank"><?php echo __('Custom Add to Cart Button', 'horizontal-slider-with-scroll'); ?></a>
											</p>

											<div class="clear"></div>
										</div>
									</div>
									<div class="item">
										<div class="side_review colbox">
											<a href="https://wordpress.org/plugins/awesome-checkout-templates/" target="_blank"><img src="<?php echo HSS_IMG . 'awesome-checkout.jpg' ?>" /></a>
											<p class="mb-0 p-3"><a href="https://wordpress.org/plugins/awesome-checkout-templates/" target="_blank"><?php echo __('Awesome Checkout Templates', 'horizontal-slider-with-scroll'); ?></a>
											</p>
										</div>
									</div>
									<div class="item">
										<div class="side_review colbox">
											<a href="https://wordpress.org/plugins/passwords-manager/" target="_blank"><img src="<?php echo HSS_IMG . 'pasword-manager.jpg' ?>" /></a>
											<p class="mb-0 p-3"><a href="https://wordpress.org/plugins/passwords-manager/" target="_blank"><?php echo __('Passwords Manager', 'horizontal-slider-with-scroll'); ?></a></p>
										</div>
									</div>
									<div class="item">
										<div class="side_review colbox">
											<a href="https://wordpress.org/plugins/gforms-addon-for-country-and-state-selection" target="_blank"><img src="<?php echo HSS_IMG . 'country-state-selection.jpg' ?>" /></a>
											<p class="mb-0 p-3"><a href="https://wordpress.org/plugins/gforms-addon-for-country-and-state-selection" target="_blank"><?php echo __('Country and State Selection Addon for Gravity Forms', 'horizontal-slider-with-scroll'); ?></a>
											</p>
										</div>
									</div>
									<div class="item">
										<div class="side_review colbox">
											<a href="https://wordpress.org/plugins/digital-warranty-card-generator/" target="_blank"><img src="<?php echo HSS_IMG . 'digital-warranty-card.jpg' ?>" /></a>
											<p class="mb-0 p-3"><a href="https://wordpress.org/plugins/digital-warranty-card-generator/" target="_blank"><?php echo __('Digital Warranty Card Generator', 'horizontal-slider-with-scroll'); ?></a>
											</p>
										</div>
									</div>
									<div class="item">
                                        <div class="side_review colbox">
                                            <a href="https://wordpress.org/plugins/show-state-field-for-woocommerce/" target="_blank"><img src="<?php echo HSS_IMG . 'show-state-field-for-woocommerce.jpg' ?>" /></a>
                                            <p class="mb-0 p-3"><a href="https://wordpress.org/plugins/show-state-field-for-woocommerce/" target="_blank"><?php echo __('Show State Field for WooCommerce', 'horizontal-slider-with-scroll'); ?></a>
                                            </p>
                                        </div>
                                    </div>
									<div class="item">
                                        <div class="side_review colbox">
                                            <a href="https://wordpress.org/plugins/text-case-converter/" target="_blank"><img src="<?php echo HSS_IMG . 'text-case-converter.jpg' ?>" /></a>
                                            <p class="mb-0 p-3"><a href="https://wordpress.org/plugins/text-case-converter/" target="_blank"><?php echo __('Text Case Converter', 'horizontal-slider-with-scroll'); ?></a>
                                            </p>
                                        </div>
                                    </div>

								</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
						<h6 class="px-0 mb-3 sec_heading"><?php echo __('Try World Class Hosting Services', 'horizontal-slider-with-scroll'); ?></h6>
								<div class="owl-carousel owl-theme " id="kinsta_banners">
									<div class="item">
										<a href="https://kinsta.com/?kaid=NSFASHTZZXQG" target="_blank">
											<img src="<?php echo HSS_IMG . 'kinsta1.png' ?>" />
										</a>
									</div>
									<div class="item">
										<a href="https://kinsta.com/?kaid=NSFASHTZZXQG" target="_blank">
											<img src="<?php echo HSS_IMG . 'kinsta2.jpg' ?>" />
										</a>
									</div>
									<div class="item">
										<a href="https://kinsta.com/?kaid=NSFASHTZZXQG" target="_blank">
											<img src="<?php echo HSS_IMG . 'kinsta3.png' ?>" />
										</a>
									</div>
									<div class="item">
										<a href="https://kinsta.com/?kaid=NSFASHTZZXQG" target="_blank">
											<img src="<?php echo HSS_IMG . 'kinsta4.png' ?>" />
										</a>
									</div>
									<div class="item">
										<a href="https://kinsta.com/?kaid=NSFASHTZZXQG" target="_blank">
											<img src="<?php echo HSS_IMG . 'kinsta5.png' ?>" />
										</a>
									</div>
									<div class="item">
										<a href="https://kinsta.com/?kaid=NSFASHTZZXQG" target="_blank">
											<img src="<?php echo HSS_IMG . 'kinsta6.jpg' ?>" />
										</a>
									</div>
									<div class="item">
										<a href="https://kinsta.com/?kaid=NSFASHTZZXQG" target="_blank">
											<img src="<?php echo HSS_IMG . 'kinsta7.png' ?>" />
										</a>
									</div>
									<div class="item">
										<a href="https://kinsta.com/?kaid=NSFASHTZZXQG" target="_blank">
											<img src="<?php echo HSS_IMG . 'kinsta8.png' ?>" />
										</a>
									</div>
								</div>
						</div>
					</div>


				</section>
			</div>
		</div>
	</div>

<?php
}

/** 
 ** Add Horizontal image scroll shortcode
 ** Wordpress Function - add_shortcode()
 ** Use Shortcode - hss
 **/
add_shortcode('hss', 'hss_front_preview_shortcode');
function hss_front_preview_shortcode($atts)
{

	$settings = get_option('_hsscroll_settings', true);

	if (isset($settings['hss_setting']) && !empty($settings['hss_setting'])) {
		$settings = $settings['hss_setting'];
		if (isset($settings['hss_custom_post_type']) && !empty($settings['hss_custom_post_type'])) {
			$cstm_post_type = $settings['hss_custom_post_type'];
		} else {
			$cstm_post_type = '';
		}
		if (isset($settings['hss_numpost']) && !empty($settings['hss_numpost'])) {
			$hss_numpost = $settings['hss_numpost'];
		} else {
			$hss_numpost = '10';
		}
		if (isset($settings['hss_desclength']) && !empty($settings['hss_desclength'])) {
			$hss_desclength = $settings['hss_desclength'];
		} else {
			$hss_desclength = '30';
		}
		if (isset($settings['hss_button_label']) && !empty($settings['hss_button_label'])) {
			$button = $settings['hss_button_label'];
		} else {
			$button = 'View';
		}
		if (isset($settings['hss_dimension']['width']) && !empty($settings['hss_dimension']['width'])) {
			$cardwidth = $settings['hss_dimension']['width'];
		} else {
			$cardwidth = '326';
		}
		if (isset($settings['hss_dimension']['height']) && !empty($settings['hss_dimension']['height'])) {
			$cardheight = $settings['hss_dimension']['height'];
		} else {
			$cardheight = '510';
		}
	}

	$html = '';
	$html .=  "<div id='myProgress'> <div id='myBar'></div></div>";
	$html .=  '<div id="mainhssec" data-horizontal="yes">';
	if (isset($settings['hss_mobile_setting']) && !empty($settings['hss_mobile_setting']) && $settings['hss_mobile_setting'] == 'on') {
		$html .= '<style>';
		$html .= '@media screen and (max-width: 767px){
.hss-content-area.is-disabled {
display: none;
}
.is-active {
display: block;
}
.Scroll__container {
overflow: auto;
}
.no-touch .entry-portfolio--hovercard.enable-hover:hover .hovercard__popup {
display: block;
}
}';
		$html .= '</style>';
	}
	$html .= "<div style='' id='loadingDiv'><div class='loader'></div></div>";
	$html .=  '<div class="hss-content-area" >';

	if (isset($settings['hss_choose_setting']) && !empty($settings['hss_choose_setting']) && $settings['hss_choose_setting'] == "on") {

		$args = array(
			'numberposts' => $settings['hss_numpost'],
			'post_type'   => $settings['hss_custom_post_type']
		);
		$latest_results = get_posts($args);

		foreach ($latest_results as $latest_result) {

			$id = $latest_result->ID;
			$post_title = $latest_result->post_title;
			$post_content = $latest_result->post_content;
			$slug = $latest_result->post_name;
			$url = wp_get_attachment_url(get_post_thumbnail_id($id), 'thumbnail');

			//Post terms
			$category = '';
			$category_detail = get_the_category($id); //$post->ID
			foreach ($category_detail as $cd) {
				$category .=  '<span>' . esc_html($cd->cat_name) . '</span> ';
			}

			if (!isset($settings['hss_cardhover'])) {
				//Post Terms
				if (isset($settings['hss_post_terms']) && !empty($settings['hss_post_terms']) && $settings['hss_post_terms'] == "on") {
					$post_term = '<h4 class="hovercard_terms">' . $category . '</h4>  ';
				} else {
					$post_term = '';
				}
				//Post Description
				if (isset($settings['hss_desc_on_off']) && !empty($settings['hss_desc_on_off']) && $settings['hss_desc_on_off'] == "on") {
					$post_desc = '<p class="hovercard_desc">' . wp_trim_words(wp_strip_all_tags($post_content), esc_html($hss_desclength)) . '</p>';
				} else {
					$post_desc = '';
				}

				//Post Button
				if (isset($settings['hss_post_button']) && !empty($settings['hss_post_button']) && $settings['hss_post_button'] == "on") {
					$post_button = '<a class="hovercard_btn" href="' . esc_url_raw(site_url() . '/' . $slug) . '">' . esc_html($button) . '</a>';
				} else {
					$post_button = '';
				}
			} else {
				$post_term = '';
				$post_desc = '';
				$post_button = '';
			}

			//Hover effect
			if (isset($settings['hss_cardhover']) && !empty($settings['hss_cardhover']) && $settings['hss_cardhover'] == "on") {
				$card_hover = 'enable-hover';

				// card hover description
				if (isset($settings['hss_cardhover_desc']) && !empty($settings['hss_cardhover_desc']) && $settings['hss_cardhover_desc'] == "on") {
					$card_hover_desc = '<p class="hovercarddesc">' . wp_trim_words(wp_strip_all_tags($post_content), esc_html($hss_desclength)) . '</p>';
				} else {
					$card_hover_desc = '';
				}

				// card hover term
				if (isset($settings['hss_cardhover_terms']) && !empty($settings['hss_cardhover_terms']) && $settings['hss_cardhover_terms'] == "on") {
					$card_hover_term = '<h4 class="hovercard__subtitle">' . $category . '</h4>';
				} else {
					$card_hover_term = '';
				}

				// card hover button
				if (isset($settings['hss_cardhover_button']) && !empty($settings['hss_cardhover_button']) && $settings['hss_cardhover_button'] == "on" && isset($settings['hss_post_button']) && !empty($settings['hss_post_button']) && $settings['hss_post_button'] == "on") {
					$card_hover_button = '<hr class="sepline"><a class="" href="' . esc_url_raw(site_url() . '/' . $slug) . '">' . esc_html($button) . '</a>';
				} else {
					$card_hover_button = '';
				}
			} else {
				$card_hover = '';
				$card_hover_desc = '';
				$card_hover_term = '';
				$card_hover_button = '';
			}

			$html .=  '<div id="gallery-776" class="' . esc_html($card_hover) . ' entry-portfolio  entry-portfolio--hovercard" data-size="' . esc_html($cardwidth) . 'x' . esc_html($cardheight) . '" data-item-type="image">
			<div class="hovercard__thumbnail" style="background-image:url(' . esc_url_raw($url) . ');">
				<div class="hssthumbnail" ></div>  
					<div class="withouthovercard">

						<h3 class="hovercard__title">
							<a href="' . esc_url_raw(site_url() . '/' . $slug) . '">' . esc_html($post_title) . '</a>
						</h3>
						' . $post_term . ' 
						' . $post_desc . '                                                     
						' . $post_button . '
					</div>
					<div class="hovercard__popup">
						<div class="hovercard__inner">                                   
						<h3 class="hovercard__title--popup">
							<a href="' . esc_url_raw(site_url() . '/' . $slug) . '">' . esc_html($post_title) . '</a>
						</h3>
						' . $card_hover_term . '       
						' . $card_hover_desc . '                         
						' . $card_hover_button . '
						</div>
					</div>
				</div>

		</div>';
		} //end foreach loop

	} else {
		if (isset($settings['hss_gallery_image']) && is_array($settings['hss_gallery_image'])) {
			$x = 1;
			foreach ($settings['hss_gallery_image'] as $url) {
				$html .=  '<div id="gallery-' . $x . '" class="entry-portfolio  entry-portfolio--hovercard" data-size="' . esc_html($cardwidth) . 'x' . esc_html($cardheight) . '" data-item-type="image">
	<div class="hovercard__thumbnail" style="background-image:url(' . esc_url_raw($url) . ');">
		<div class="" ></div>       
	</div>
</div>';
				$x++;
			}
		} else {
			echo "<p>Please confirm your setting first.</p>";
		}
	}
	$html .=  '</div>';
	$html .=  '</div>';
	return $html;
}
?>