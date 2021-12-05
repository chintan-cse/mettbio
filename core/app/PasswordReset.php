<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    //
	protected $primaryKey = 'reset_id';
	
	protected $fillable = [
        'reset_email', 'reset_token','reset_status'
	];
}
