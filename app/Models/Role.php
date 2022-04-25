<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Role extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
    	'title',
    	'is_deleteable',
    	'created_by'
    ];

    public function getAllRoles(){

    	return self::get();
    }
}
