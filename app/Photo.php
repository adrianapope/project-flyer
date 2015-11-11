<?php

namespace App;

use App\Flyer;
use Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model

{
	protected $table = 'flyer_photos';

	protected $fillable = ['path', 'name', 'thumbnail_path'];

	// default base path for all of our photos
	protected $baseDir = 'images/photos';


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
	* Creates a new instance of photo from a file upload.
    *
	* @param string $name
    * @return self
	*/
    public static function named($name)
    {

        // creates a new instance of photo and then we name it whatever the file should be
        // $photo = new static;
        // return $photo->saveAs($file->getClientOriginalName());
        return (new static)->saveAs($name);
    }


    /**
    * Set the proper columns such as name, path and thumbnail_path.
    *
    */
    public function saveAs($name)
    {
        // name of the file   12334556777RedHouse.jpg
        $this->name = sprintf("%s-%s", time(), $name);

        // name of the path   flyers/photos/2342344GreenHouse.jpg
        $this->path = sprintf("%s/%s", $this->baseDir, $this->name);

        // name of the thumbnail   flyers/photos/tn-123434555BlueHouse.jpg
        $this->thumbnail_path = sprintf("%s/tn-%s", $this->baseDir, $this->name);

        return $this;
    }

    /**
    * Move the file to the baseDir and the name we gave it. And calls makeThumbnail method.
    *
    *
    */
    public function move(UploadedFile $file)
    {
        $file->move($this->baseDir, $this->name);

        $this->makeThumbnail();

        return $this;
    }


    /**
    * Creates a thumbnail which is fitted and saved.
    *
    */
    public function makeThumbnail()
    {
        Image::make($this->path)
            ->fit(200)
            ->save($this->thumbnail_path);
    }
}
