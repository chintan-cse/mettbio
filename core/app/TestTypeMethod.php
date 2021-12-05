<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestTypeMethod extends Model
{
    protected $table = 'testtypemethods';
	
	public function testtypemethod_testtype()
    {
        return $this->hasOne('App\TestType','id','testtype_id');
    }
	
	public function testtypemethod_submethod()
    {
        return $this->hasMany('App\TestTypeSubmethod','testtypemethod_id','id');
    }
}
