<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    public $timestamps = false;

    public function reference()
    {
        return $this->hasOne(Catalog::class, 'parent_id', 'reference_id');
    }

    public function children()
    {
        return $this->hasMany(Catalog::class)->with('reference');
    }
}
