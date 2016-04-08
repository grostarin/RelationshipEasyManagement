<?php
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$help_url = gpc_get_string( 'help_url');

plugin_config_set( 'help_url' , $help_url );

print_successful_redirect( plugin_page( 'config', true ) );

