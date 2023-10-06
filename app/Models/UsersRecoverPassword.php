<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UsersRecoverPassword extends Model
{
    protected $table = 'public.users_recover_password';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'token',
        'user_id_fk',
        'expires',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [];
}
