<?php

namespace App\Http\Controllers;

use App\Flyer;
use App\Photo;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlyerRequest;
use App\Http\Requests\AddPhotoRequest;
use App\Http\Requests;
use Illuminate\Http\Request;


class FlyersController extends Controller
{
    /**
     * Authentication. You can't create a flyer unless you've created an account first.
     *
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);

        // "delegate up" since we have a constructor in our abstract Controller class as well
        parent::__construct();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$flyers = Flyer::all();

        return view('flyers.index', compact('flyers'));*/
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //flash()->overlay('Welcome Aboard!', 'Thank you for signing up.');

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
    * Uses a dedicated form request called AddPhotoRequest.
    *
    * @param string $zip
    * @param string $street
    * @param AddPhotoRequest $request
    */
    public function addPhoto($zip, $street, AddPhotoRequest $request)
    {
        // i like using a named constructor. that way i can new up a photo and pass in the columns essentially
        // or if i wanted to fetch these from (in this case) a file's request then its useful to use a named construcor.
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
