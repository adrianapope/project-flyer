<?php

/**
* Method I call in FlyersController. Pass in message.
* We fetch the flash class out of the container. Which is our file Flash.php
* And then we call a message method on it.
* the message method is just where you call session flash and pass in key and value.
* so in this context, we just pass in the message that we send from the controller.
*/
function flash($title, $message)
{
	$flash = app('App\Http\Flash');

	return $flash->message($title, $message);
}