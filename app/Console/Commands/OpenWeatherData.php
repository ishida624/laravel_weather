<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;
use App\City;
use App\Weather;

class OpenWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetWeatherData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get open weather data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $CityId = 1;        // city id 1 = tainan
        $CityData = City::find($CityId);
        $lon = $CityData->lon;
        $lat = $CityData->lat;
        $OpenWeather = Curl::to('http://api.openweathermap.org/data/2.5/onecall')
            ->withData(['lon' => $lon, 'lat' => $lat, 'appid' => '86b04bc52346e0dd4f59f619ab063349', 'exclude' => 'current,minutely,hourly', 'units' => 'metric'])
            ->asJsonResponse()
            ->get();
        $WeatherData = $OpenWeather->daily;
        $CityName = $CityData->city_name;

        for ($day = 0; $day <= 7; $day++) {
            $weather = $WeatherData[$day]->weather[0]->description;
            $sunrise = date('Y-m-d H:i:s', $WeatherData[$day]->sunrise);
            $sunset = date('Y-m-d H:i:s', $WeatherData[$day]->sunset);
            $temp = $WeatherData[$day]->temp->day;
            $temp_min = $WeatherData[$day]->temp->min;
            $temp_max = $WeatherData[$day]->temp->max;
            $temp_feel = $WeatherData[$day]->feels_like->day;

            #update data
            // Weather::where('city_id', $CityId)->where('day', $day)
            //     ->update([
            //         'weather' => $weather, 'temp' => $temp,
            //         'temp_feel' => $temp_feel, 'temp_max' => $temp_max, 'temp_min' => $temp_min,
            //         'sunrise' => $sunrise, 'sunset' => $sunset,
            //     ]);
            #create data
            Weather::create([
                'city_id' => $CityId, 'weather' => $weather, 'temp' => $temp,
                'temp_feel' => $temp_feel, 'temp_max' => $temp_max, 'temp_min' => $temp_min,
                'sunrise' => $sunrise, 'sunset' => $sunset,
                'day' => $day,
            ]);
        }

        Log::info(['city_name' => $CityName, 'weather' => $weather]);
    }
}
