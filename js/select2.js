$(document).ready(function(){
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
});