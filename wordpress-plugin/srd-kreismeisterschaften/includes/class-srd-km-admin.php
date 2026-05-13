<?php
/**
 * Einstellungsseite unter Einstellungen → SRD Kreismeisterschaften.
 *
 * @package SRD_Kreismeisterschaften
 */

if (!defined('ABSPATH')) {
	exit;
}

class SRD_KM_Admin {

	private static ?self $instance = null;

	public static function instance(): self {
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action('admin_menu', array($this, 'register_menu'));
		add_action('admin_init', array($this, 'register_settings'));
	}

	public function register_menu(): void {
		add_options_page(
			__('SRD Kreismeisterschaften', 'srd-kreismeisterschaften'),
			__('SRD Kreismeisterschaften', 'srd-kreismeisterschaften'),
			'manage_options',
			'srd-kreismeisterschaften',
			array($this, 'render_page')
		);
	}

	public function register_settings(): void {
		register_setting(
			'srd_km_settings_group',
			'srd_km_settings',
			array(
				'type'              => 'array',
				'sanitize_callback' => array($this, 'sanitize_settings'),
			)
		);
	}

	/**
	 * @param array<string, mixed> $input
	 * @return array<string, mixed>
	 */
	public function sanitize_settings($input): array {
		$out = srd_km_get_settings();
		$prev = is_array(get_option('srd_km_settings', array())) ? get_option('srd_km_settings', array()) : array();
		if (!is_array($input)) {
			return $out;
		}
		$out['page_id'] = isset($input['page_id']) ? absint($input['page_id']) : 0;
		$out['db_use_wp'] = empty($input['db_use_wp']) ? 0 : 1;
		$out['db_host'] = isset($input['db_host']) ? sanitize_text_field((string) $input['db_host']) : '';
		$out['db_user'] = isset($input['db_user']) ? sanitize_text_field((string) $input['db_user']) : '';
		$pass_in = isset($input['db_pass']) ? (string) $input['db_pass'] : '';
		$out['db_pass'] = ($pass_in === '' && isset($prev['db_pass'])) ? (string) $prev['db_pass'] : $pass_in;
		$out['db_name'] = isset($input['db_name']) ? sanitize_text_field((string) $input['db_name']) : '';
		$out['results_path'] = isset($input['results_path']) ? sanitize_text_field((string) $input['results_path']) : '';
		$out['results_url'] = isset($input['results_url']) ? esc_url_raw((string) $input['results_url']) : '';
		$out['home_url_custom'] = isset($input['home_url_custom']) ? esc_url_raw((string) $input['home_url_custom']) : '';
		return $out;
	}

	public function render_page(): void {
		if (!current_user_can('manage_options')) {
			return;
		}
		$s = srd_km_get_settings();
		$pages = get_pages(array('sort_column' => 'post_title'));
		?>
		<div class="wrap">
			<h1><?php echo esc_html__('SRD Kreismeisterschaften', 'srd-kreismeisterschaften'); ?></h1>
			<p><?php echo esc_html__('Legen Sie die Seite mit dem Shortcode [srd_km] fest und den Pfad zu Ihrem results-Ordner (wie im bisherigen SRD-Projekt).', 'srd-kreismeisterschaften'); ?></p>
			<form method="post" action="options.php">
				<?php settings_fields('srd_km_settings_group'); ?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="srd_km_page_id"><?php esc_html_e('KM-Seite (mit [srd_km])', 'srd-kreismeisterschaften'); ?></label></th>
						<td>
							<select name="srd_km_settings[page_id]" id="srd_km_page_id">
								<option value="0"><?php esc_html_e('— bitte wählen —', 'srd-kreismeisterschaften'); ?></option>
								<?php foreach ($pages as $p) : ?>
									<option value="<?php echo esc_attr((string) $p->ID); ?>" <?php selected((int) $s['page_id'], (int) $p->ID); ?>>
										<?php echo esc_html($p->post_title); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e('Datenbank', 'srd-kreismeisterschaften'); ?></th>
						<td>
							<input type="hidden" name="srd_km_settings[db_use_wp]" value="0" />
							<label>
								<input type="checkbox" name="srd_km_settings[db_use_wp]" value="1" <?php checked(!empty($s['db_use_wp'])); ?> />
								<?php esc_html_e('WordPress-Datenbank verwenden (DB_HOST / DB_NAME aus wp-config.php)', 'srd-kreismeisterschaften'); ?>
							</label>
							<p class="description"><?php esc_html_e('Deaktivieren, falls die SRD-Tabellen auf einem anderen Server liegen.', 'srd-kreismeisterschaften'); ?></p>
							<p>
								<label><?php esc_html_e('Host', 'srd-kreismeisterschaften'); ?><br />
									<input type="text" class="regular-text" name="srd_km_settings[db_host]" value="<?php echo esc_attr((string) $s['db_host']); ?>" /></label>
							</p>
							<p>
								<label><?php esc_html_e('Benutzer', 'srd-kreismeisterschaften'); ?><br />
									<input type="text" class="regular-text" name="srd_km_settings[db_user]" value="<?php echo esc_attr((string) $s['db_user']); ?>" autocomplete="off" /></label>
							</p>
							<p>
								<label><?php esc_html_e('Passwort', 'srd-kreismeisterschaften'); ?><br />
									<input type="password" class="regular-text" name="srd_km_settings[db_pass]" value="" autocomplete="new-password" placeholder="<?php esc_attr_e('leer lassen = unverändert', 'srd-kreismeisterschaften'); ?>" /></label>
							</p>
							<p>
								<label><?php esc_html_e('Datenbankname', 'srd-kreismeisterschaften'); ?><br />
									<input type="text" class="regular-text" name="srd_km_settings[db_name]" value="<?php echo esc_attr((string) $s['db_name']); ?>" /></label>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="srd_km_results_path"><?php esc_html_e('Pfad zum Ordner „results“', 'srd-kreismeisterschaften'); ?></label></th>
						<td>
							<input type="text" class="large-text code" name="srd_km_settings[results_path]" id="srd_km_results_path"
								value="<?php echo esc_attr((string) $s['results_path']); ?>"
								placeholder="<?php echo esc_attr(trailingslashit(WP_CONTENT_DIR) . 'uploads/srd-results'); ?>" />
							<p class="description"><?php esc_html_e('Absoluter Serverpfad, in dem u. a. km_2025/, km-licht/ liegen (Inhalt des bisherigen results-Verzeichnisses).', 'srd-kreismeisterschaften'); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="srd_km_results_url"><?php esc_html_e('URL zum Ordner „results“', 'srd-kreismeisterschaften'); ?></label></th>
						<td>
							<input type="url" class="large-text code" name="srd_km_settings[results_url]" id="srd_km_results_url"
								value="<?php echo esc_attr((string) $s['results_url']); ?>"
								placeholder="<?php echo esc_attr(content_url('/uploads/srd-results')); ?>" />
							<p class="description"><?php esc_html_e('Öffentliche Basis-URL (ohne abschließenden Slash wird einer ergänzt). Für PDF- und Lichtschießen-Links.', 'srd-kreismeisterschaften'); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="srd_km_home_url"><?php esc_html_e('Link „Ergebnishistorie“ (optional)', 'srd-kreismeisterschaften'); ?></label></th>
						<td>
							<input type="url" class="large-text" name="srd_km_settings[home_url_custom]" id="srd_km_home_url"
								value="<?php echo esc_attr((string) $s['home_url_custom']); ?>" />
							<p class="description"><?php esc_html_e('Leer = Startseite der Website (home_url()).', 'srd-kreismeisterschaften'); ?></p>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}
