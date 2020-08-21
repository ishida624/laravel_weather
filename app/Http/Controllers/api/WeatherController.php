<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Ixudra\Curl\Facades\Curl;
use App\Weather;
use App\City;
use App\weather as AppWeather;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $response = Curl::to('http://35.185.131.56:8000/api/Token')
        //     ->withData(array('username' => 'admin', 'password' => '00000000'))
        //     ->withResponseHeaders()
        //     ->returnResponseObject()
        //     ->put();
        // // dd($response);
        // $headers = $response->headers;
        // // return $response;
        // return $headers['userToken'];


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $CityId = $request->city_id;
        $CityData = City::find($CityId);
        $lon = $CityData->lon;
        $lat = $CityData->lat;
        $OpenWeather = Curl::to('http://api.openweathermap.org/data/2.5/onecall')
            ->withData(['lon' => $lon, 'lat' => $lat, 'appid' => '86b04bc52346e0dd4f59f619ab063349', 'exclude' => 'current,minutely,hourly', 'units' => 'metric'])
            ->asJsonResponse()
            ->get();
        // dd($OpenWeather->daily);
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
            #create data
            // Weather::create([
            //     'city_id' => $CityId, 'weather' => $weather, 'temp' => $temp,
            //     'temp_feel' => $temp_feel, 'temp_max' => $temp_max, 'temp_min' => $temp_min,
            //     'sunrise' => $sunrise, 'sunset' => $sunset,
            //     'day' => $day,
            // ]);

            #update data
            Weather::where('city_id', $CityId)->where('day', $day)
                ->update([
                    'weather' => $weather, 'temp' => $temp,
                    'temp_feel' => $temp_feel, 'temp_max' => $temp_max, 'temp_min' => $temp_min,
                    'sunrise' => $sunrise, 'sunset' => $sunset,
                ]);
        }
        return response()->json(['name' => $CityName, 'weather' => $weather, 'sunrise' => $sunrise, 'temp' => $temp], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($CityId)
    {

        return response()->json(['name' => $CityName, 'weather' => $weather, 'sunrise' => $sunrise, 'temp' => $temp], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
