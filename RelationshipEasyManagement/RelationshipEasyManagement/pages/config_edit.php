<?php
# Copyright (c) 2012 Jacky Alcine <jacky.alcine@thesii.org>

# jQuery UI plugin for MantisBT is free software: 
# you can redistribute it and/or modify it under the terms of the GNU
# General Public License as published by the Free Software Foundation, 
# either version 2 of the License, or (at your option) any later version.
#
# jQuery UI plugin for MantisBT is distributed in the hope 
# that it will be useful, but WITHOUT ANY WARRANTY; without even the 
# implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
# See the GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with jQuery UI plugin for MantisBT.  
# If not, see <http://www.gnu.org/licenses/>.

auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$help_url = gpc_get_string( 'help_url');

plugin_config_set( 'help_url' , $help_url );

print_successful_redirect( plugin_page( 'config', true ) );

