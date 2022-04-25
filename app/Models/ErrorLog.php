<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasFactory;

    protected $fillable = [
    	'file',
    	'message',
    	'trace'
    ];

    public function saveExceptionResponse($exception){

    	 $data = [
            'file'    => $exception->getFile(),
            'message' => "Line".$exception->getLine()." ". $exception->getMessage(),
            'trace'   => $exception->getTraceAsString(),
        ];

        self::create($data);

    }
}
