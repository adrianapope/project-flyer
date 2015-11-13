<?php

namespace App;

use App\Flyer;
use Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model

{
    /**
    * The associated table.
    *
    * @var string
    */
	protected $table = 'flyer_photos';

    /**
    * Fillable fields for a photo.
    *
    * @var array
    */
	protected $fillable = ['path', 'name', 'thumbnail_path'];


	/**
	* A photo belongs to a flyer.
	*
	* @returns \Illuminate\Database\Eloquent\Relations\BelongsTo
	*/
    public function flyer()
    {
    	return $this->belongsTo('App\Flyer');
    }


    /**
    * Get the base directory for photo uploads.
    * Defualt directory path where the photos are stored (public/images/photos) folder.
    * baseDir use to be a property and that's good if it needs to be configurable.
    * but if it doesn't need to be configurable then we can just do something like this.
    */
    public function baseDir()
    {
        return 'images/photos';
    }

    /**
    * use a mutator here.
    * Anytime you set the filename we update the path and thumbnail path
    * We will update the internal attributes array.
    * and any time we say $photo->name = 'new.jpg';
    * well we are going to decide that we want to automatically update the path and thumbnail_path as well since they are connected
    * the naming should be the same! if that is appropriate i can do it here.
    *
    */
    public function setNameAttribute($name)
    {
        // update the internal attributes array
        $this->attributes['name'] = $name;

        // update the path
        $this->path = $this->baseDir() .'/'. $name;

        // update the thumbnail_path
        $this->thumbnail_path = $this->baseDir() .'/tn-'. $name;
    }
}
