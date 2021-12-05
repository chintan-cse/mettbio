<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	 
    protected $fillable = [
        'email',
        'password',
        'name',
        'last_login',
        'last_login_ip',
		'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }
	
	public function user_userprofile()
    {
        return $this->hasOne('App\UserProfile','userid','id');
    }
	
	public function user_company()
    {
		return $this->hasManyThrough('App\Company', 'App\UserProfile','userid', 'company_id','id');
    }

    public function user_role()
    {
        return $this->hasOne('App\Role','role','id');
    }
	
	public function user_assignto()
    {
        return $this->hasOne('App\SampleAssigned','userid','id');
    }
}
