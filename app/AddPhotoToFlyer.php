<?php

namespace App;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddPhotoToFlyer {

	// these are things it accepts and we pass through
	/**
	* The Flyer instance.
	*
	* @var Flyer
	*/
	protected $flyer;


	// don't get confused here. it's not the photo instance. its really the UploadedFile instance
	/**
	* The UploadedFile instance.
	*
	* @var UploadedFile
	*/
	protected $file;


	// accepts thumbnail but not required so set to null (it'll make api easier)
	/**
	* Create a new AddPhotoToFlyer form object.
	*
	* @param Flyer $flyer
	* @param UploadedFile $file
	* @param Thumbnail|null $thumbnail
	*/
	public function __construct(Flyer $flyer, UploadedFile $file, Thumbnail $thumbnail = null)
	{
		$this->flyer = $flyer;
		$this->file = $file;
		// we'll assing it
		// says if they gave me anything of course i'll use it otherwise i will new it up right here
		$this->thumbnail = $thumbnail ?: new Thumbnail;
	}

	// summary: when we call save we build up a photo by calling the makePhoto() method
	// in makePhoto() we pass through a 'name' where we construct a name here in makeFileName()
	// then when we assign the name this method setNameAttribute in the Photo.php model will be called automatically by follwing this convention
	// we also take care of setting the path and the thumbnail_path in the process. we return that.
	// and then we pass that photo instance to our addPhoto() method on our Flyer model
	// where it persists it and assigns the flyer_id in the process
	// next part is move the photo to the images folder.
	// before we had this upload() method and that is where we moved it and created the thumbnail
	// we can extract that and put it into our save() method for the move photo to images folder section
	// and remember when we call the move method we pass in the baseDir as well as the name of the photo
	// and let's make sure we save the photo here by doing $photo =


	// we added a save method.
	// like i said you can handle your validation here
	// we can also handle any interaction with our UploadedFile instance
	// and the benefit to that is we would no longer need to introduce that to our Photo model
	// the place in our Photo.php where this is (the property protected $file;) which is much cleaner
	/**
	* Process the form.
	*
	* @return void
	*/
	public function save()
	{
		// add the photo
		// attach the photo to the flyer
		// we call this addPhoto() method that the Flyer model already has
		// this method save and assigns the flyer_id in the process
		// and i need a photo so maybe i can extract a method here called makePhoto()
		$photo = $this->flyer->addPhoto($this->makePhoto());

		// move the photo to the images folder
		$this->file->move($photo->baseDir(), $photo->name);

		// generate a thumbnail
        // Image::make($this->path)
        //     ->fit(200)
        //     ->save($this->thumbnail_path);
		// an easier way is to wrap this up within our own thumbnail class
		// then i could presumbably say the below and it will accept a source and a destination of where this should go
		// $this-thumbnail->make($src, $destination);
		$this->thumbnail->make($photo->path, $photo->thumbnail_path);
	}


	// maybe i can just return a photo instance and set the name to ....
	// remember we have ot use a little bit of logic based upon the fileupload to figure out what the name should be
	// before we were doing that directly in the photo class but now we are going to do it out here since we are depending upon form uploads
	// we'll just isolate it within this class
	// what about setting the path and the thumbnail path?
	// we can either do that here and be explicit or maybe we decide that any time you set the filename
	//...well we need to make sure we update the path and the thumbnail path as well because they should always be linked to the name of the file
	// if this is the case, why don't we use a mutator here
	/**
	* Make a new photo instance.
	*
	* @return Photo
	*/
	public function makePhoto()
	{
		return new Photo(['name' => $this->makeFilename()]);
	}

	// Produce a fileName with timestamp + original name + extension.
  	// and now we can delegate to the uploaded file and get the client original name
    // now we can format the file however we want.
    // run it through sha1() encryption method. then merge the current time with the file name and then encrypt that.
    // so that would be our name
    // and then we need to get the extension. and we just merge those together to produce a finished fileName
	/**
    * Make a file name, based on the uploaded file.
    *
    * @return string
    */
	protected function makeFileName()
	{
        $name = sha1(
            time() . $this->file->getClientOriginalName()
        );

        $extension = $this->file->getClientOriginalExtension();

        return "{$name}.{$extension}";
    }
}