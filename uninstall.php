<?php

if( !defined('WP_UNINSTALL_PLUGIN') ) exit;

global $wpdb;

$query = "DROP TABLE ".$wpdb->prefix ."es_bcard";
$wpdb->query($wpdb->prepare($query,array()));

$query = "DROP TABLE ".$wpdb->prefix ."es_category";
$wpdb->query($wpdb->prepare($query,array()));
