<?php

use App\Flyer;

/**
* Grabs flash and defaults to the level of info.
*/
function flash($title = null, $message = null)
{
	$flash = app('App\Http\Flash');

	if (func_num_args() == 0) {
		return $flash;
	}

	return $flash->info($title, $message);
}

/**
* The path to a given flyer.
* Accepts a flyer object.
*
* @param Flyer $flyer
* @return string
*/
function flyer_path(Flyer $flyer)
{
    return $flyer->zip . '/'. str_replace(' ', '-', $flyer->street);
}
