<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Permission;
use App\Models\RolePermission;


class RoleController extends Controller
{
    public function index(Request $request, Role $role)
    {
        if ($request->ajax()) {

            $roles = $role->getAllRoles();

            return datatables()->of($roles)
                ->addIndexColumn()
               
                ->addColumn('created_at', function ($role) {
                    return $role->created_at;
                })

                ->addColumn('action', function ($role) {
                $btn = '';
               
                 $btn = '<a href="' . route('role.edit',encrypt($role->id)) . '" title="Edit"><i class="fas fa-edit ml-1"></i></a>&nbsp;&nbsp;';

                 if($role->is_deleteable ==1){

                $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' .$role->id. '" class="delete-datatable-record text-danger delete-roles-record" title="Delete"><i class="fas fa-trash ml-1"></i></a>';
            }

                return $btn;
            })
                ->rawColumns([
                'action'
                
            ])
                ->make(true);
        }

        return view('role.index');
    }

     public function create()
    {
        $permissions = Permission::get();
        return view('role.create',compact("permissions"));
    }

    public function store(Request $request)
    {

        $rules = array(
            'title' => 'required|unique:roles,title,Null,id,deleted_at,NULL',
            'permission'=>'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } 

        $model = new Role;
        $model = $model->fill($request->all());
        $model->created_by = auth()->user()->id;
       
        if ($model->save()) {

            if(!empty($request->permission)){

            foreach ($request->permission as $key => $value) {
                $rolePermission = new RolePermission;
                $rolePermission->role_id = $model->id;
                $rolePermission->permission_id = $value;
                $rolePermission->created_by = auth()->user()->id;
                $rolePermission->save();

            }
        } 
        
            return redirect('/role')->with('success', "Role created successfully");
        }

       
        return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
        
    }

      public function edit($id)
    {
        $id = decrypt($id);
        $permissions = Permission::get();        
        $model = Role::find($id);
        $rolePermissions = RolePermission::where(['role_id'=>$id])->pluck('permission_id')->toArray();
        if(empty($rolePermissions))
            $rolePermissions = [];

        if(!$model){
            return redirect()->back()->with('error', 'This page does not exist');
        }
        return view('role.edit',compact("model","permissions","rolePermissions"));
    }


    public function update($id,Request $request){

         $rules = array(
            'title' => 'required|unique:roles,title,'.$id.',id,deleted_at,NULL',
            'permission'=>'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $model = Role::find($id);

        $model = $model->fill($request->all());

        if ($model->save()) {
            if(!empty($request->permission)){

                RolePermission::where(['role_id'=>$id])->delete();

            foreach ($request->permission as $key => $value) {
                $rolePermission = new RolePermission;
                $rolePermission->role_id = $model->id;
                $rolePermission->permission_id = $value;
                $rolePermission->created_by = auth()->user()->id;
                $rolePermission->save();

            }
        } 
                return redirect('/role')->with('success', "Role updated successfully");
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
            }
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        
        if(!$role){
            return returnNotFoundResponse('This user does not exist');
        }

        $checkIfExist = User::where(['role'=>$role->id])->count();

        if($checkIfExist)
            return returnErrorResponse('One or more user exists with this role.');

        
        $hasDeleted = $role->delete();
        if($hasDeleted){
            return returnSuccessResponse('Role deleted successfully');
        }
        
        return returnErrorResponse('Something went wrong. Please try again later');
    }
}
