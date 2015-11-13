<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    /**
    * It accepts some sort of relation.
    * Just make sure that the user id equals the current id of the user.
    *
    */
    public function owns($relation)
    {
        return $relation->user_id == $this->id;
    }


    /**
    * A user can have many flyers.
    *
    */
    public function flyers()
    {
        return $this->hasMany('App\Flyer');
    }


    /**
    * Automatically assign the user_id when its saving.
    * References the relationship between user and flyers (see above) and then saves the flyer.
    */
    public function publish(Flyer $flyer)
    {
        return $this->flyers()->save($flyer);
    }
}


