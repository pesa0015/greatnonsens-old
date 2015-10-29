<?php

function getGroupMembers($group_id) {
	$members = sqlSelect("SELECT users.user_id, users.username FROM users INNER JOIN `group_members` ON users.user_id = group_members.user_id WHERE group_members.group_id = {$group_id} AND group_members.status = 1;");

	return $members;
}

?>