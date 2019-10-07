<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(LmsUser::class, 'id', 'user_id');
    }
}
