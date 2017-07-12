<?php

function riffchart_add_admin_page() {
    // Definitions of dashboard menu 
    add_menu_page( 'Riff Chart Settings', 'Riff Chart', 'manage_options', 'riffchart_show', 'riffchart_chart_template', 'dashicons-awards', 58 );
    add_submenu_page( 'riffchart_show', __( 'Chart' , 'riffchart' ), __( 'View Charts' , 'riffchart' ), 'manage_options', 'riffchart_show', 'riffchart_chart_template' );
    add_submenu_page( 'riffchart_show', __( 'RiffChart Options' , 'riffchart' ), __( 'Settings' , 'riffchart' ), 'manage_options', 'riffchart-options-group', 'riffchart_template' );
    

    add_action( 'admin_init', 'riffchart_custom_settings' );
}

//add_options_page
add_action( 'admin_menu', 'riffchart_add_admin_page' );

function riffchart_chart_template() {
    require_once( __DIR__ . '/templates/riffchart-chart-template.php' );
}

function riffchart_template() {
    require_once( __DIR__ . '/templates/riffchart-admin-template.php' );
}

function riffchart_custom_settings() {
    register_setting( 'riffchart-options-group', 'riffchart_local_remote' );
    register_setting( 'riffchart-options-group', 'riffchart_remote_host' );
    register_setting( 'riffchart-options-group', 'riffchart_remote_database' );
    register_setting( 'riffchart-options-group', 'riffchart_remote_user' );
    register_setting( 'riffchart-options-group', 'riffchart_remote_password' );

}


