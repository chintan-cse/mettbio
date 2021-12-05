<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    protected $table = 'company';
	
	public function company_userprofile() {
		return $this->hasMany('App\UserProfile','company_id','id');
	}
	
	public function company_user() {
		return $this->hasManyThrough('App\User', 'App\UserProfile','company_id', 'userid','id');
	}
	
	public function company_quotes()
    {	
		return $this->hasManyDeep('App\Quote', ['App\UserProfile', 'App\User'],[
               'company_id',
               'id',
               'userid'
            ],
            [          
              'id',
              'userid',
              'id'
            ])->with('quote_selectedtemplate','quote_invoice')->where('quote_details.status','=',1);
		// return $this->hasManyThrough('App\Quote', 'App\UserProfile','company_id', 'userid','id');
    }
	
	public function company_orders()
    {
        return $this->hasManyDeep('App\Quote', ['App\UserProfile', 'App\User'],[
               'company_id',
               'id',
               'userid'
            ],
            [          
              'id',
              'userid',
              'id'
            ])->with('quote_selectedtemplate','quote_invoice')->where('quote_details.confirmed','=',1)->where('quote_details.status','=',1);
    }
    
}
