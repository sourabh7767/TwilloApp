@extends('layouts.app')

@section('title') Email @endsection

@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
        	<div class="col-12">
             <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-6">


                   </div>
                <div class="col-md-6">

              
                <a id="tool-btn-manage"  class="btn btn-success float-right" href="/email-queue" title="Back">Back

               
                </a>
              </div>
              </div>
            </div>
          </div>
      </div>
  </div>
  </div>
  <br>

  <div class="container-fluid">
        <div class="row">
        	<div class="col-12">
             <div class="card">
              <div class="card-header">
              	<div class="row">
              		
                    <div class="col-md-12">
			            <div class="table-responsive">
			            	<table id="w0" class="table table-striped table-bordered detail-view">
			            		<tbody>
			            			<tr>
			            				<th>ID</th>
			            				<td colspan="1">{{$model->id}}</td>
			            				<th>From Email</th>
                          <td colspan="1"><a href="mailto:jashely775@gmail.com">{{$model->from_email}}</a></td>
			            			</tr>
                                    <tr>
                                    	<th>To Email</th>
                                    	<td colspan="1"><a href="mailto:jashely775@gmail.com">{{$model->to_email}}</a></td>
                                      <th>Subject</th>
                                      <td colspan="1">{{$model->subject}}</td>
                                    </tr>
                                   
                                    
                                   <tr>
                                    <th>Status</th>
                                      <td colspan="1"><span class="badge badge-{{($model->status == 1)?'success':'secondary'}}">{{$model->getStatus()}}</span>
</td>
                                      <th>Last Attempt</th>
                                      <td colspan="1">{{$model->last_attempt}}</td>
                                   	  
                                     
                                    </tr>
                                     <tr>
                                     
                                      <th>Attempts</th>
                                      <td colspan="1">{{$model->attempts}}</td>
                                       <th>Date Sent</th>
                                      <td colspan="1">{{$model->date_sent}}</td>
                                     
                                    </tr>
                                     <tr>
                                       <th>Created At</th>
                                      <td colspan="1">{{$model->created_at}}</td>
                                     
                                      <th>Updated At</th>
                                      <td colspan="1">{{$model->updated_at}}</td>

                                     
                                    </tr>
                                   	
                                   </tr>
                               </tbody>
                           </table>
                       </div>	
                    </div>


              </div>
          </div>
      </div>
  </div>
</div>
  </div>
  <br>

   <div class="container-fluid">
        <div class="row">
          <div class="col-12">
             <div class="card">
                <div class="card-body">


              {!!$model->message!!}

            </div>
             
          </div>
      </div>
  </div>
  </div>




 </section>

 
 @push('page_script')


           <script>



$(document).on('click', '.active_status', function(e){
      e.preventDefault();
      swal({
      title: "Are you sure want to change the state?",
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
            var url  = site_url + "/user/changeStatus/" + $(this).attr('data-id');
          window.location.href=url;

      }
  });
});




      </script>

@endpush
@endsection
