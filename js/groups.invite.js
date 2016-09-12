// $.getScript('js/select2-only-members.js');
$('#select2_family').select2({
      minimumInputLength: 1,
      tags: true,
      ajax: {
       url: 'form/search.php',
       type: 'POST',
       dataType: 'json',
       minimumInputLength: 1,
       data: function (writers) {
           return {
             writers: writers,
             hideGroupMembers: true,
             groupId: getGroupId()
           };
       },
       results: function (data) {
                var myResults = [];
                $.each(data, function (index, item) {
                    myResults.push({
                        'id': item.user_id,
                        'text': item.username
                    });
                });
                return {
                    results: myResults
                };
            }
      }
    });
function invitationsSent(response, data) {
	console.log(response);
	var result = JSON.parse(response);
	if (result.success) {
		$('#success').fadeIn(500).css('display', 'inline-block');
	}
}
function inviteGroupMembers(e) {
	e.preventDefault();
	var members = document.getElementById('select2_family');
	sendXhttp(invitationsSent, 'form/post/group/invite_members', 'group_id=' + getGroupId() + '&group_members=' + members.value, null);
}