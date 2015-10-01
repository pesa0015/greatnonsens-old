$(document).ready(function () {
    $('#newStoryModal').on('hidden.bs.modal', function () {
    	window.history.back();
	});
});

$(document).ready(function () {
    $('#writeModal').on('hidden.bs.modal', function () {
    	window.history.back();
	});
});