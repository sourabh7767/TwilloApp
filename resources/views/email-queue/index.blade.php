@extends('layouts.app')
@section('title')Email Queues @endsection
@section('content')

  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Email Queues</h1>
          </div>
           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item active">DataTables</li> -->
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

   
           

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            <div class="card">
               <div class="card-header">
                <i class="fas fa-table mr-2"></i>{{ __('Email Queues') }}
              
            </div>
            
              <!-- /.card-header -->
              <div class="card-body">
                <table id="emailQueueTable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>From Email</th>
                    <th>To Email</th>
                    <th>Subject</th>
                     <th>Status</th>
                    <th>Created At</th>
                    <th data-orderable="false">Action</th>
                  </tr>
                  </thead>
              
                </table>
              </div>
          
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
		</div>
       </div>    
      </div>
      <!-- /.container-fluid -->
    </section>
   
  

@push('page_script')

@include('include.data-table-scripts')   


	         <script>

$(document).ready(function() {
	
    $('#emailQueueTable').DataTable({
        processing: true,
        serverSide: true,
    pageLength: 25,
        ajax: "{{route('email-queue.index')}}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'from_email', name: 'from_email' },
            { data: 'to_email', name: 'to_email' },
            { data: 'subject', name: 'subject' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at'},
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ],
       
    });
});


$(document).on('click', '.delete-datatable-record', function(e){
    let url  = site_url + "/users/" + $(this).attr('data-id');
    let tableId = 'usersTable';
    deleteDataTableRecord(url, tableId);
});




			</script>

@endpush

	     
@endsection