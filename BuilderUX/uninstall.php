<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ){ 
    exit();
}

global $wpdb;
$option_name = 'BuilderUX_database_version';
delete_option( $option_name );

//$table_name = $wpdb->prefix ."rico";
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}BuilderUX" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}BuilderUXdata" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}builder_lead_settings" );
?>