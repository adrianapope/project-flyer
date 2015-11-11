<?php

namespace App\Http\Controllers\Traits;

use App\Flyer;
use Illuminate\Http\Request;

trait AuthorizesUsers {

    /**
     * We check to see if user created the flyer by doing an "exist check."
     * Check to see if a record with this criteria exists. Does not grab flyer.
     *
     */
    public function userCreatedFlyer(Request $request)
    {
        return Flyer::where([
            'zip' => $request->zip,
            'street' => $request->street,
            'user_id' => $this->user->id
        ])->exists();
    }

    /**
     * If we do need to return with an unauthorized request, then we
     * check to see if its ajax and we return json with a status code of 403.
     * otherwise we display a flash message and redirect.
     *
     */
    public function unauthorized(Request $request)
    {
        if ($request->ajax()) {
            return response(['message' => 'No way'], 403);
        }

        flash('No way.');

        return redirect('/');
    }
}
