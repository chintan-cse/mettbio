<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleAssigned extends Model
{
    //
	protected $table = 'sampleassigned';
	protected $primaryKey = null;
    public $incrementing = false;
	
	public function assignto_user()
    {
        return $this->hasOne('App\User','id','userid');
    }
	
	public function assignto_sample()
    {
        return $this->hasOne('App\Sample','id','sampleid');
    }
}
