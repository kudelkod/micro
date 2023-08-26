<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    private Client $client;
    public function __construct()
    {
        $this->client = new Client(['verify' => false]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->input();

        $response = $this->client->post('http://user-service-webserver/api/auth/register', [
            'form_params' => $data
        ])
            ->getBody()
            ->getContents();

        $response = Json::decode($response);

        return response()->json($response);
    }

    public function verifyEmail($token)
    {
        return $this->client->get('http://user-service-webserver/api/email/verify/'.$token)
            ->getBody()
            ->getContents();
    }
}
