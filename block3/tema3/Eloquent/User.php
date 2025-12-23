<?php

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = ['name', 'email', 'password'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }
}

