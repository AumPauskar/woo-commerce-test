<?php
/**
 * Plugin Name: WooCommerce Flask Pinger
 * Description: Pings a Flask server when an order is placed.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Function to ping Flask server
function ping_flask_server() {
    $url = 'http://127.0.0.1:2100/notify';
    wp_remote_get($url);
    print("pinged");
}

// Hook into WooCommerce order completion
add_action('woocommerce_new_order', 'ping_flask_server');
