<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;

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
        $TainanWeather = Curl::to('http://api.openweathermap.org/data/2.5/weather')
            ->withData(['q' => 'tainan', 'appid' => '86b04bc52346e0dd4f59f619ab063349', 'units' => 'metric', 'lang' => 'zh_tw'])
            ->asJsonResponse()
            ->get();
        $cityname = $TainanWeather->name;
        Log::info($cityname);
        // Log::info($TainanWeather);
        // Log::info("Cron is working fine!");

    }
}
