@extends('layouts.admin')

@section('title') View Profile @endsection

@section('content')

 <section>

   <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Profile
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
       

        <div class="row">
          <div class="col-12">
            <div class="card">
  
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row">
                    <div class="col-md-3">

                      @if(!empty($model->profile_image))

                      <img src="{{$model->profile_image}}" style="width:100%;">

                      @endif

                    </div>

                    <div class="col-md-9">
                        <div class="table-responsive">
                            <table id="w0" class="table table-striped table-bordered detail-view">
                                <tbody>
                          <tr>
                              <th>ID</th>
                              <td colspan="1">{{$model->id}}</td>
  
                          </tr>
                      
                        <tr>
                            <th>Name</th>
                            <td colspan="1">{{$model->full_name}}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td colspan="1">{{$model->email}}</td>
                            
                         </tr>
                         <tr>
                            <th>Role</th>
                            <td colspan="1">{{$model->getRole()}}</td>
                            
                         </tr>
                        <tr>
                            <th>Created At</th>
                        <td colspan="1">{{$model->created_at}}</td>
                        
                     </tr>
                       <tr>
                            <th>Updated At</th>
                        <td colspan="1">{{$model->updated_at}}</td>
                        
                     </tr>
                 </tbody>
             </table>

         </div> 
      </div>
    
</div>

              

              
              </div>
          
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
       </div>   




</section>




@endsection