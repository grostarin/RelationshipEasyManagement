jQuery(document).ready(function($) {
	$('input[name="dest_bug_id"]').attr('placeholder',relationship_easy_management_bug_id);	
	var mantis_button = $('input[name="add_relationship"]');
	mantis_button.parent().prop("id","add_relationship_form");
	mantis_button.parent().append('<div id="relationship_easy_management_div"><table>'+
			'<tr><td>'+relationship_easy_management_bug_id_label+'</td><td id="dest_bug_id_destination"></td></tr>'+
			'<tr id="relationship_easy_management_new_bug_tr"><td>'+relationship_easy_management_new_bug_label+'</td><td><div id="relationship_easy_management_new_bug_button"></div></td></tr>'+
			'<tr><td>'+relationship_easy_management_search_bug_label+'</td><td><input type="text" name="relationship_easy_management_search_field" id="relationship_easy_management_search_field" placeholder="'+relationship_easy_management_find_bug+'"/><div id="relationship_easy_management_ajax_loader"></div></td></tr>'+
			'</table></div>'+
			'<div id="relationship_easy_management_search_result"></div>');
	$('input[name="dest_bug_id"]').detach().appendTo($('td[id="dest_bug_id_destination"]'));
	mantis_button.detach().appendTo($('td[id="dest_bug_id_destination"]'));	
	
	timer = 0;
	relationship_easy_management_ajax_loader = $('div[id="relationship_easy_management_ajax_loader"]');
	relationship_easy_management_ajax_loader.hide();
	
	search_field = $('input[id="relationship_easy_management_search_field"]');
	relationship_easy_management_search_result = $('div[id="relationship_easy_management_search_result"]');
	
	$('#relationship_easy_management_search_field').keyup(function(){	
	    if (timer) {
	        clearTimeout(timer);
	    }

	    // Show loader
		relationship_easy_management_ajax_loader.show();
		relationship_easy_management_search_result.slideUp("fast");
		
		// Ajax CALL
	    timer = setTimeout(mySearch, 400); 
	});
	
	$('tr[id="relationship_easy_management_new_bug_tr"]').click(function(){
		$('form[id="add_relationship_form"]').attr("action","plugin.php?page=RelationshipEasyManagement/bug_report_page.php");
		$('form[id="add_relationship_form"]').submit();
	});
	
	function mySearch(){
		search_field = $('input[id="relationship_easy_management_search_field"]');
		search_field_value = $.trim(search_field.val());
		if(search_field_value!='') {
			// Send data
			$.ajax({
				type : 'GET',
				url : 'plugin.php?page=RelationshipEasyManagement/search.php' ,
				data : 'relationship_easy_management_search_field='+search_field_value ,
				success : function(data){
					relationship_easy_management_search_result = $('div[id="relationship_easy_management_search_result"]');
					relationship_easy_management_search_result.html(data);
					relationship_easy_management_search_result.slideDown("fast");
				},
				error : function(data){
					relationship_easy_management_search_result = $('div[id="relationship_easy_management_search_result"]');
					relationship_easy_management_search_result.html("ERROR");
					relationship_easy_management_search_result.slideDown("fast");
				},
				complete : function(data){
					relationship_easy_management_ajax_loader.hide();
				}
			});
		}else{
			relationship_easy_management_search_result.html('');
		}
		relationship_easy_management_ajax_loader.hide();
	}
});
