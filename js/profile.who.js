function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#check_img').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#fileToUpload").change(function(){
        readURL(this);
    });
$('#open_file_dialog').on('click', function() {
    $('#fileToUpload').trigger('click');
});
$('#fileToUpload').on('change', function() {
    document.getElementById('upload_img_disabled').style.display = 'none';
    document.getElementById('upload_img').style.display = 'inline';
});