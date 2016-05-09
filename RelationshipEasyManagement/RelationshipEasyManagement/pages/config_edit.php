<?php

auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$help_url = gpc_get_string( 'search_limit');

plugin_config_set( 'search_limit' , $help_url );

print_successful_redirect( plugin_page( 'config', true ) );

