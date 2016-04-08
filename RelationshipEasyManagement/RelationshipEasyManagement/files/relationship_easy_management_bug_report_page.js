jQuery(document).ready(function($) {
	$('#relationship_easy_management_new_bug_post_button').click(function(){
		category_id = $('select[name="category_id"]').val();
		rel_type = $('select[name="rel_type"]').val();
		project_id = $('select[name="project_id"]').val();
		summary = $('input[name="summary"]').val().trim();
		description = $('textarea[name="description"]').val().trim();		
		if(rel_type==-2 || category_id==0 || project_id==0 || summary=='' || description==''){
			alert(bug_report_mandatory_attribute_missing_alert);
			return;
		}
		$('form[name="relationship_easy_management_report_bug_form"]').submit();
	});
});