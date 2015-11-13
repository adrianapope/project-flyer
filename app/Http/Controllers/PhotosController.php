<?php

namespace App\Http\Controllers;

use App\Flyer;
use App\AddPhotoToFlyer;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPhotoRequest;

class PhotosController extends Controller
{
    /**
    * Apply a photo to the referenced flyer.
    * Uses a dedicated form request called AddPhotoRequest.
    *
    * @param string $zip
    * @param string $street
    * @param AddPhotoRequest $request
    */
    public function store($zip, $street, AddPhotoRequest $request)
    {
    	// find our flyer
        $flyer = Flyer::locatedAt($zip, $street);

      	// store the photo which will be just the UploadedFile instance
        $photo = $request->file('photo');

        // we'll have a dedicated class like AddPhotoToFlyer and it will accept the flyer and the photo upload
        // and if that's its own instance, then we need to new it up and call a save method on it
        // this is an alternative way to do this.
        // if we wanted to treat this as a form object, you could even do your validation within that class rather than here, but in this case its so easy im just going to leave it in
        // and you would no longer need the AddPhotoRequest here.
        // we need to create this. we'll put it in app/Forms/AddPhotoToFlyer
        // we put this in Forms because we are treating this as a forms object
        // or i might have a more dedicated namespace like app/Flyers/AddPhotoToFlyer
        // or if you want you could put it in app/AddPhotoToFlyer and that would be okay too. thats what we will do here.
        (new AddPhotoToFlyer($flyer, $photo))->save();


        // i like using a named constructor. that way i can new up a photo and pass in the columns essentially
        // or if i wanted to fetch these from (in this case) a file's request then its useful to use a named constructor.
        // we'll pass in the photo uploaded file.
        // built up our photo
        // $photo = Photo::fromFile($request->file('photo'))->upload();
        //$photo = Photo::fromFile($request->file('photo'));

        // then we pass the photo to our flyer
        // But what about the process where we upload the file to the proper directory?
        // yes we persist it in the database. but we also need to move it to the folder and create the thumbnail.
        // located the current flyer. associate it with this flyer and save it.
        //Flyer::locatedAt($zip, $street)->addPhoto($photo);
    }
}




