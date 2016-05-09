<?php

# include Mantis files
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . DIRECTORY_SEPARATOR . 'core.php' );

// Search
$t_page_number = 1;
$t_page_limit = plugin_config_get( 'search_limit' );
$t_bug_count = null;
$t_page_count = null;
$t_filter = filter_get_default();
$t_filter['_view_type']='advanced';
$t_filter[FILTER_PROPERTY_FREE_TEXT] = gpc_get_string( 'relationship_easy_management_search_field', "" );
$t_filter[FILTER_PROPERTY_PROJECT_ID] = array('0'=>ALL_PROJECTS);
$rows = filter_get_bug_rows( $t_page_number, $t_page_limit, $t_page_count, $t_bug_count, $t_filter);

$count = count( $rows );

// display message : no result
if( $count == 0 ) {
?>	
    <h4 style="text-align:center; margin:10px 0;"><?php echo plugin_lang_get("no_search_result") ?></h4>
<?php
}
else {
    // display results
	?>
<table>
	<?php
	for($i = 0; $i < $count; $i ++) {
		$row = $rows[$i];
		$t_td = "";
		$t_status_string = get_enum_element ( 'status', $row->status, auth_get_current_user_id (), $row->project_id );
		$t_bg_color = get_status_color ( $row->status, null, $row->project_id );
		$t_td .= '<td><div class="relationship_easy_management_copy_id_button" id="'.$row->id.'"></div></td>';
		$t_td .= '<td width="10%" bgcolor="'.$t_bg_color.'" <a href="' . string_get_bug_view_url( $row->id ) . '">' . string_display_line( bug_format_id( $row->id ) ) . '</a></td>';
		$t_resolution_string = get_enum_element( 'resolution', $row->resolution, auth_get_current_user_id(), $row->project_id );
		$t_td .= '<td width="20%" bgcolor="'.$t_bg_color.'"><span class="issue-status" title="' . string_attribute( $t_resolution_string ) . '">' . string_display_line( $t_status_string ) . '</span></td>';
		$t_td .= '<td width="20%" bgcolor="'.$t_bg_color.'">';
		if ($row->handler_id > 0) {
			$t_td .= string_no_break ( prepare_user_name ( $row->handler_id ) );
		}
		$t_td .= '&#160;</td>';
		$t_td .= '<td width="20%" bgcolor="'.$t_bg_color.'">'. string_display_line ( $row->project_name ) . '&#160;</td>';
		$t_td .= '<td width="30%" bgcolor="'.$t_bg_color.'">' . string_display_line_links ( $row->summary );
		if (VS_PRIVATE == $t_bug->view_state) {
			$t_td .= sprintf ( ' <img src="%s" alt="(%s)" title="%s" />', $t_icon_path . 'protected.gif', lang_get ( 'private' ), lang_get ( 'private' ) );
		}
		$t_td .= '&#160;</td>';
		$t_td .= "\n";
		?>
	<tr>
		<?php echo $t_td; ?>
	</tr>
<?php } ?>
</table>
<?php if($t_bug_count > $count) {?>
	<h4 style="text-align:center; margin:10px 0;"><?php echo sprintf( plugin_lang_get("not_displayed_result"), $t_bug_count - $count, $t_page_limit ) ?></h4>
<?php }?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$( ".relationship_easy_management_copy_id_button" ).click(function(){	
		$('input[name="dest_bug_id"]').val($(this).prop('id'));
		$('form[id="add_relationship_form"]').submit();
	});
});
</script>
<?php
}