<?php
/**
 * SLY Pebble Lite - WooCommerce Fraud Guard (Tuned)
 *
 * Theme-integrated checkout defense layer:
 * - Bot traps and suspicious agent filtering
 * - Checkout velocity controls
 * - Risk scoring with block + manual review thresholds
 * - Order flagging and post-payment hold workflow
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('sly_fg_settings')) {
	function sly_fg_settings() {
		return array(
			'rate_window_seconds'   => 10 * MINUTE_IN_SECONDS,
			'ip_attempt_limit'      => 8,   // raised from 4 — payment failures + retries are normal
			'email_attempt_limit'   => 5,   // raised from 3
			'ip_unique_email_limit' => 3,
			'min_checkout_seconds'  => 3,   // lowered from 12 — bots are blocked; real users shouldn't wait
			'low_value_threshold'   => 30.00,
			'block_score'           => 65,
			'review_score'          => 30,
		);
	}
}

if (!function_exists('sly_fg_has_wc_session')) {
	function sly_fg_has_wc_session() {
		return function_exists('WC') && WC()->session;
	}
}

if (!function_exists('sly_fg_key')) {
	function sly_fg_key($prefix, $value) {
		return $prefix . md5(strtolower(trim((string) $value)));
	}
}

if (!function_exists('sly_fg_bump_counter')) {
	function sly_fg_bump_counter($key, $ttl) {
		$count = (int) get_transient($key);
		$count++;
		set_transient($key, $count, (int) $ttl);
		return $count;
	}
}

if (!function_exists('sly_fg_get_ip')) {
	function sly_fg_get_ip() {
		if (class_exists('WC_Geolocation')) {
			$ip = WC_Geolocation::get_ip_address();
		} else {
			$ip = isset($_SERVER['REMOTE_ADDR']) ? (string) wp_unslash($_SERVER['REMOTE_ADDR']) : '';
		}

		$ip = preg_replace('/[^a-fA-F0-9:., ]/', '', (string) $ip);
		return trim((string) $ip);
	}
}

if (!function_exists('sly_fg_get_ua')) {
	function sly_fg_get_ua() {
		$ua = isset($_SERVER['HTTP_USER_AGENT']) ? (string) wp_unslash($_SERVER['HTTP_USER_AGENT']) : '';
		return substr(sanitize_text_field($ua), 0, 300);
	}
}

if (!function_exists('sly_fg_is_bad_ua')) {
	function sly_fg_is_bad_ua($ua) {
		$ua = strtolower((string) $ua);
		if ($ua === '') {
			return true;
		}

		$patterns = array(
			'curl',
			'wget',
			'python',
			'scrapy',
			'httpclient',
			'headless',
			'phantomjs',
			'selenium',
			'go-http-client',
		);

		$patterns = apply_filters('sly_fg_ua_patterns', $patterns);

		foreach ($patterns as $pattern) {
			if (strpos($ua, strtolower((string) $pattern)) !== false) {
				return true;
			}
		}

		return false;
	}
}

if (!function_exists('sly_fg_is_disposable_email')) {
	function sly_fg_is_disposable_email($email) {
		$email = sanitize_email((string) $email);
		if ($email === '' || strpos($email, '@') === false) {
			return false;
		}

		$parts  = explode('@', strtolower($email));
		$domain = end($parts);

		$blocked = array(
			'mailinator.com',
			'guerrillamail.com',
			'10minutemail.com',
			'tempmail.com',
			'temp-mail.org',
			'yopmail.com',
			'getnada.com',
			'trashmail.com',
			'maildrop.cc',
			'fakeinbox.com',
			'throwawaymail.com',
			'sharklasers.com',
			'grr.la',
			'mailnesia.com',
			'mohmal.com',
			'inboxkitten.com',
			'tempmailo.com',
			'emailondeck.com',
			'tempinbox.com',
		);

		$blocked = apply_filters('sly_fg_disposable_domains', $blocked);

		return in_array($domain, $blocked, true);
	}
}

if (!function_exists('sly_fg_amount')) {
	function sly_fg_amount($amount) {
		if (is_numeric($amount)) {
			return (float) $amount;
		}

		$clean = preg_replace('/[^0-9.,-]/', '', (string) $amount);
		$clean = str_replace(',', '', (string) $clean);

		return is_numeric($clean) ? (float) $clean : 0.0;
	}
}

if (!function_exists('sly_fg_score')) {
	function sly_fg_score($posted, $cart_total, $ip_attempts, $email_attempts, $ip_unique_email_count) {
		$settings = sly_fg_settings();
		$score    = 0;
		$reasons  = array();

		$first_name = isset($posted['billing_first_name']) ? sanitize_text_field((string) $posted['billing_first_name']) : '';
		$last_name  = isset($posted['billing_last_name']) ? sanitize_text_field((string) $posted['billing_last_name']) : '';
		$address_1  = isset($posted['billing_address_1']) ? sanitize_text_field((string) $posted['billing_address_1']) : '';
		$phone      = isset($posted['billing_phone']) ? preg_replace('/\D+/', '', (string) $posted['billing_phone']) : '';
		$email      = isset($posted['billing_email']) ? sanitize_email((string) $posted['billing_email']) : '';
		$ship_to    = !empty($posted['ship_to_different_address']);

		if ($cart_total > 0 && $cart_total < (float) $settings['low_value_threshold']) {
			$score += 25;
			$reasons[] = 'low_order_value';
		}

		if (
			$ship_to &&
			!empty($posted['billing_country']) &&
			!empty($posted['shipping_country']) &&
			$posted['billing_country'] !== $posted['shipping_country']
		) {
			$score += 20;
			$reasons[] = 'billing_shipping_country_mismatch';
		}

		if (strlen((string) $phone) < 8) {
			$score += 10;
			$reasons[] = 'short_or_missing_phone';
		}

		if (substr((string) $phone, 0, 8) === '00000000' || preg_match('/^(12345|11111|99999)/', (string) $phone)) {
			$score += 20;
			$reasons[] = 'synthetic_phone_pattern';
		}

		if (preg_match('/\d{2,}/', $first_name . ' ' . $last_name)) {
			$score += 20;
			$reasons[] = 'name_contains_digits';
		}

		if ($ip_attempts >= (int) $settings['ip_attempt_limit']) {
			$score += 25;
			$reasons[] = 'high_ip_attempt_volume';
		}

		if ($email_attempts >= (int) $settings['email_attempt_limit']) {
			$score += 20;
			$reasons[] = 'high_email_attempt_volume';
		}

		if ($ip_unique_email_count >= 3) {
			$score += 35;
			$reasons[] = 'multiple_emails_from_same_ip';
		}

		if (preg_match('/\d{5,}/', (string) strstr($email, '@', true))) {
			$score += 10;
			$reasons[] = 'email_local_part_looks_generated';
		}

		if (preg_match('/\b(test|asdf|qwerty|unknown|none)\b/i', $first_name . ' ' . $last_name . ' ' . $address_1)) {
			$score += 35;
			$reasons[] = 'placeholder_identity_or_address';
		}

		return array($score, $reasons);
	}
}

if (!function_exists('sly_fg_mark_checkout_start')) {
	function sly_fg_mark_checkout_start() {
		$is_checkout = function_exists('is_checkout') && is_checkout();
		$is_received = function_exists('is_order_received_page') && is_order_received_page();

		if (!$is_checkout || $is_received) {
			return;
		}

		if (sly_fg_has_wc_session() && !WC()->session->get('sly_fg_started')) {
			WC()->session->set('sly_fg_started', time());
		}
	}
	add_action('wp', 'sly_fg_mark_checkout_start');
}

if (!function_exists('sly_fg_render_honeypot')) {
	function sly_fg_render_honeypot() {
		echo '<div style="position:absolute;left:-9999px;opacity:0;pointer-events:none;" aria-hidden="true">';
		echo '<label for="sly_fg_website">Website</label>';
		echo '<input type="text" id="sly_fg_website" name="sly_fg_website" value="" tabindex="-1" autocomplete="off" />';
		echo '</div>';
	}
	add_action('woocommerce_after_order_notes', 'sly_fg_render_honeypot');
}

if (!function_exists('sly_fg_checkout_process')) {
	function sly_fg_checkout_process() {
		if (!class_exists('WooCommerce')) {
			return;
		}

		$settings = sly_fg_settings();
		$posted   = isset($_POST) ? wp_unslash($_POST) : array();
		$ip       = sly_fg_get_ip();
		$email    = isset($posted['billing_email']) ? sanitize_email((string) $posted['billing_email']) : '';
		$ua       = sly_fg_get_ua();

		// Honeypot
		if (!empty($posted['sly_fg_website'])) {
			wc_add_notice(__('Checkout validation failed. Please refresh and try again.', 'sly-fraud-guard'), 'error');
			return;
		}

		// Bad user agent (bots, headless browsers)
		if (sly_fg_is_bad_ua($ua)) {
			wc_add_notice(__('Checkout validation failed. Please refresh and try again.', 'sly-fraud-guard'), 'error');
			return;
		}

		// Minimum time on checkout — guards against automated submissions.
		// If session has no start time (race condition on fresh sessions), set it now
		// and allow through rather than blocking the customer with "please refresh".
		$started_at = sly_fg_has_wc_session() ? (int) WC()->session->get('sly_fg_started') : 0;
		if ($started_at <= 0) {
			// Session didn't persist the start time — set it back-dated so the
			// time check passes. The honeypot + UA checks above already ran.
			if (sly_fg_has_wc_session()) {
				WC()->session->set('sly_fg_started', time() - $settings['min_checkout_seconds']);
			}
			$started_at = time() - $settings['min_checkout_seconds'];
		}

		if ((time() - $started_at) < (int) $settings['min_checkout_seconds']) {
			wc_add_notice(__('Please review your details and submit checkout again.', 'sly-fraud-guard'), 'error');
			return;
		}

		// Disposable email
		if (sly_fg_is_disposable_email($email)) {
			wc_add_notice(__('Please use a permanent email address for your order.', 'sly-fraud-guard'), 'error');
			return;
		}

		// Rate limiting — only counted AFTER all early-exit checks above.
		// This prevents timer retries and WooCommerce validation failures from
		// eating rate-limit tokens and locking out legitimate customers.
		$ip_attempts = sly_fg_bump_counter(sly_fg_key('sly_fg_ip_', $ip), $settings['rate_window_seconds']);
		if ($ip_attempts > (int) $settings['ip_attempt_limit']) {
			wc_add_notice(__('Too many checkout attempts. Please wait 10 minutes and try again.', 'sly-fraud-guard'), 'error');
			return;
		}

		$email_attempts = 0;
		if ($email !== '') {
			$email_attempts = sly_fg_bump_counter(sly_fg_key('sly_fg_email_', $email), $settings['rate_window_seconds']);
			if ($email_attempts > (int) $settings['email_attempt_limit']) {
				wc_add_notice(__('Too many attempts for this email. Please wait 10 minutes and try again.', 'sly-fraud-guard'), 'error');
				return;
			}
		}

		$ip_unique_email_count = 0;
		if ($ip !== '' && $email !== '') {
			$pair_key    = sly_fg_key('sly_fg_pair_', $ip . '|' . $email);
			$unique_key  = sly_fg_key('sly_fg_unique_', $ip);
			$pair_exists = (int) get_transient($pair_key);

			if ($pair_exists <= 0) {
				set_transient($pair_key, 1, (int) $settings['rate_window_seconds']);
				$ip_unique_email_count = sly_fg_bump_counter($unique_key, $settings['rate_window_seconds']);
			} else {
				$ip_unique_email_count = (int) get_transient($unique_key);
			}

			if ($ip_unique_email_count > (int) $settings['ip_unique_email_limit']) {
				wc_add_notice(__('Too many checkout attempts. Please wait 10 minutes and try again.', 'sly-fraud-guard'), 'error');
				return;
			}
		}

		$cart_total = 0.0;
		if (function_exists('WC') && WC()->cart) {
			$cart_total = sly_fg_amount(WC()->cart->get_total('edit'));
		}

		list($score, $reasons) = sly_fg_score($posted, $cart_total, $ip_attempts, $email_attempts, $ip_unique_email_count);

		if ((int) $score >= (int) $settings['block_score']) {
			wc_add_notice(__('We could not verify this checkout. Please contact support to complete your order.', 'sly-fraud-guard'), 'error');
			return;
		}

		if (sly_fg_has_wc_session()) {
			WC()->session->set('sly_fg_ip_attempts', $ip_attempts);
			WC()->session->set('sly_fg_email_attempts', $email_attempts);
			WC()->session->set('sly_fg_ip_unique_emails', $ip_unique_email_count);
			WC()->session->set('sly_fg_score', (int) $score);
			WC()->session->set('sly_fg_reasons', implode('|', $reasons));
		}
	}
	add_action('woocommerce_checkout_process', 'sly_fg_checkout_process');
}

if (!function_exists('sly_fg_attach_order_meta')) {
	function sly_fg_attach_order_meta($order, $posted) {
		if (!$order instanceof WC_Order) {
			return;
		}

		$settings = sly_fg_settings();
		$ip       = sly_fg_get_ip();
		$ua       = sly_fg_get_ua();

		$ip_attempts = sly_fg_has_wc_session() ? (int) WC()->session->get('sly_fg_ip_attempts') : 0;
		$email_attempts = sly_fg_has_wc_session() ? (int) WC()->session->get('sly_fg_email_attempts') : 0;
		$ip_unique_email_count = sly_fg_has_wc_session() ? (int) WC()->session->get('sly_fg_ip_unique_emails') : 0;

		$cart_total = (float) $order->get_total();
		list($score, $reasons) = sly_fg_score($posted, $cart_total, $ip_attempts, $email_attempts, $ip_unique_email_count);

		if (sly_fg_has_wc_session()) {
			$session_score = (int) WC()->session->get('sly_fg_score');
			$session_reasons = (string) WC()->session->get('sly_fg_reasons');

			if ($session_score > 0) {
				$score = $session_score;
			}

			if ($session_reasons !== '') {
				$reasons = explode('|', $session_reasons);
			}
		}

		$order->update_meta_data('_sly_client_ip', $ip);
		$order->update_meta_data('_sly_client_ua', $ua);
		$order->update_meta_data('_sly_fraud_score', (int) $score);
		$order->update_meta_data('_sly_fraud_reasons', implode('|', $reasons));
		$order->update_meta_data('_sly_ip_unique_email_count', (int) $ip_unique_email_count);

		if ((int) $score >= (int) $settings['review_score']) {
			$order->update_meta_data('_sly_fraud_review', 'yes');
		}
	}
	add_action('woocommerce_checkout_create_order', 'sly_fg_attach_order_meta', 10, 2);
}

if (!function_exists('sly_fg_force_on_hold')) {
	function sly_fg_force_on_hold($status, $order_id, $order) {
		if ($order instanceof WC_Order && $order->get_meta('_sly_fraud_review', true) === 'yes') {
			return 'on-hold';
		}

		return $status;
	}
	add_filter('woocommerce_payment_complete_order_status', 'sly_fg_force_on_hold', 10, 3);
}

if (!function_exists('sly_fg_add_flag_note')) {
	function sly_fg_add_flag_note($order_id) {
		$order = wc_get_order($order_id);
		if (!$order instanceof WC_Order) {
			return;
		}

		if ($order->get_meta('_sly_fraud_review', true) !== 'yes') {
			return;
		}

		$score   = (int) $order->get_meta('_sly_fraud_score', true);
		$reasons = (string) $order->get_meta('_sly_fraud_reasons', true);

		$order->add_order_note(
			sprintf(
				'SLY Fraud Guard: flagged for manual review (score: %d, reasons: %s).',
				$score,
				$reasons !== '' ? $reasons : 'none'
			)
		);
	}
	add_action('woocommerce_checkout_order_processed', 'sly_fg_add_flag_note', 20, 1);
}

if (!function_exists('sly_fg_clear_on_success')) {
	function sly_fg_clear_on_success($order_id) {
		$order = wc_get_order($order_id);
		if (!$order instanceof WC_Order) {
			return;
		}

		$ip    = (string) $order->get_meta('_sly_client_ip', true);
		$email = (string) $order->get_billing_email();

		if ($ip !== '') {
			delete_transient(sly_fg_key('sly_fg_ip_', $ip));
			delete_transient(sly_fg_key('sly_fg_unique_', $ip));
		}

		if ($email !== '') {
			delete_transient(sly_fg_key('sly_fg_email_', $email));
			if ($ip !== '') {
				delete_transient(sly_fg_key('sly_fg_pair_', $ip . '|' . $email));
			}
		}
	}
	add_action('woocommerce_payment_complete', 'sly_fg_clear_on_success');
}
