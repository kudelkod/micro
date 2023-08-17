<?php

namespace app\Http\Controllers\Book;

use app\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;

class BookApiController extends Controller
{
    private Client $client;
    public function __construct()
    {
        $this->client = new Client(['verify' => false]);
    }

    /**
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function index(): JsonResponse
    {
        $response = $this->client->get('http://book-service-webserver/api')->getBody()->getContents();
        $data = Json::decode($response);

        return response()->json($data);
    }
}
