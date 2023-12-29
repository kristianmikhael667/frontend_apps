<?php

namespace App\Controllers\Admin\Auth;

use App\Controllers\Base\BaseController;
use Config\Services;

class Login extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $request = Services::request();

        $client = new \GuzzleHttp\Client();
        try {
            // Body 
            $auth["email"] = $request->getPost('email');
            $auth["password"] = $request->getPost('password');

            // API
            $url = getenv('API_URL') . '/jelajah-teknologi-negeri/admin-login';

            // Json
            $headers = [
                'json' => $auth
            ];

            $req = $client->post(
                $url,
                $headers
            );

            $response = $req->getBody()->getContents();
            $result = json_decode($response);
            if ($result) {
                echo json_encode(
                    [
                        'status' => $result->status,
                        'sc' => $req->getStatusCode(),
                        'message' => $result->status,
                        'token' => $result->token
                    ]
                );
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            if ($response) {
                $statusCode = $response->getStatusCode();
                if($statusCode === 404){
                    $response = $response->getBody()->getContents();
                    $result = json_decode($response);
                    echo json_encode(
                        [
                            'status' => 'success',
                            'sc' => $statusCode,
                            'message' => $result->meta->message,
                        ]
                    );
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        }
    }

    public function savetoken()
    {
        $data = array();
        $request = Services::request();
        $session = Services::session();
        $data['token'] = $request->getBody('token');
        $session->set('token', $request->getBody('token'));
        echo json_encode(['status' => 'Ok']);
    }

    public function logout()
    {
        $session = Services::session();
        $session->remove('token');
    }
}

