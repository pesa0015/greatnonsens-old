$(window).load(function(){
	$('#writeModal').modal('show');

	$('#writeModal').on('hidden.bs.modal', function () {
    	window.history.back();
	});
});