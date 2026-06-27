<?php
/**
 * Plugin Name: BSA Visitor Counter
 * Plugin URI:  https://github.com/risacaph/gwt-wordpress
 * Description: Lightweight visitor / page-view counter for the Barangay San Agustin GWT theme. Shows a configurable counter in the upper-right of the masthead (or as a floating badge). Configure it under Settings → Visitor Counter.
 * Version:     1.0.0
 * Author:      Barangay San Agustin
 * License:     MIT
 * Text Domain: bsa-visitor-counter
 *
 * @package BSA_Visitor_Counter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'BSA_VC_VERSION', '1.0.0' );
define( 'BSA_VC_OPTION', 'bsa_vc_settings' ); // settings array
define( 'BSA_VC_TOTAL', 'bsa_vc_total' );     // all-time page views
define( 'BSA_VC_UNIQUE', 'bsa_vc_unique' );   // all-time unique visitors

/**
 * Default settings.
 */
function bsa_vc_defaults() {
	return array(
		'enabled'        => 1,
		'label'          => 'Visitors',
		'mode'           => 'unique',   // 'unique' | 'views'
		'base'           => 0,          // number added to the real count (seed an initial value)
		'position'       => 'topbar',   // 'topbar' (theme upper-right slot) | 'float' (fixed badge) | 'manual'
		'show_icon'      => 1,
		'hide_on_mobile' => 1,
	);
}

/**
 * Get a single setting with default fallback.
 */
function bsa_vc_get( $key ) {
	$opts = get_option( BSA_VC_OPTION, array() );
	$opts = wp_parse_args( is_array( $opts ) ? $opts : array(), bsa_vc_defaults() );
	return isset( $opts[ $key ] ) ? $opts[ $key ] : null;
}

/**
 * Activation — seed options and counters.
 */
function bsa_vc_activate() {
	if ( false === get_option( BSA_VC_OPTION ) ) {
		add_option( BSA_VC_OPTION, bsa_vc_defaults() );
	}
	add_option( BSA_VC_TOTAL, 0 );
	add_option( BSA_VC_UNIQUE, 0 );
}
register_activation_hook( __FILE__, 'bsa_vc_activate' );

/* =========================================================================
 * Counting
 * ====================================================================== */

/**
 * Is the current request a real, countable front-end page view?
 */
function bsa_vc_is_countable() {
	if ( is_admin() || is_feed() || is_trackback() || is_robots() ) {
		return false;
	}
	if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
		return false;
	}
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return false;
	}
	// Skip logged-in users who can edit (admins/editors previewing the site).
	if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
		return false;
	}
	// Cheap bot filter.
	$ua = isset( $_SERVER['HTTP_USER_AGENT'] ) ? strtolower( $_SERVER['HTTP_USER_AGENT'] ) : '';
	if ( '' === $ua ) {
		return false;
	}
	foreach ( array( 'bot', 'crawl', 'spider', 'slurp', 'curl', 'wget', 'facebookexternalhit', 'preview', 'monitor' ) as $needle ) {
		if ( false !== strpos( $ua, $needle ) ) {
			return false;
		}
	}
	return true;
}

/**
 * Record a visit. Runs early (before output) so the unique-visitor cookie
 * can be set.
 */
function bsa_vc_record_visit() {
	if ( ! bsa_vc_get( 'enabled' ) || ! bsa_vc_is_countable() ) {
		return;
	}

	// Every countable page load increments total views.
	$total = (int) get_option( BSA_VC_TOTAL, 0 ) + 1;
	update_option( BSA_VC_TOTAL, $total, false );

	// Unique visitors: count once per browser per day via a cookie.
	if ( empty( $_COOKIE['bsa_vc_seen'] ) ) {
		$unique = (int) get_option( BSA_VC_UNIQUE, 0 ) + 1;
		update_option( BSA_VC_UNIQUE, $unique, false );

		if ( ! headers_sent() ) {
			setcookie(
				'bsa_vc_seen',
				'1',
				time() + DAY_IN_SECONDS,
				defined( 'COOKIEPATH' ) ? COOKIEPATH : '/',
				defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : ''
			);
		}
	}
}
add_action( 'template_redirect', 'bsa_vc_record_visit', 1 );

/**
 * The number to display, honouring the mode and the base offset.
 */
function bsa_vc_current_count() {
	$base = (int) bsa_vc_get( 'base' );
	if ( 'views' === bsa_vc_get( 'mode' ) ) {
		return $base + (int) get_option( BSA_VC_TOTAL, 0 );
	}
	return $base + (int) get_option( BSA_VC_UNIQUE, 0 );
}

/* =========================================================================
 * Rendering
 * ====================================================================== */

/**
 * Build the counter markup.
 *
 * @param string $context 'topbar' | 'float' | 'manual'.
 * @return string HTML (empty string if it should not render in this context).
 */
