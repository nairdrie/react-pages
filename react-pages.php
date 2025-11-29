<?php
/*
Plugin Name: React Pages
Description: Embeds React apps via [rp_fraud_detection] and [rp_financial_forecasting] shortcodes.
Version: 1.0
Author: Nick A.
*/

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function rp_enqueue_scripts() {
    $plugin_url = plugin_dir_url( __FILE__ );

    // --- APP 1: fraud-detection ---
    // Registers the script for the first app
    wp_register_script(
        'fd-js',
        $plugin_url . 'fraud-detection/dist/assets/app.js', // Make sure this matches your Vite output name
        array(),
        '1.0',
        true
    );
    wp_register_style(
        'fd-css',
        $plugin_url . 'fraud-detection/dist/assets/main.css', // Check build folder if it is app.css or main.css
        array(),
        '1.0'
    );

    // --- APP 2: financial-forecasting ---
    // Registers the script for the second app
    wp_register_script(
        'ff-js',
        $plugin_url . 'financial-forecasting/dist/assets/app.js',
        array(),
        '1.0',
        true
    );
    wp_register_style(
        'ff-css',
        $plugin_url . 'financial-forecasting/dist/assets/main.css',
        array(),
        '1.0'
    );
}
add_action( 'wp_enqueue_scripts', 'rp_enqueue_scripts' );

// ---------------------------------------------------------
// SHORTCODE 1: [rp_fraud_detection]
// ---------------------------------------------------------
function fraudDetection_shortcode() {
    // 1. Enqueue ONLY the Fraud Detection assets
    wp_enqueue_script( 'fd-js' );
    wp_enqueue_style( 'fd-css' );

    // 2. Output the specific DIV for the App (Matches ID in your React main.jsx)
    return '<div id="FraudDetectionRoot"></div>';
}
add_shortcode( 'rp_fraud_detection', 'fraudDetection_shortcode' );

// ---------------------------------------------------------
// SHORTCODE 2: [rp_financial_forecasting]
// ---------------------------------------------------------
function financialForecasting_shortcode() {
    // 1. Enqueue ONLY the Forecasting assets
    wp_enqueue_script( 'ff-js' );
    wp_enqueue_style( 'ff-css' );

    // 2. Output the specific DIV for the App (Matches ID in your React main.jsx)
    return '<div id="FinancialForecastingRoot"></div>';
}
add_shortcode( 'rp_financial_forecasting', 'financialForecasting_shortcode' );