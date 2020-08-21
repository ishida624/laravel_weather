<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Ixudra\Curl\Facades\Curl;

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($city)
    {
        // dd($city);
        $TainanWeather = Curl::to('http://api.openweathermap.org/data/2.5/weather')
            ->withData(['q' => $city, 'appid' => '86b04bc52346e0dd4f59f619ab063349', 'units' => 'metric', 'lang' => 'zh_tw'])
            ->asJsonResponse()
            ->get();
        // dd($TainanWeather);
        $cityname = $TainanWeather->name;
        $temp = $TainanWeather->main;
        $FeelLike = $TainanWeather->main->feels_like;
        $weather = $TainanWeather->weather[0]->description;
        $UpdateTime = date('Y-m-d H:i:s', 1597809600,);

        return response()->json(['name' => $cityname, 'temp' => $temp, 'feel' => $FeelLike, 'weather' => $weather, 'UpdateTime' => $UpdateTime], 201);
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
