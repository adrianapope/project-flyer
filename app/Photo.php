<?php

namespace App;

use App\Flyer;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model

{
	protected $table = 'flyer_photos';

	protected $fillable = ['path'];

	// default base path for all of our photos
	protected $baseDir = 'flyers/photos';


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
	* it will accept an uploaded file instance
	*
	*/
    public static function fromForm(UploadedFile $file)
    {
    	// new up a photo instance (because this is a static constructor)
    	$photo = new static;

    	// set up a file name. rename file to something unique with a timetamp before the orignal name
        $name = time() . $file->getClientOriginalName();

        // we can set the path column equal to the baseDir and then the file name.
    	$photo->path = $photo->baseDir . '/' . $name;

    	// move the file
    	$file->move($photo->baseDir, $name);

    	return $photo;
    }
}
