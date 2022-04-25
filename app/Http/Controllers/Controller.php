<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendEmail($toEmail,$toName,$subject,$body,$viewName='mail',$param=array()){

        // $fromEmail = ;
        try {
            Mail::send($viewName, $param, function ($m) use ($toEmail,$toName,$subject) {
            $m->from(env('MAIL_FROM_ADDRESS','smtp@itechnolabs.tech'), env('MAIL_FROM_NAME','Safe Exam'));

            $m->to($toEmail, $toName)->subject($subject);
        }); 
    }catch (Exception $ex) {
            \Log::info($ex->getMessage());
        }
            
    }
}
