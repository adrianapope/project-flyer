<?php

namespace App\Http\Controllers;

use App\Flyer;
use App\Photo;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPhotoRequest;
use App\Http\Requests;
use Illuminate\Http\Request;

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
        // i like using a named constructor. that way i can new up a photo and pass in the columns essentially
        // or if i wanted to fetch these from (in this case) a file's request then its useful to use a named constructor.
        // we'll pass in the photo uploaded file.
        // built up our photo
        // $photo = Photo::fromFile($request->file('photo'))->upload();
        $photo = Photo::fromFile($request->file('photo'));

        // then we pass the photo to our flyer
        // But what about the process where we upload the file to the proper directory?
        // yes we persist it in the database. but we also need to move it to the folder and create the thumbnail.
        // located the current flyer. associate it with this flyer and save it.
        Flyer::locatedAt($zip, $street)->addPhoto($photo);
    }
}
