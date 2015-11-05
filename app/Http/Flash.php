<?php

namespace App\Http;

// rather than hard coding a simple string as the value, we can make it equal to an arary that has the specifics of the flash message

class Flash {

	public function message($title, $message)
	{
		session()->flash('flash_message', [
			'title' => $title,
			'message' => $message,
		]);
	}
}


// store the key here as flash_message
// the value will be $message


// $flash->message('hello');
// $flash->error('hello');
// $flash->aside('hello');
// $flash->overlay('hello');
// $flash->success('hello');