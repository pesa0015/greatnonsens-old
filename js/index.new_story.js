$(window).load(function(){
	$('#newStoryModal').modal('show');

	$('#newStoryModal').on('hidden.bs.modal', function () {
    	// window.history.back();
    	window.location.replace('/');
	});
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$('#hide').css('display', 'none');