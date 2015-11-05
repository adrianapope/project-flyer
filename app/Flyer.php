<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flyer extends Model
{
	/**
	* Fillable fields for a flyer.
	*
	* @var array
	*/
	protected $fillable = [
		'street',
		'city',
		'state',
		'country',
		'zip',
		'price',
		'description',
	];

	/**
	* Scope query to those located at a given address.
	*
	* @param Builder $query
	* @param string $zip
	* @param string $street
	* @return Builder
	*/
	public function scopeLocatedAt($query, $zip, $street)
	{
		// replace spaces with a dash
        $street = str_replace('-', ' ', $street);

        // query where zip is this and street is that
        return $query->where(compact('zip', 'street'));
    }


	/**
	* A flyer is composed of many photos.
	*
	* @return \Illuminate\Database\Eloquent\Relations\HasMany
	*/
    public function photos()
    {
    	return $this->hasMany('App\Photo');
    }
}