function bsa_vc_render( $context = 'manual' ) {
	if ( ! bsa_vc_get( 'enabled' ) ) {
		return '';
	}
	$position = bsa_vc_get( 'position' );

	// Only emit in the slot that matches the chosen position.
	if ( 'topbar' === $context && 'topbar' !== $position ) {
		return '';
	}
	if ( 'float' === $context && 'float' !== $position ) {
		return '';
	}

	$label   = esc_html( bsa_vc_get( 'label' ) );
	$count   = number_format_i18n( bsa_vc_current_count() );
	$icon    = bsa_vc_get( 'show_icon' ) ? '<i class="fa fa-eye" aria-hidden="true"></i> ' : '';
	$classes = 'bsa-vc bsa-vc--' . esc_attr( $context );
	if ( bsa_vc_get( 'hide_on_mobile' ) ) {
		$classes .= ' bsa-vc--hide-mobile';
	}

	$inner = sprintf(
		'<span class="bsa-vc__inner">%1$s<span class="bsa-vc__label">%2$s</span> <span class="bsa-vc__count">%3$s</span></span>',
		$icon,
		$label,
		esc_html( $count )
	);

	// In the theme top bar the counter slots in as a menu <li>.
	if ( 'topbar' === $context ) {
		return '<li class="' . $classes . '">' . $inner . '</li>';
	}
	return '<div class="' . $classes . '">' . $inner . '</div>';
}

/**
 * Shortcode: [visitor_counter]
 */
function bsa_vc_shortcode() {
	return bsa_vc_render( 'manual' );
}
add_shortcode( 'visitor_counter', 'bsa_vc_shortcode' );

/**
 * Floating-badge output (only when position = float).
 */
