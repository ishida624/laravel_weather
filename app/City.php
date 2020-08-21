<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    // public $incrementing = 'false';
    public $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'city_name', 'lon', 'lat',
    ];
    public function weather()
    {
        return $this->hasMany('App\weather');
    }
}
