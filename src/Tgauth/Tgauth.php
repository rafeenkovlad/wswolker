<?php


namespace App\Workerman\Tgauth;


use GuzzleHttp\Client;

class Tgauth implements TgauthInterface
{
    private static Client $guzzle;
    public static function init():TgauthInterface
    {
        $tg = new Tgauth();
        $guzzle = new Client();
        $tg::$guzzle = $guzzle;
        return $tg;
    }

    public function request(string $token)
    {
        return self::$guzzle->request(
                'POST',
                $_ENV['TGAUTH'],
                [
                    'headers' =>
                        [
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer '.$token
                        ],
                    'json'=>[
                        "id" => "req_id",
                        "jsonrpc" => "2.0",
                        "method" => "verifyToken"
                    ]
                ])->getBody()->getContents()."\r\n";
    }
}