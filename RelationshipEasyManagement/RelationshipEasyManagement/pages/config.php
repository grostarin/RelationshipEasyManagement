<?php

auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

html_page_top1( plugin_lang_get( 'title' ) );
html_page_top2();

print_manage_menu();

?>

<br/>
<form action="<?php echo plugin_page( 'config_edit' ) ?>" method="post">
<table align="center" class="width50" cellspacing="1">
	<tr>
		<td class="form-title" colspan="2">
			<?php echo plugin_lang_get( 'config_title' ) ?>
		</td>
	</tr>

	<tr <?php echo helper_alternate_class() ?>>
		<td class="category" width="30%">
			<?php
				echo plugin_lang_get( 'search_limit' );
			?>
		</td>
		<td width="70%">
			<input type="text" name="help_url" size="2" maxlength="2" value="<?php echo plugin_config_get("search_limit"); ?>" />
		</td>
	</tr>

	<tr>
		<td class="center" colspan="2">
			<input type="submit" class="button" value="<?php echo lang_get( 'change_configuration' ) ?>" />
		</td>
	</tr>
</table>
<form>

<?php
html_page_bottom1( __FILE__ );