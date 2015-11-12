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
    * The UploadedFile instance.
    *
    * @var UploadedFile
    */
    protected $file;


    /**
    * When a photo is created, prepare a thumbnail, too using upload().
    * @return void
    * When we are booting this model, do we need to do anything?
    * yes, we'll add an eloquent event listener.
    * when you are in the process of creating a new photo, getting ready to persist it,
    * and you are saying i am about to save this new photo, does anyone want me to do anything? does anyone want to stop me?
    * yeah, when you are ready to save a photo i want to interject at that point and just upload the file.
    * so i can call photo upload here rather than from our controller.
    * the way that it works is that if you return a falsey value from this closure, the it assumes
    * something went wrong and the photo will not be persisited. that's how we can handle that.
    */
    protected static function boot()
    {
        static::creating(function ($photo) {
            return $photo->upload();
        });
    }


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
    * Make a new photo instance from an uploaded file.
    * Static constructor which creates a photo instance, sets it to $file and fills it up with the necessary properties.
    *
    * @param UploadedFile $file
    * @return self
    */

    public static function fromFile(UploadedFile $file)
    {
        // new up a photo instance
        $photo = new static;

        // set the file instance. we will assign the uploaded file to the object
        $photo->file = $file;

        // fil the necessary properties or columns on the model Photo
        // since this is a substitute for a constuctor, i'm going to fill the necessary columns.
        // instead of using saveAs method, we will just defer to separate methods and create each one.
        // return the instance
        return $photo->fill([
            'name'              => $photo->fileName(),
            'path'              => $photo->filePath(),
            'thumbnail_path'    => $photo->thumbnailPath()
        ]);
    }


    /**
    * Get the file name for the photo.
    * @return string
    * Produce a fileName with timestamp + original name + extension.
    * and now we can delegate to the uploaded file and get the client original name
    * now we can format the file however we want.
    * run it through sha1() encryption method. then merge the current time with the file name and then encrypt that.
    * so that would be our name
    * and then we need to get the extension. and we just merge those together to produce a finished fileName
    */
    public function fileName()
    {
        $name = sha1(
            time() . $this->file->getClientOriginalName()
        );

        $extension = $this->file->getClientOriginalExtension();

        return "{$name}.{$extension}";
    }

    /**
    * Get the path to the photo.
    *
    * @return string
    */
    public function filePath()
    {
        return $this->baseDir() . '/'. $this->fileName();
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
    * Get the path to the photo's thumbnail.
    *
    * @return string
    */
    public function thumbnailPath()
    {
        return $this->baseDir() . '/tn-' . $this->filename();
    }


    /**
    * Move the photo to the proper folder.
    * Move the file to the baseDir and the name we gave it. And calls makeThumbnail method.
    * Delegate to the file instance on the object object to move it to the baseDir and the file name.
    *
    * @return self
    */
    public function upload()
    {
        $this->file->move($this->baseDir(), $this->fileName());

        $this->makeThumbnail();

        return $this;
    }


    /**
    * Create a thumbnail for the photo.
    *
    * @return void
    */
    public function makeThumbnail()
    {
        Image::make($this->filePath())
            ->fit(200)
            ->save($this->thumbnailPath());
    }
}
