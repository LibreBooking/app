<?php
function print_groups_to_add($groups) {
	echo '<td style="text-align:center;">' . "\n";
	echo '<p>' . translate('All Groups') . '</p>';
	echo '<select name="remove_groups[]" id="remove_groups" class="textbox" multiple="multiple" size="10" style="width:195px;">' . "\n";
	for ($i = 0; $i < count($groups); $i++) {
		echo "<option value=\"{$groups[$i]['groupid']}\">{$groups[$i]['group_name']}</option>\n";
	}
	echo '</select>' . "\n";
	echo '</td>' . "\n";
}

function print_groups_to_remove($groups) {
	echo '<td style="text-align:center;">' . "\n";
	echo '<p>' . translate('Current Groups') . '</p>';
	echo '<select name="add_groups[]" id="add_groups" class="textbox" multiple="multiple" size="10" style="width:195px;">' . "\n";
	foreach ($groups as $groupid => $data) {
		echo "<option value=\"$groupid\">{$data['group_name']}</option>\n";
	}
	echo '</select>' . "\n";
	echo '</td>' . "\n";
}

function print_move_buttons() {
	echo '<td style="text-align:center;">' . "\n";
	echo '<button type="button" name="add" id="add" class="button" onclick="javascript:moveSelectItems(\'remove_groups\', \'add_groups\');">&raquo;&raquo;</button>';
	echo '<br/><br/>' . "\n";
	echo '<button type="button" name="remove" id="remove" class="button" onclick="javascript:moveSelectItems(\'add_groups\',\'remove_groups\');">&laquo;&laquo;</button>';
	echo '</td>' . "\n";
}

function print_groups_to_view($groups) {
	echo '<td style="text-align:center;">' . "\n";
	echo '<table width="100%" border="0" cellpadding="0" celspacing="0">' . "\n";
	foreach ($groups as $groupid => $data) {
		echo "<tr><td align=\"left\">{$data['group_name']}</td></tr>\n";
	}
	echo '</table>' . "\n";
	echo '</td>' . "\n";
}

function begin_table($name) {
	echo '<form name="manage_groups" id="manage_groups" method="post" action="' . $_SERVER['PHP_SELF'] . '">' . "\n"
		. '<table width="100%" border="0" cellspacing="0" cellpadding"0"><tr><td colspan="3"><h5 align="center">' . $name . '</h5></td></tr><tr>';
}

function end_table() {
	echo '</table></form>';
}

function print_save_button($id) {
	echo '</tr><tr><td colspan="3" style="text-align:right;">'
		. '<input type="hidden" name="memberid" id="memberid" value="' . $id . '"/>'
		. '<input type="submit" class="button" name="submit" id="submit" value="' . translate('Save') . '" onclick="javascript:selectAllOptions(this);"/></td></tr>';
}

function close_window() {
	echo '<script language="JavaScript" type="text/javascript">window.close();</script>';
}
?>