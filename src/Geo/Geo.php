<?php


namespace App\Workerman\Geo;


use App\Workerman\Tgauth\Location;
use App\Workerman\Tgauth\User;
use GuzzleHttp\Client;

class Geo implements GeoInterface
{
    private static Client $guzzle;
    public static function init()
    {
        $geo = new Geo;
        $guzzle = new Client();
        $geo::$guzzle = $guzzle;
        return $geo;
    }

    public function request(string $token, Location $location, User $user)
    {
        var_dump($user->id);
        echo self::$guzzle->request(
            'POST',
                $_ENV['GEO'],
                [
                'headers' =>
                    [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer '.$token
                    ],
                'json'=>[
                    "id" => "req_id",
                    "jsonrpc" => "2.0",
                    "method" => "point",
                    'params' =>
                        [
                            "sn" => "$user->id",
                            "point" => [$location->lat,$location->long],
                            "speed" => 0,
                            "date" => (new \DateTime('now'))->format('Y-m-dTH:i:s')
                        ]
                ],
                'success' => function ($response) {
                    echo $response->getBody();
                },
                'error' => function ($exception) {
                    echo $exception;
                }
            ])->getBody()->getContents()."\r\n";
        $user = null;
    }
}