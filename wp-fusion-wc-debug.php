<?php

/*
Plugin Name: WP Fusion - WooCommerce Debug
Description: Enables detailed debug logging for WP Fusion and WooCommerce to troubleshoot checkout issues.
Plugin URI: https://wpfusion.com/
Version: 1.1
Author: Very Good Plugins
Author URI: https://verygoodplugins.com/
Text Domain: wp-fusion
*/

/**
 * @copyright Copyright (c) 2016. All rights reserved.
 *
 * @license   Released under the GPL license http://www.opensource.org/licenses/gpl-license.php
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
 *
 */

// deny direct access
if ( ! function_exists( 'add_action' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

// Subscription trial end

function wpf_wc_debug_trial_end( $subscription ) {

	$subscription_object = wcs_get_subscription( $subscription_id );
	wpf_log( 'info', 0, 'DEBUG: Trial end, priority 5, user ID: ' . $subscription_object->get_user_id() );

}

add_action( 'woocommerce_scheduled_subscription_trial_end', 'wpf_wc_debug_trial_end', 5 );

function wpf_wc_debug_trial_end_15( $subscription ) {

	$subscription_object = wcs_get_subscription( $subscription_id );
	wpf_log( 'info', 0, 'DEBUG: Trial end, priority 15, user ID: ' . $subscription_object->get_user_id() );

}

add_action( 'woocommerce_scheduled_subscription_trial_end', 'wpf_wc_debug_trial_end_15', 15 );

// IPN request

function wpf_wc_debug_ipn_request( $posted ) {
	wpf_log( 'info', 0, 'DEBUG: IPN request:', array( 'meta_array_nofilter' => $posted ) );
}

add_action( 'valid-paypal-standard-ipn-request', 'wpf_wc_debug_ipn_request' );

// Pre payment complete

function wpf_wc_debug_pre_payment_complete( $order_id ) {
	wpf_log( 'info', 0, 'DEBUG: Pre payment complete: ' . $order_id );
}

add_action( 'woocommerce_pre_payment_complete', 'wpf_wc_debug_pre_payment_complete' );

// Payment complete

function wpf_wc_debug_payment_complete( $order_id ) {
	wpf_log( 'info', 0, 'DEBUG: Payment complete: ' . $order_id );
}

add_action( 'woocommerce_payment_complete', 'wpf_wc_debug_payment_complete' );

function wpf_wc_debug_wpf_payment_complete( $order_id ) {
	wpf_log( 'info', 0, 'DEBUG: WPF payment complete: ' . $order_id );
}

add_action( 'wpf_woocommerce_payment_complete', 'wpf_wc_debug_wpf_payment_complete' );

// Processing, priority 1

function wpf_wc_debug_processing_1( $order_id ) {

	if ( wp_doing_ajax() ) {
		wpf_log( 'info', 0, 'DEBUG: Order status processing priority 1 / doing ajax: ' . $order_id );
	} else {
		wpf_log( 'info', 0, 'DEBUG: Order status processing priority 1 / NOT doing ajax: ' . $order_id );
	}

	if ( get_transient( 'wpf_woo_started_' . $order_id ) ) {
		wpf_log( 'notice', 0, 'DEBUG: IS STARTED ' . $order_id );
	} else {
		wpf_log( 'info', 0, 'DEBUG: Is not started ' . $order_id );
	}

	global $wp_filter;

	wpf_log( 'info', 0, 'DEBUG: Hooked actions for woocommerce_order_status_processing / ' . $order_id, array( 'meta_array_nofilter' => $wp_filter['woocommerce_order_status_processing'] ) );

}

add_action( 'woocommerce_order_status_processing', 'wpf_wc_debug_processing_1', 1 );

// Processing, priority 5

function wpf_wc_debug_processing_5( $order_id ) {
	wpf_log( 'info', 0, 'DEBUG: Order status processing priority 5: ' . $order_id );
}

add_action( 'woocommerce_order_status_processing', 'wpf_wc_debug_processing_5', 5 );

// Processing, priority 10

function wpf_wc_debug_processing_10( $order_id ) {
	wpf_log( 'info', 0, 'DEBUG: Order status processing priority 10: ' . $order_id );
}

add_action( 'woocommerce_order_status_processing', 'wpf_wc_debug_processing_10', 10 );

// Processing, priority 15

function wpf_wc_debug_processing_15( $order_id ) {
	wpf_log( 'info', 0, 'DEBUG: Order status processing priority 15: ' . $order_id );
}

add_action( 'woocommerce_order_status_processing', 'wpf_wc_debug_processing_15', 15 );

