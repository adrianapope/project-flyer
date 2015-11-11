<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;

    /**
    * Every view has a variable called $user and $signIn which might be useful.
	* These will be applicable to any controller.
	*
	*/
    public function __construct()
    {
    	// declare this equals that
    	$this->user = Auth::user();

    	// 'blank' equals this piece of code
    	view()->share('signedIn', Auth::check());

    	// blank' equals this piece of code
		// view()->share('user', Auth::user());
		view()->share('user', $this->user);

    }
}
