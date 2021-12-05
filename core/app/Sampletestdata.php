<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sampletestdata extends Model
{
    //
	protected $table = 'sampletestdata';
	
	public function sampletestdata_sample()
    {
        return $this->hasOne('App\Sample','id','sampleid');
    }
}
