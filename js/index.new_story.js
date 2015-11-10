$(window).load(function(){
	$('#newStoryModal').modal('show');

	$('#newStoryModal').on('hidden.bs.modal', function () {
    	window.history.back();
	});
});

$('#hide').css('display', 'none');