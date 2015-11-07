<?php

namespace App\Http\Controllers;

use App\Flyer;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\FlyerRequest;
use App\Http\Controllers\Controller;

class FlyersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        flash()->overlay('Welcome Aboard!', 'Thank you for signing up.');

        return view('flyers.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  FlyerRequest $request
     * @return Response
     */
    public function store(FlyerRequest $request)
    {
        // validate the form
        // this is done through FlyerRequest not here

        // persist the flyer
        // that'll be an array that maps to the columns
        Flyer::create($request->all());

        // flash messaging
        // session()->flash('flash_message', 'Flyer sucessfully created!');
        flash()->success('Success', 'Your flyer has been created!');

        // redirect to landing page
        return redirect()->back(); // temporary
    }

    /**
    * Apply a photo to the referenced flyer.
    *
    *
    * @param string $zip
    * @param string $street
    * @param Request $request
    */
    public function addPhoto($zip, $street, Request $request)
    {
        // quick validation to make sure its a photo
        // make sure we are getting a photo uploaded by specifying accepted  mime types
        // require a photo. so that is the require key word
        // call the validate method on request
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png,bmp'
        ]);

        // how do we grab a photo?
        // we'll accept the request object
        // when you are dealing with file uploads you can use the request file method and
        // then reference the field name. or the paramName. by default its called file. but you can change it.
        // this will be an instance of the UploadedFile class
        // there are other methods available throught the UploadedFile class
        // get the uploaded file instance
        // $file = ($request->file('file'));
        // $file = ($request->file('photo'));

        // set up a file name. rename file to something unique with a timetamp before the orignal name
        // $name = time() . $file->getClientOriginalName();

        // on file instance, there is a move method which you can give it the directory
        // that you want to move it to as well as the file name that you want to use
        // we gotta be careful that new photos dont replace existing photos with the same name
        // so we'll apply some sort of prefix
        // move the temporary image to its new resting space
        // $file->move('path', 'file-name');
        // $file->move('flyers/photos', $name);

        // so if we are going to save a photo, we need a photo instance
        // we'll use a static constructor where i'm saying i'm building up a new photo
        // but im getting all the information from a form
        $photo =  Photo::fromForm($request->file('photo'));

        // find the current flyer
        // $flyer = Flyer::locatedAt($zip, $street);

        // find current flyer. and add photo to it. we pass in the photo object.
        Flyer::locatedAt($zip, $street)->addPhoto($photo);

        // we will add a photo to the flyer
        // reference the relationship and say create a new one
       /* $flyer->photos()->create([
            'path' => "/flyers/photos/{$name}"
        ]);
*/
        return 'Done';
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($zip, $street)
    {
        // grabs the first address with a zip of this and street of that
        $flyer = Flyer::locatedAt($zip, $street);

        return view('flyers.show', compact('flyer'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
