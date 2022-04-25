var site_url = window.location.protocol + '//' + window.location.host;
var defaultDatatableSettings = {
    processing: true,
    serverSide: true,
    pageLength: 10,
    order: [[ 1, "asc" ]]
};

$(window).on('load', function() {
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
});

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


function deleteDataTableRecord(url, tableId,className = ''){
    swal({
      title: "Are you sure want to delete this record?",
      // text: "Once deleted, you will not be able to recover this record!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
      buttons: {
          cancel : 'No, cancel it!',
          confirm : 'Yes, I am sure!'
      },
  })
  .then((willDelete) => {
      if (willDelete) {
          $.ajax({
              type: "DELETE",
             
              url: url,
              success: function (data) {
                console.log(data);
                  if(data.statusCode >= 200 && data.statusCode < 400){
                      toastr.success(data.message);
                      if(className != ''){
                        $(className).remove();
                      }
                      let oTable = $('#'+tableId).dataTable(); 
                        oTable.fnDraw(false);
                  }

                  if(data.statusCode >= 400 && data.statusCode < 500){
                      toastr.info(data.message);
                  }

                  if(data.statusCode >= 500){
                    alert(data.message);
                      toastr.error(data.message);
                  }
              },
              error: function (data) {
                 if(data.responseJSON.statusCode >= 500){
                      toastr.error(data.responseJSON.message);
                  }
              }
          });
      }
  });
}