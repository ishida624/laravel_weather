<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $table = 'weather';
    // public $incrementing = 'false';
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'city_id', 'weather', 'temp', 'temp_feel', 'temp_min', 'temp_max', 'sunrise', 'sunset', 'day',
    ];
}
