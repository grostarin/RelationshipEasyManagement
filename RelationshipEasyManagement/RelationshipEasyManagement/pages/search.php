<?php

# include Mantis files
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . DIRECTORY_SEPARATOR . 'core.php' );

// Search
$t_search_text = '%'.gpc_get_string( 'relationship_easy_management_search_field', "" ).'%';
$t_bug_table = db_get_table( 'mantis_bug_table' );
$t_bug_text_table = db_get_table( 'mantis_bug_text_table' );
$t_limit = plugin_config_get( 'search_limit' );
$query = "SELECT bt.* FROM ". $t_bug_table." bt inner join ". $t_bug_text_table ." btt on btt.id = bt.id
	WHERE
		bt.id like ". db_param() ."
		or bt.summary like ". db_param() ."
		or btt.description like ". db_param() ."
	ORDER BY bt.id DESC
	";

$result = db_query_bound( $query , Array($t_search_text,$t_search_text,$t_search_text), $t_limit );
$count = db_num_rows ( $result );

// affichage d'un message "pas de résultats"
if( $count == 0 ) {
?>	
    <h4 style="text-align:center; margin:10px 0;"><?php echo plugin_lang_get("no_search_result") ?></h4>
<?php
}
else {
    // parcours et affichage des résultats	
	?>
<table>
	<?php
	for($i = 0; $i < $count; $i ++) {
		$row = db_fetch_array ( $result );
		extract ( $row, EXTR_PREFIX_ALL, 'u' );
		if (access_has_bug_level ( VIEWER, $u_id )) {
			$t_td = "";
			$t_project_name = project_get_name ( $u_project_id );
			$t_status_string = get_enum_element ( 'status', $u_status, auth_get_current_user_id (), $u_project_id );
			$t_bg_color = get_status_color ( $u_status, null, $u_project_id );
			$t_td .= '<td><div class="relationship_easy_management_copy_id_button" id="'.$u_id.'"></div></td>';
			$t_td .= '<td width="10%" bgcolor="'.$t_bg_color.'" <a href="' . string_get_bug_view_url( $u_id ) . '">' . string_display_line( bug_format_id( $u_id ) ) . '</a></td>';
			$t_resolution_string = get_enum_element( 'resolution', $u_resolution, auth_get_current_user_id(), $u_project_id );
			$t_td .= '<td width="20%" bgcolor="'.$t_bg_color.'"><span class="issue-status" title="' . string_attribute( $t_resolution_string ) . '">' . string_display_line( $t_status_string ) . '</span></td>';				
			$t_td .= '<td width="20%" bgcolor="'.$t_bg_color.'">';
			if ($u_handler_id > 0) {
				$t_td .= string_no_break ( prepare_user_name ( $u_handler_id ) );
			}
			$t_td .= '&#160;</td>';
			$t_td .= '<td width="20%" bgcolor="'.$t_bg_color.'">'. string_display_line ( $u_project_name ) . '&#160;</td>';
			$t_td .= '<td width="30%" bgcolor="'.$t_bg_color.'">' . string_display_line_links ( $u_summary );
			if (VS_PRIVATE == $t_bug->view_state) {
				$t_td .= sprintf ( ' <img src="%s" alt="(%s)" title="%s" />', $t_icon_path . 'protected.gif', lang_get ( 'private' ), lang_get ( 'private' ) );
			}
			$t_td .= '&#160;</td>';
			$t_td .= "\n";
		}
		?>
	<tr>
		<?php echo $t_td; ?>
	</tr>
<?php } ?>
</table>
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