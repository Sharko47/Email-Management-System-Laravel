<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use SoftDeletes;


    protected $dates = ['deleted_at'];
    
    protected $fillable = ['user_id','to','from','subject','message','email_attachments'];
}
