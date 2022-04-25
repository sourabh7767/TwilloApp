<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Jobs\ProcessEmail;
use Carbon\Carbon;




class UserController extends Controller
{
    public function index(Request $request, User $user)
    {

        if ($request->ajax()) {

            $users = $user->getAllUsers($request);

            $totalUsers = User::where('role',"!=",User::ROLE_ADMIN)->count();

             $search = $request['search']['value'];

             $setFilteredRecords = $totalUsers;

            if(!empty($search)){

            $setFilteredRecords = $user->getAllUsers($request,true);

           }

            return datatables()->of($users)
                ->addIndexColumn()
                ->addColumn('status', function ($user) {
                      return  '<span class="badge badge-light-'.$user->getStatusBadge().'">'.$user->getStatus().'</span>';
                })
              
                ->addColumn('created_at', function ($user) {
                    return $user->created_at;
                })

                ->addColumn('action', function ($user) {
                $btn = '';
                $btn = '<a href="' . route('users.show',encrypt($user->id)) . '" title="View"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;';
                $btn .= '<a href="' . route('users.edit',encrypt($user->id)) . '" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;';
                $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' .$user->id. '" class="delete-datatable-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';

                return $btn;
            })
                ->rawColumns([
                'action',
                'status'
            ])->setTotalRecords($totalUsers)->setFilteredRecords($setFilteredRecords)->skipPaging()
                ->make(true);
        }

        return view('user.index');
    }

     public function create()
    {
        $roles = Role::get();
        return view('user.create',compact("roles"));
    }

    public function store(Request $request)
    {
      $rules = array(
             'full_name' => 'required',
            'email' => 'required|email:rfc,dns,filter|unique:users,email,NULL,id,deleted_at,NULL',
            'phone_code' => 'required',
            'iso_code' => 'required',
            'phone_number' => 'required|unique:users,phone_number,NULL,id,deleted_at,NULL|min:8|max:15',
            'password' => 'required',
            'role'=>'required',
            'confirm_password' => 'required|same:password'               
        );

        $message = ['confirm_password.same'=>'Password and confirm password should be same.'];
        $validator = Validator::make($request->all(), $rules,$message);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }  

        $userArr = $request->except(['confirm_password', '_token']);

        $model = new User;

        $model = $model->fill($userArr);

        $model->email_verified_at = Carbon::now();

        $model->created_by = auth()->user()->id;
        if(!$model->save()){
            return redirect()->back()->with('error', 'Unable to create user. Please try again later.');
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $model = User::find(decrypt($id));
        return view('user.view',compact("model"));
    }

    public function edit($id)
    {
        $roles = Role::get();
        $userObj = User::find(decrypt($id));
        if(!$userObj){
            return redirect()->back()->with('error', 'This user does not exist');
        }
        return view('user.edit', compact('userObj',"roles"));
    }

      public function update(Request $request, $id)
    {

      $rules = array(
             'full_name' => 'required',
            'email' => 'required|email:rfc,dns,filter|unique:users,email,'.$id.',id,deleted_at,NULL',
            'phone_code' => 'required',
            'iso_code' => 'required',
            'phone_number' => 'required|unique:users,phone_number,'.$id.',id,deleted_at,NULL|min:8|max:15'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }  

        $model = User::find($id);
        if(!$model){
            return redirect()->back()->with('error', 'This user does not exist');
        }

        $userArr = $request->except(['_method', '_token']);

        $model = $model->fill($userArr);

        if($model->save()){
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        }

        return redirect()->back()->with('error', 'Unable to update user. Please try again later.');

    }



    public function destroy($id)
    {
        $user = User::find($id);
        
        if(!$user){
            return returnNotFoundResponse('This user does not exist');
        }
        
        $hasDeleted = $user->delete();
        if($hasDeleted){
            return returnSuccessResponse('User deleted successfully');
        }
        
        return returnErrorResponse('Something went wrong. Please try again later');
    }

    public function changeStatus($id){

        $model = User::find($id);

        if(!empty($model)){

            $status = User::STATUS_ACTIVE;

            if($model->status == User::STATUS_ACTIVE){

                $status = User::STATUS_INACTIVE;

            }

            $model->status = $status;

            $model->save();

        }

        return Redirect::back()->withInput()->with('success', 'State Changed successfully');
    }

      public function profile(){


        $model = Auth()->user();
        return view('user.profile',['model'=>$model]);

    }

    
     public function showUpdateProfileForm(){

        $model = Auth()->user();
        return view('user.update_profile',['model'=>$model]);

    }

     public function updateProfile(Request $request)

    {

    $model = Auth()->user();

     $rules = array(
            'full_name'=>'required',
            'email' => 'required|email:rfc,dns,filter|unique:users,email,'.$model->id,
            'phone_number' => 'required|unique:users,phone_number,'.$model->id.',id,deleted_at,NULL|min:8|max:10'

        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } 

        $model = $model->fill($request->all());
        if($request->hasFile('file')){
        $model->profile_image = saveUploadedFile($request->file);
        }
        if($model->save()){

        return redirect()->route('user.home')->with('success', 'profile updated successfully.');
  
        }

        return redirect()->back()->with('error_message', 'Unable to update user. Please try again later.');


    }

    public function changePasswordView()
    {
        return view('user.change-password');
    }

    public function changePassword(Request $request)
    {
        $rules = array(
            'old_password'=>"required",
            'password' => 'required',
            'confirm_password'=>'required|same:password'                        
        );
        $message = ['confirm_password.same'=>'Password and confirm password should be same.'];
        $validator = Validator::make($request->all(), $rules,$message);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } 

        $model = User::find(auth()->user()->id);

        if(!Hash::check($request->old_password, $model->password)){

            return Redirect::back()->withInput()->with('error', 'Old password didnot match');

        }
 

        if(!empty($model)){
            $model->password = $request->input('password');
        
            if($model->save()){

                return redirect()->route('user.home')->with('success', 'Password updated successfully');

            }
        }

        return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');


    }


}
