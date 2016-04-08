<?php
class RelationshipEasyManagementPlugin extends MantisPlugin {
	function register() {
        $this->name = plugin_lang_get("title");
        $this->description = plugin_lang_get("description");
		$this->page = 'config';

		$this->version = '0.1';
		$this->requires = array(
		'MantisCore' => '1.2.0',
		'jQuery' => '1.6'
		);

		$this->author = 'Julien SCHNEIDER';
		$this->contact = 'schneider.julien@gmail.com';
		$this->url = 'https://plus.google.com/u/0/+JulienSchneider';
	}
	
	function hooks() {
		plugin_event_hook( 'EVENT_VIEW_BUG_DETAILS', 'reportBugForm' );
		plugin_event_hook( 'EVENT_LAYOUT_RESOURCES', 'resources' );
	}
	
	function config() {
		return array(
				'search_limit'	=> 10
		);
	}
	
	function reportBugForm( $p_event, $p_project_id ) {		
		echo '<script type="text/javascript">
				var relationship_easy_management_find_bug = "'.plugin_lang_get('find_bug').'";
				var relationship_easy_management_bug_id = "'.plugin_lang_get('bug_id').'";
				var relationship_easy_management_bug_id_label = "'.plugin_lang_get('relationship_easy_management_bug_id').'";
				var relationship_easy_management_new_bug_label = "'.plugin_lang_get('relationship_easy_management_new_bug').'";
				var relationship_easy_management_search_bug_label = "'.plugin_lang_get('relationship_easy_management_search_bug').'";
				</script>';
		echo '<script type="text/javascript" src="'.plugin_file("relationship_easy_management.js").'"></script>';		
	}	

	function resources( $p_event ) {
		return '<link rel="stylesheet" type="text/css" href="'.plugin_file("relationship_easy_management.css").'"></link>';
	}
}