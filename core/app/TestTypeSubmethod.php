<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestTypeSubmethod extends Model
{
    protected $table = 'testtypesubmethods';
	
	public function testtypesubmethod_testtype()
    {
        return $this->hasOne('App\TestType','id','testtype_id');
    }
	
	public function testtypesubmethod_testtypemethod()
    {
        return $this->hasOne('App\TestTypeMethod','id','testtypemethod_id');
    }
}
