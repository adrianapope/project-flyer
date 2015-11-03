<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
	protected $table = 'flyer_photos';

	protected $fillable = ['path'];


	/**
	* A photo belongs to a flyer.
	*
	* @returns \Illuminate\Database\Eloquent\Relations\BelongsTo
	*/
    public function flyer()
    {
    	return $this->belongsTo('App\Flyer');
    }
}
