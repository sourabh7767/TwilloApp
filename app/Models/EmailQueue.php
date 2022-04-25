<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Models\ErrorLog;
use Illuminate\Support\Facades\View;




class EmailQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'to_email',
        'from_email',
        'subject',
        'message',
        'status',
        'date_sent',
        'attempts',
        'last_attempt'
    ];

    const STATUS_SENT = 1;
    const STATUS_NOT_SENT = 0;

    public static function getColumnForSorting($value){

        $list = [
            0=>'id',
            1=>'from_email',
            2=>'to_email',
            3=>'status',
            4=>'created_at'
        ];

        return isset($list[$value])?$list[$value]:"";
    }

    public function getAllEmailQueues($request = null,$flag = false)
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
        $query = self::orderBy($column, $order);

        if(!empty($request)){

            $search = $request['search']['value'];

            if(!empty($search)){
                 $query->where(function ($query) use($request,$search){
                        $query->orWhere( 'from_email', 'LIKE', '%'. $search .'%')
                            ->orWhere( 'to_email', 'LIKE', '%'. $search .'%')
                            ->orWhere( 'subject', 'LIKE', '%'. $search .'%')
                            ->orWhere('created_at', 'LIKE', '%' . $search . '%');
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

        return $query;
    }

    public function getStatus(){

        $list = [

            self::STATUS_SENT=>"Sent",
            self::STATUS_NOT_SENT=>"Not Sent"
        ];

        return isset($list[$this->status])?$list[$this->status]:"Not defined";
    }

    public function getStatusBadge(){

         $list = [

            self::STATUS_SENT=>"success",
            self::STATUS_NOT_SENT=>"secondary"
        ];

        return isset($list[$this->status])?$list[$this->status]:"danger";


    }


    public static function add($args = []){

    	if (! $args)
            return false;

        $mail = new self;
        if (isset($args['model'])) {
            $mail->model_id = $args['model']->id;
            $mail->model_type = get_class($args['model']);
        }
        $mail->from_email = env('MAIL_FROM_ADDRESS','smtp@itechnolabs.tech');
        $mail->to_email = $args['to'];
        $mail->subject = (isset($args['subject'])) ? $args['subject'] : "EmailQueue";
        $mail->type = (isset($args['type'])) ? $args['type'] : 0;
        $mail->date_published = now();
        $mail->status = 0;
        $mail->message = View::make($args['view'], $args['viewArgs']); 

        if($mail->save()){

        	$response = $mail->sendNow($mail->to_email,$mail->subject,$args['view'],$args['viewArgs']);

           if($response){
            $mail->update(['status'=>1,'date_sent'=>now(),'attempts'=>1,'last_attempt'=>now()]);

           }

        }


    }

    public function sendNow($toEmail,$subject,$viewName='mail',$param=array()){

        $flag = false;

        try {

            Mail::send($viewName, $param, function ($m) use ($toEmail,$subject) {
            $m->from(env('MAIL_FROM_ADDRESS','smtp@itechnolabs.tech'), env('MAIL_FROM_NAME','Safe Exam'));

            $m->to($toEmail)->subject($subject);

            $flag = true;

           
        }); 
    }catch (\Throwable $ex) {
            $flag = false;
            ErrorLog::saveExceptionResponse($ex);
        }

        return $flag;

            
    }


}
