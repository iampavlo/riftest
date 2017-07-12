<?php

function riffchart_load_admin_scripts() {
    wp_register_style( 'riffchart_admin', plugin_dir_url(__FILE__) . '../css/riffchart.admin.css', array(), '1.0.0', 'all');
    wp_enqueue_style( 'riffchart_admin');

    wp_enqueue_script( 'riffchart_admin', plugin_dir_url(__FILE__) . '../js/riffchart.admin.js', array( 'jquery' ), NULL, true);
    wp_localize_script( 'riffchart_admin', 'riff_vars_26', array(
        'ajaxurl' => admin_url( 'admin-ajax.php')
    ));
    
    wp_register_script( 'google-chart-loader', 'https://www.gstatic.com/charts/loader.js', array(), '1.0.0', true);
    wp_enqueue_script( 'google-chart-loader');

    wp_enqueue_script( 'riffchart-chart', plugin_dir_url(__FILE__) . '../js/riffchart.chart.js', array( 'jquery' ), NULL, true );
    wp_localize_script( 'riffchart-chart', 'riff_vars_25', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));
}

add_action('admin_enqueue_scripts', 'riffchart_load_admin_scripts');

function riffchart_load_scripts() {
    wp_register_script( 'google-chart-loader', 'https://www.gstatic.com/charts/loader.js', array(), '1.0.0', true );
    wp_enqueue_script( 'google-chart-loader' );
    wp_enqueue_script( 'riffchart-chart', plugin_dir_url(__FILE__) . '../js/riffchart.chart.js', array( 'jquery' ), NULL, true );
    wp_localize_script( 'riffchart-chart', 'riff_vars_25', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));
}

add_action( 'wp_enqueue_scripts', 'riffchart_load_scripts' );
