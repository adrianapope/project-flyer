<?php

namespace App\Http\Controllers;

use App\Flyer;
use App\Photo;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlyerRequest;
// use App\Http\Controllers\Traits\AuthorizesUsers;
use App\Http\Requests\ChangeFlyerRequest;
use App\Http\Requests;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FlyersController extends Controller
{
    // use AuthorizesUsers;


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
        // flash()->success('Success', 'Your flyer has been created!');

        // redirect to landing page
        return redirect()->back(); // temporary
    }

    /**
    * Apply a photo to the referenced flyer.
    * Uses a dedicated form request called ChangeFlyerRequest.
    * Import the request class up top.
    *
    * @param string $zip
    * @param string $street
    * @param ChangeFlyerRequest $request
    */
    public function addPhoto($zip, $street, ChangeFlyerRequest $request)
    {
        // for trait option we need to import trait class up top and declare trait
        // we would extract methods userCreatedFlyer & unauthorized() to a trait
        // $this->validate($request, [
        //     'photo' => 'required|mime:jpg,jpeg,png,bmp'
        // ]);

        // if (! $this->userCreatedFlyer($request)) {
        //     return $this->unauthorized($request);
        // }

        // if they pass guard, then make a new photo and pass through an uploaded file instance.
        $photo = $this->makePhoto($request->file('photo'));

        // located the current flyer. associate it with this flyer and save it.
        Flyer::locatedAt($zip, $street)->addPhoto($photo);
    }

    /**
    * Put this in the ChangeFlyerRequest.
    * Performs a check to see if user created a particular flyer with this criteria.
    */
    // protected function userCreatedFlyer(Request $request)
    // {
    //     return Flyer::where([
    //         'zip' => $request->zip,
    //         'street' => $request->street,
    //         'user_id' => $this->user->id  // same as Auth::user()->id
    //     ])->exists();
    // }


    /**
     * Give me a new photo object with the current name that we give you and move it to its resting spot in our file system.
     * There is a move() method which moves the photo to the baseDir and then we apply the proper name. Next we create the thumbnail.
     *
     */
   public function makePhoto(UploadedFile $file)
   {
        // return Photo::named($file)->store($file);

        return Photo::named($file->getClientOriginalName())
            ->move($file);
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
