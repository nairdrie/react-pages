<?php
/*
Plugin Name: React Pages
Description: Embeds React apps via [rp_fraud_detection] and [rp_financial_forecasting] shortcodes, or via full-page template takeover.
Version: 1.2
Author: Nick A.
*/

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. TEMPLATE INTERCEPTION
 * Checks the current URL. If it matches one of our apps, it loads the blank
 * 'app-canvas.php' template instead of the WordPress Theme.
 */
function rp_load_app_template( $template ) {
    // Check if we are on the specific page SLUG for App 1
    if ( is_page( 'fraud-detection' ) ) {
        $new_template = plugin_dir_path( __FILE__ ) . 'templates/app-canvas.php';
        if ( file_exists( $new_template ) ) {
            return $new_template;
        }
    }
    
    // Check if we are on the specific page SLUG for App 2
    if ( is_page( 'financial-forecasting' ) ) {
        $new_template = plugin_dir_path( __FILE__ ) . 'templates/app-canvas.php';
        if ( file_exists( $new_template ) ) {
            return $new_template;
        }
    }

    // Otherwise, return the normal Theme template
    return $template;
}
add_filter( 'template_include', 'rp_load_app_template' );


/**
 * 2. SCRIPT REGISTRATION & ENQUEUEING
 * Registers all scripts, then conditionally loads them based on the page slug
 * OR via the shortcode functions below.
 */
function rp_enqueue_scripts() {
    $plugin_url = plugin_dir_url( __FILE__ );

    // --- REGISTER APP 1: fraud-detection ---
    wp_register_script(
        'fd-js',
        $plugin_url . 'fraud-detection/dist/assets/app.js', 
        array(), 
        '1.0', 
        true
    );
    wp_register_style(
        'fd-css',
        $plugin_url . 'fraud-detection/dist/assets/main.css', 
        array(), 
        '1.0'
    );

    // --- REGISTER APP 2: financial-forecasting ---
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

    // --- CONDITIONAL LOADING & NUCLEAR CLEANUP ---
    $is_app_page = is_page( 'fraud-detection' ) || is_page( 'financial-forecasting' );

    if ( $is_app_page ) {
        
        // 1. ENQUEUE YOUR APPS
        if ( is_page( 'fraud-detection' ) ) {
            wp_enqueue_script( 'fd-js' );
            wp_enqueue_style( 'fd-css' );
        }
        if ( is_page( 'financial-forecasting' ) ) {
            wp_enqueue_script( 'ff-js' );
            wp_enqueue_style( 'ff-css' );
        }

        // 2. THE CLEANUP (Remove WP Bloat)
        // Standard WP Blocks
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
        wp_dequeue_style( 'wc-blocks-style' );
        wp_dequeue_style( 'global-styles' );
        
        // TARGETED FIX: Remove "Extend Builder" CSS
        // The ID "extend-builder-css-inline-css" implies the handle is "extend-builder-css"
        wp_dequeue_style( 'extend-builder-css' );
        wp_dequeue_style( 'extend-builder' ); // Try both variations just in case

        // DEBUGGER: Add ?debug_styles=true to your URL to see list of handles to remove
        if ( isset( $_GET['debug_styles'] ) && current_user_can( 'administrator' ) ) {
            global $wp_styles;
            echo '<div style="background:white; padding:20px; border:2px solid red; position:fixed; top:0; left:0; z-index:99999; width:100%; height:300px; overflow:scroll;">';
            echo '<h3>Active CSS Handles (Add these names to wp_dequeue_style)</h3>';
            echo '<ul>';
            foreach ( $wp_styles->queue as $handle ) {
                echo '<li><strong>' . esc_html( $handle ) . '</strong></li>';
            }
            echo '</ul>';
            echo '</div>';
        }
    }
}
// Priority 100 ensures this runs LAST, after the theme has enqueued its styles
add_action( 'wp_enqueue_scripts', 'rp_enqueue_scripts', 100 );


/**
 * 3. SHORTCODE DEFINITIONS
 * Allows embedding the apps into standard WordPress pages/posts.
 */

// SHORTCODE 1: [rp_fraud_detection]
function fraudDetection_shortcode() {
    wp_enqueue_script( 'fd-js' );
    wp_enqueue_style( 'fd-css' );
    return '<div id="FraudDetectionRoot"></div>';
}
add_shortcode( 'rp_fraud_detection', 'fraudDetection_shortcode' );

// SHORTCODE 2: [rp_financial_forecasting]
function financialForecasting_shortcode() {
    wp_enqueue_script( 'ff-js' );
    wp_enqueue_style( 'ff-css' );
    return '<div id="FinancialForecastingRoot"></div>';
}
add_shortcode( 'rp_financial_forecasting', 'financialForecasting_shortcode' );