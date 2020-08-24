    //
    $('#new_folder').click(function(event) {
      $('#create_folder').css('display', 'inline');
      $('#upload_form').css('display', 'none');
    });

    $('#btn_cancel_create_folder').click(function(event) {
     $('#create_folder').css('display', 'none');
   });

    //

    $('#upload_file').click(function(event) {
      $('#upload_form').css('display', 'inline');
      $('#create_folder').css('display', 'none');
    });

    $('#btn_cancel_upload').click(function(event) {
     $('#upload_form').css('display', 'none');
   });

    function showImage(id) {
     $.ajax({
       url: '{{Route("library.show")}}',
       type: 'GET',
       dataType: 'JSON',
       data: {id: id},
     })
     .done(function(data) {
      if(data['directory']!=''){
        var src = '{{asset("public/uploads")}}'+'/'+data['directory']+'/'+data['src'];
      }else{
        var src = '{{asset("public/uploads")}}'+'/'+data['src'];
      }
      
      $('#myModal').css('display', 'block');
      $('.header-desktop').css('z-index', 0);
      $('#img01').attr('src', src);
      $('#title').text(data['title']);
      $('#desc').text(data['desc']);
      $('#alt').text(data['alt']);

            // Get the <span> element that closes the modal

            // When the user clicks on <span> (x), close the modal
            $('#close').click(function(event) {
              $('#myModal').css('display', 'none');
              $('.header-desktop').css('z-index', 99);
            });       
          })
     .fail(function() {
       console.log("error");
     })
     .always(function() {
       console.log("complete");
     });
   }
