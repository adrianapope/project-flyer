<?php

namespace App;

use App\Photo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
	* Find the flyer at the given address.
	*
	* @param string $zip
	* @param string $street
	* @return Builder
	*/
	public static function locatedAt($zip, $street)
	{
		// replace spaces with a dash
        $street = str_replace('-', ' ', $street);

		// where clause to search for the flyer with zip and street
        return static::where(compact('zip', 'street'))->firstOrFail();
    }

	/**
    * Formats the price for a house.
    *
    */
    public function getPriceAttribute($price)
    {
    	return '$' . number_format($price);
    }


    /**
    * Adds a photo to the flyer.
    *
    */
    public function addPhoto(Photo $photo)
    {
    	// reference that relationship and save the photo (last part of the process)
    	// flyer to photos() where photos() is the relationship (see below)
    	return $this->photos()->save($photo);
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


	/**
	* A flyer is owned by a user and the column is user_id.
	*
	* @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	*/
    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }


	/**
	* Determine if the given user created the flyer.
	*
	* @param User $user
	* @return boolean
	*/
    public function ownedBy(User $user)
    {
    	// check to see if the user_id equals the id of the user passed in.
    	return $this->user_id == $user->id;
    }
}
