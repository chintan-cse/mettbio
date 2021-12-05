<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    //
	protected $table = 'user_profile';
	protected $primary_key = 'userid';
	
	protected $fillable = [
        'userid','profile_pic','company_name','firstname','lastname','phone_number','country','state','city','zip','address'
    ];
	
	public function userprofile_user()
    {	
        return $this->hasOne('App\User','id','userid')->where('status','=',1);
    }

    public function userprofile_company()
    {	
        return $this->hasOne('App\Company','id','company_id');
    }
}
