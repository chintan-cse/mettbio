<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    protected $table = 'samples';
	
	public function sample_testtype()
    {
        return $this->hasOne('App\TestType','id','testtype_id');
    }
	
	public function sample_testtypemethod()
    {
        return $this->hasOne('App\TestTypeMethod','id','testtypemethod_id');
    }
	
	public function sample_testtypesubmethod()
    {
        return $this->hasOne('App\TestTypeSubmethod','id','testtypesubmethod_id');
    }
	
	public function sample_assignto()
    {
        return $this->hasOne('App\SampleAssigned','sampleid','id');
    }
	
	public function sample_testdata()
    {
        return $this->hasMany('App\Sampletestdata','sampleid','id');
    }
}
