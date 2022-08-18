<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $client = new Client();
        $url = "http://localhost:3000/notifikasi/";
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
        return $responseBody;
    }

    public function getNotifByReceiver(Request $receiverId)
    {
        $client = new Client();
        $url = "http://localhost:3000/notifikasi/" . $receiverId . "/receive";
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
        return $responseBody;
    }

    public function getNotifBySender(Request $senderId)
    {
        $client = new Client();
        $url = "http://localhost:3000/notifikasi/" . $senderId . "/send";
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
        return $responseBody;
    }

    public function store()
    {
        $client = new Client();
        $url = "http://localhost:3000/notifikasi/";
        $response = $client->request('POST', $url, [
            'json' => [
                "senderId" => 1,
                "receiverId" => 2,
                "title" => "Notifikasi 1",
                "message" => "Ini merupakan notifikasi 1",
                "isRead" => false
            ],
        ]);
        $responseBody = json_decode($response->getBody());
        return $responseBody;
    }
}
