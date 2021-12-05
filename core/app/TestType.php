<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestType extends Model
{
    protected $table = 'testtypes';
	
	public function testtype_method()
    {
        return $this->hasMany('App\TestTypeMethod','testtype_id','id');
    }
	
	public function testtype_submethod()
    {
        return $this->hasMany('App\TestTypeSubmethod','testtype_id','id');
    }    
}
