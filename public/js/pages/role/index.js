$(document).on('click', '.delete-datatable-record', function(e){
    let url  = site_url + "/role/" + $(this).attr('data-id');
    let tableId = 'roleTable';
    deleteDataTableRecord(url, tableId);
});

$(document).ready(function() {
    $('#roleTable').DataTable({
        ...defaultDatatableSettings,
        ajax: site_url + "/role/",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'title', name: 'title' },
            { data: 'created_at', name: 'created_at'},
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});