function bsa_vc_footer_badge() {
	echo bsa_vc_render( 'float' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- markup escaped in render.
}
add_action( 'wp_footer', 'bsa_vc_footer_badge' );

/**
 * Front-end styles.
 */
function bsa_vc_styles() {
	if ( ! bsa_vc_get( 'enabled' ) ) {
		return;
	}
	$css = '
	.bsa-vc__inner{display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;font-weight:600;white-space:nowrap;}
	.bsa-vc__count{background:#fcd116;color:#002a7a;padding:.05rem .45rem;border-radius:10px;font-weight:800;}
	/* Top bar slot (upper-right of masthead) */
	li.bsa-vc--topbar{display:flex;align-items:center;padding:0 15px;}
	#main-nav li.bsa-vc--topbar .bsa-vc__inner{color:#fff;line-height:58px;}
	/* Floating badge */
	.bsa-vc--float{position:fixed;top:64px;right:12px;z-index:60;background:#0038a8;color:#fff;
		padding:.4rem .7rem;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,.25);}
	@media only screen and (max-width:63.9375em){
		.bsa-vc--float{top:48px;}
		.bsa-vc--hide-mobile{display:none !important;}
	}';
	wp_register_style( 'bsa-vc', false, array(), BSA_VC_VERSION );
	wp_enqueue_style( 'bsa-vc' );
	wp_add_inline_style( 'bsa-vc', $css );
}
add_action( 'wp_enqueue_scripts', 'bsa_vc_styles' );

/* =========================================================================
 * Admin settings page  (Settings → Visitor Counter)
 * ====================================================================== */

function bsa_vc_admin_menu() {
	add_options_page(
		'Visitor Counter',
		'Visitor Counter',
		'manage_options',
		'bsa-visitor-counter',
		'bsa_vc_settings_page'
	);
}
add_action( 'admin_menu', 'bsa_vc_admin_menu' );

function bsa_vc_register_settings() {
	register_setting( 'bsa_vc_group', BSA_VC_OPTION, 'bsa_vc_sanitize' );
}
add_action( 'admin_init', 'bsa_vc_register_settings' );

/**
 * Sanitize settings on save.
 */
function bsa_vc_sanitize( $input ) {
	$out = bsa_vc_defaults();
	$out['enabled']        = empty( $input['enabled'] ) ? 0 : 1;
	$out['show_icon']      = empty( $input['show_icon'] ) ? 0 : 1;
	$out['hide_on_mobile'] = empty( $input['hide_on_mobile'] ) ? 0 : 1;
	$out['label']          = isset( $input['label'] ) ? sanitize_text_field( $input['label'] ) : 'Visitors';
	$out['base']           = isset( $input['base'] ) ? max( 0, (int) $input['base'] ) : 0;
	$out['mode']           = ( isset( $input['mode'] ) && 'views' === $input['mode'] ) ? 'views' : 'unique';
	$pos                   = isset( $input['position'] ) ? $input['position'] : 'topbar';
	$out['position']       = in_array( $pos, array( 'topbar', 'float', 'manual' ), true ) ? $pos : 'topbar';
	return $out;
}

/**
 * Handle the "Reset counter" action.
 */
function bsa_vc_maybe_reset() {
	if ( ! is_admin() || empty( $_POST['bsa_vc_reset'] ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	check_admin_referer( 'bsa_vc_reset_action', 'bsa_vc_reset_nonce' );
	update_option( BSA_VC_TOTAL, 0, false );
	update_option( BSA_VC_UNIQUE, 0, false );
	add_settings_error( 'bsa_vc', 'bsa_vc_reset', 'Visitor counts have been reset to zero.', 'updated' );
}
add_action( 'admin_init', 'bsa_vc_maybe_reset' );

function bsa_vc_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$mode     = bsa_vc_get( 'mode' );
	$position = bsa_vc_get( 'position' );
	settings_errors( 'bsa_vc' );
	?>
	<div class="wrap">
		<h1>Visitor Counter</h1>
		<p>Displays a visitor counter in the upper-right of the Barangay San Agustin masthead.
			Current totals &mdash; <strong>Unique visitors:</strong> <?php echo esc_html( number_format_i18n( (int) get_option( BSA_VC_UNIQUE, 0 ) ) ); ?>,
			<strong>Page views:</strong> <?php echo esc_html( number_format_i18n( (int) get_option( BSA_VC_TOTAL, 0 ) ) ); ?>.</p>

		<form method="post" action="options.php">
			<?php settings_fields( 'bsa_vc_group' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">Enable counter</th>
					<td><label><input type="checkbox" name="<?php echo esc_attr( BSA_VC_OPTION ); ?>[enabled]" value="1" <?php checked( bsa_vc_get( 'enabled' ), 1 ); ?>> Show the visitor counter on the site</label></td>
				</tr>
				<tr>
					<th scope="row"><label for="bsa_vc_label">Label</label></th>
					<td><input type="text" id="bsa_vc_label" class="regular-text" name="<?php echo esc_attr( BSA_VC_OPTION ); ?>[label]" value="<?php echo esc_attr( bsa_vc_get( 'label' ) ); ?>"></td>
				</tr>
				<tr>
					<th scope="row">Count mode</th>
					<td>
						<label><input type="radio" name="<?php echo esc_attr( BSA_VC_OPTION ); ?>[mode]" value="unique" <?php checked( $mode, 'unique' ); ?>> Unique visitors (once per browser per day)</label><br>
						<label><input type="radio" name="<?php echo esc_attr( BSA_VC_OPTION ); ?>[mode]" value="views" <?php checked( $mode, 'views' ); ?>> Total page views</label>
					</td>
				</tr>
				<tr>
					<th scope="row">Position</th>
					<td>
						<label><input type="radio" name="<?php echo esc_attr( BSA_VC_OPTION ); ?>[position]" value="topbar" <?php checked( $position, 'topbar' ); ?>> Masthead top bar (upper-right) &mdash; recommended</label><br>
						<label><input type="radio" name="<?php echo esc_attr( BSA_VC_OPTION ); ?>[position]" value="float" <?php checked( $position, 'float' ); ?>> Floating badge (fixed upper-right corner)</label><br>
						<label><input type="radio" name="<?php echo esc_attr( BSA_VC_OPTION ); ?>[position]" value="manual" <?php checked( $position, 'manual' ); ?>> Manual only (use the <code>[visitor_counter]</code> shortcode)</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="bsa_vc_base">Starting number</label></th>
					<td>
						<input type="number" id="bsa_vc_base" min="0" name="<?php echo esc_attr( BSA_VC_OPTION ); ?>[base]" value="<?php echo esc_attr( bsa_vc_get( 'base' ) ); ?>">
						<p class="description">Optional offset added to the real count (e.g. to continue from a previous counter).</p>
					</td>
				</tr>
				<tr>
					<th scope="row">Display options</th>
					<td>
						<label><input type="checkbox" name="<?php echo esc_attr( BSA_VC_OPTION ); ?>[show_icon]" value="1" <?php checked( bsa_vc_get( 'show_icon' ), 1 ); ?>> Show eye icon</label><br>
						<label><input type="checkbox" name="<?php echo esc_attr( BSA_VC_OPTION ); ?>[hide_on_mobile]" value="1" <?php checked( bsa_vc_get( 'hide_on_mobile' ), 1 ); ?>> Hide on small screens</label>
					</td>
				</tr>
			</table>
			<?php submit_button( 'Save Changes' ); ?>
		</form>

		<hr>
		<form method="post">
			<?php wp_nonce_field( 'bsa_vc_reset_action', 'bsa_vc_reset_nonce' ); ?>
			<p><button type="submit" name="bsa_vc_reset" value="1" class="button button-secondary"
				onclick="return confirm('Reset all visitor counts to zero? This cannot be undone.');">Reset counter to zero</button></p>
		</form>
	</div>
	<?php
}
