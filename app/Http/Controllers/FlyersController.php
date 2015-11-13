<?php

namespace App\Http\Controllers;

use App\Flyer;
use App\Photo;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlyerRequest;
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
        //Flyer::create($request->all());

        // need to link the user to the flyer
        // get my currently authenticated user and i want them to publish a new flyer
        $flyer = $this->user->publish(
            new Flyer($request->all())
        );

        // flash messaging
        // session()->flash('flash_message', 'Flyer sucessfully created!');
        flash()->success('Success!', 'Your flyer has been created.');

        // goal: we need to redirect to the completed flyer where they can add photos
        // we want to send them to /$flyer->zip/$flyer->street
        // option 1
        // return redirect($flyer->zip . '/'. str_replace(' ', '-', $flyer->street));

        // option 2 create a named route and then we would pass in whats necessary
        // return redirect()->route('flyer_path', [$flyer->zip, $flyer->street]);

        // option 3 NOT RECOMMENDED! add a method directly onto your flyer model.
        // technically probably something you shouldn't do and not the best practice.
        // so in flyer.php we woudld do
        // public function path()
        // {
        //     return redirect($this->zip . '/'. str_replace(' ', '-', $this->street));

        // }
        // and then one benefit is in the flyersController we can now say redirect to the flyer path
        // and the flyer model would be responsible for what its companion uri would be
        // return redirect($flyer->path());
        // option 4, you can always create little helper functions and this can be useful
        // you could say redirect to the flyer path and then you would pass in the flyer here
        // and if that is something you woudl reference throughout this entire project like you are always
        // linking to a particular file then this would be very helpful
        // we autoload a app/helpers.php file in our "files" portion of the composer.json
        return redirect(flyer_path($flyer));
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
