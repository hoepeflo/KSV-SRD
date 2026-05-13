<?php
/**
 * Plugin Name: SRD Kreismeisterschaften
 * Description: Kreismeisterschaften (KM) aus dem SRD-Ergebnisdienst in WordPress – Jahresübersicht, Disziplinen, PDF/HTML, Bogen und Blasrohr.
 * Version: 1.0.0
 * Author: KSV Fallingbostel / SRD
 * License: MIT
 * Text Domain: srd-kreismeisterschaften
 *
 * @package SRD_Kreismeisterschaften
 */

if (!defined('ABSPATH')) {
	exit;
}

define('SRD_KM_VERSION', '1.0.0');
define('SRD_KM_PLUGIN_FILE', __FILE__);
define('SRD_KM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SRD_KM_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once SRD_KM_PLUGIN_DIR . 'includes/class-srd-km-db.php';
require_once SRD_KM_PLUGIN_DIR . 'includes/class-srd-km-admin.php';
require_once SRD_KM_PLUGIN_DIR . 'includes/class-srd-km-frontend.php';

/**
 * @return array<string, mixed>
 */
function srd_km_get_settings(): array {
	$defaults = array(
		'page_id'            => 0,
		'db_use_wp'          => 1,
		'db_host'            => '',
		'db_user'            => '',
		'db_pass'            => '',
		'db_name'            => '',
		'results_path'       => '',
		'results_url'        => '',
		'home_url_custom'    => '',
	);
	$stored = get_option('srd_km_settings', array());
	return array_merge($defaults, is_array($stored) ? $stored : array());
}

function srd_km_bootstrap(): void {
	SRD_KM_Admin::instance();
	SRD_KM_Frontend::instance();
}

add_action('plugins_loaded', 'srd_km_bootstrap');

register_activation_hook(__FILE__, static function (): void {
	if (!get_option('srd_km_settings')) {
		add_option('srd_km_settings', array());
	}
});
