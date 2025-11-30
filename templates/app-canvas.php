<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
    
    <style>
        html, body { margin: 0; padding: 0; height: 100%; width: 100%; }
        #FraudDetectionRoot, #FinancialForecastingRoot { height: 100%; width: 100%; }
    </style>
</head>
<body <?php body_class(); ?>>

    <?php 
    if ( is_page( 'fraud-detection' ) ) {
        echo '<div id="FraudDetectionRoot"></div>';
    } elseif ( is_page( 'financial-forecasting' ) ) {
        echo '<div id="FinancialForecastingRoot"></div>';
    }
    ?>
    <?php wp_footer(); ?>
</body>
</html>