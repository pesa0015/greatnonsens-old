function admin(response, data) {
	var result = JSON.parse(response);
	if (result.success)
		document.getElementById('member-' + data.memberId).checked = result.check;
}
function manageAdmin(id) {
	var groupMemberId = parseInt(id.getAttribute('data-member'));
	sendXhttp(admin, 'form/post/group/manage_admin', 'group=' + getGroupId() + '&memberId=' + groupMemberId, {memberId: groupMemberId});
}
function memberRemoved(response, data) {
	var result = JSON.parse(response);
	if (result.success)
		$('#block-' + data.memberId).fadeOut();
}
function removeMember(id) {
	var groupMemberId = parseInt(id.getAttribute('data-member'));
	sendXhttp(memberRemoved, 'form/post/group/remove_member', 'group=' + getGroupId() + '&memberId=' + groupMemberId, {memberId: groupMemberId});
}
function memberManaged(response, data) {
	console.log(response);
	var result = JSON.parse(response);
	if (result.success) {
		data.element.onclick = function() { return false; }
		switch (data.callback) {
			case 'accept':
				data.element.innerHTML = 'Accepterad';
				$(data.element).prev().remove();
				break;
			case 'decline':
				data.element.innerHTML = 'Förfrågan nekad';
				$(data.element).next().remove();
				break;
			case 'remove_invite':
				data.element.innerHTML = 'Inbjudan stoppad';
				break;
		}
	}
}
function manageMember(action, memberId, rowId, el) {
	sendXhttp(memberManaged, 'form/post/group/manage_request', 'action=' + action + '&group=' + getGroupId() + '&memberId=' + memberId + '&rowId=' + rowId, {callback: action, element: el});
}