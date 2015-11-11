<?php

namespace App\Http\Requests;

use App\Flyer;
use App\Http\Requests\Request;


/**
* Think of this as representing a user's request to do something.
* We can represent whether the user is authorized to do this in two different ways.
* One, general authorization (authorize section) and two validation (the rules section)
* We can delete the validation in our FlyersController because rules() will take care of it.
* Since we are in a request object, we can replace $request->zip with $this->zip and so on.
*/
class ChangeFlyerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * $this refers to $request
     *
     * @return bool
     */
    public function authorize()
    {
        return Flyer::where([
            'zip' => $this->zip,
            'street' => $this->street,
            'user_id' => $this->user()->id  // same as $request->user()->id
        ])->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'photo' => 'required|mimes:jpg,jpeg,png,bmp'
        ];
    }
}
