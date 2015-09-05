<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

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
     * Return the decks associated with this user.
     */
    public function decks()
    {
        return $this->morphToMany('App\Deck', 'deckable')->withPivot('permissions');
    }

    /**
     * Return the sessions associated with this user.
     */
    public function sessions()
    {
        return $this->hasMany('App\Session');
    } 

    /**
     * Return the flashcards that the user has interacted with.
     */
    public function flashcards()
    {
        return $this->morphToMany('App\Flashcard', 'flashcardable')->withPivot('num_correct', 'num_incorrect', 'last_review_time');
    }
}
