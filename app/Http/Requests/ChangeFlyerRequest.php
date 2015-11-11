<?php

namespace App\Http\Requests;

use App\Flyer;
use App\Http\Requests\Request;


/**
* Think of this as representing a user's request to do something.
* We can represent whether the user is authorized to do this in two different ways.
* One, general authorization (authorize section) and two validation (the rules section)
*
*
*/
class ChangeFlyerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Flyer::where([
            'zip' => $this->zip,
            'street' => $this->street,
            'user_id' => $this->user()->id
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
