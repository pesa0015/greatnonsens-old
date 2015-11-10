$(window).load(function(){
	$('#writeModal').modal('show');

	$('#writeModal').on('hidden.bs.modal', function () {
    	window.history.back();
	});
});

$('#hide').css('display', 'none');

var stories = greatnonsens.child('stories/not_ready/');

stories.on('child_added', function(snapshot) {
	$('tbody').append('<tr id="' + snapshot.key() + '"><td id="' + snapshot.key() + '-title">' + snapshot.val().title + '</td><td id="' + snapshot.key() + '-opening_words">' + snapshot.val().opening_words + '</td><td>' + snapshot.val().nonsens_mode + '</td><td id="' + snapshot.key() + '-writers">' + snapshot.val().writers + '</td><td id="' + snapshot.key() + '-max_writers">' + snapshot.val().max_writers + '</td><td><a href="form/get/story/join?story=' + snapshot.key() + '" class="btn btn-success">Gå med</a></td></tr>');
});

stories.on('child_changed', function(childSnapshot, prevChildKey) {
	$('#' + childSnapshot.key() + '-writers').text(childSnapshot.val().writers);
	// console.log($('#' + childSnapshot.key()));
});

stories.on('child_removed', function(oldChildSnapshot) {
	$('#' + oldChildSnapshot.key()).remove();
});