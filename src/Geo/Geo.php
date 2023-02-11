<?php


namespace App\Workerman\Geo;


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

    public function request(string $token)
    {
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
                            "sn" => "RoutingTest2",
                            "point" => [55.11986383513666,36.64484536136677],
                            "speed" => 100,
                            "date" => "2022-07-26T10:19:23.000+00:00"
                        ]
                ],
                'success' => function ($response) {
                    echo $response->getBody();
                },
                'error' => function ($exception) {
                    echo $exception;
                }
            ])->getBody()->getContents()."\r\n";
    }
}