<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class LmsUser extends Model
{
    public $incrementing = false;

    protected $guarded = [];

    public function assignments()
    {
        return $this->hasMany(Assignments::class, 'user_id', 'id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'user_id', 'id');
    }

    public function exceptions()
    {
        return $this->hasMany(Exception::class, 'user_id', 'id');
    }
}
