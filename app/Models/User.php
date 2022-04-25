<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    const ROLE_ADMIN = 0;
    const ROLE_USER = 2;
    const ROLE_PROJECT_MANAGER = 1;
    const ROLE_CUTTING_MANAGER = 3;
    const ROLE_PRODUCTION_MANAGER = 4;
    const ROLE_HR = 5;


    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const DEVICE_NOTIFICATION = 1;
    const EMAIL_NOTIFICATION = 2;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'phone_code',
        'iso_code',
        'password',
        'role',
        'device_type',
        'fcm_token',
        'notification',
        'email_notification',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getColumnForSorting($value){

        $list = [
            0=>'id',
            1=>'full_name',
            2=>'email',
            3=>'status',
            4=>'created_at'
        ];

        return isset($list[$value])?$list[$value]:"";
    }

    public function getAllUsers($request = null,$flag = false)
    {
        $columnNumber = $request['order'][0]['column'];
        $order = $request['order'][0]['dir'];

        $column = self::getColumnForSorting($columnNumber);

        if($columnNumber == 0){
            $order = "desc";
        }

        if(empty($column)){
            $column = 'id';
        }
        $query = self::select("users.*","roles.title as user_role")->leftJoin('roles', 'roles.id', '=', 'users.role')->orderBy($column, $order)->where('users.created_by','!=', 0);

        if(!empty($request)){

            $search = $request['search']['value'];

            if(!empty($search)){
                 $query->where(function ($query) use($request,$search){
                        $query->orWhere( 'full_name', 'LIKE', '%'. $search .'%')
                            ->orWhere( 'email', 'LIKE', '%'. $search .'%')
                            ->orWhere( 'roles.title', 'LIKE', '%'. $search .'%')
                            ->orWhere('users.created_at', 'LIKE', '%' . $search . '%');

                    });

                 if(empty(strcasecmp("Inactive",$search))){
                    $query->orWhere( 'status',  0);

                 }
                if(empty(strcasecmp("Active",$search))){
                    $query->orWhere( 'status',  1);

                 }

                  // if(is_int(stripos("Inactive", $search))){
                  //           $query->orWhere( 'status',  0);

                  //       }
                 // if(is_int(stripos("Active", $search))){
                 //            $query->orWhere( 'status',  1);

                 //        }
                       

                 if($flag)
                    return $query->count();
            }

            $start =  $request['start'];
            $length = $request['length'];
            $query->offset($start)->limit($length);


        }

        


        $query = $query->get();

        // print_r($query);
        // die();

        return $query;
    }

    public function getStatus(){

        $list = [

            self::STATUS_ACTIVE=>"Active",
            self::STATUS_INACTIVE=>"Inactive"
        ];

        return isset($list[$this->status])?$list[$this->status]:"Not defined";
    }

    public function getStatusBadge(){

         $list = [

            self::STATUS_ACTIVE=>"primary",
            self::STATUS_INACTIVE=>"danger"
        ];

        return isset($list[$this->status])?$list[$this->status]:"danger";


    }

     public function getRole(){


        $list = Role::pluck('title', 'id')->toArray();
        $list[self::ROLE_ADMIN] = "Admin";

        return isset($list[$this->role])?$list[$this->role]:"Not defined";
    }



     public static function getRoleTypeOptions(){

        $list = [

            self::ROLE_PROJECT_MANAGER=>"Project Manager",
            self::ROLE_CUTTING_MANAGER=>"Cutting Manager",
            self::ROLE_PRODUCTION_MANAGER=>"Production Manager",
            self::ROLE_HR=>"HR"

        ];

        return $list;

    }

    public static function getActiveInactiveCount(){

        $data[] = [
            'name'=>'Active User',
            'y'=>self::where(['status'=>self::STATUS_ACTIVE])->where('role','!=', self::ROLE_ADMIN)->count(),
            'sliced'=>true,
            'selected'=>true,
            'color'=>'#007bff'
        ];
        $data[] = [
            'name'=>'Inactive User',
            'y'=>self::where(['status'=>self::STATUS_INACTIVE])->where('role','!=', self::ROLE_ADMIN)->count(),
            'color'=>"#212529"

        ];
       
        return json_encode($data);
    }

    public static function monthly()
    {
        $date = new \DateTime(date('Y-m'));

        $date->modify('-8 months');

        $count = [];
        for ($i = 1; $i <= 8; $i ++) {
            $date->modify('+1 months');
            $month = $date->format('Y-m');

            $userCount = self::where('created_at','like','%' . $month . '%')->where('role','!=', self::ROLE_ADMIN)->count();

            $count[$month] = $userCount;
        }
        return $count;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public static function generateEmailVerificationOtp(){
        // $otp = 1234;
        // return $otp;

        $otp = mt_rand(1000,9999);
        // $otp = 123456;
        $count = self::where('email_verification_otp', $otp)->count();
        if($count > 0){
            $this->generateEmailVerificationOtp();
        }
        return $otp;
    }

     public function jsonResponse(){

        $json['id'] = $this->id;
        $json['full_name'] = $this->full_name;
        $json['email'] = $this->email;
        $json['profile_image'] = $this->profile_image;
        $json['role'] = $this->role;
        $json['status'] = $this->status;
        $json['email_verification_otp'] = $this->email_verification_otp;
        $json['notification'] = $this->notification;
        $json['email_notification'] = $this->email_notification;
        $json['email_verified_at'] = $this->email_verified_at;
        $json['created_at'] = $this->created_at->toDateTimeString();
        $json['updated_at'] = $this->updated_at->toDateTimeString();

        return $json;


    }

}
