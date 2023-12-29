<?php

namespace App\Controllers\Admin\Contact;

use App\Controllers\Base\BaseController;
use GuzzleHttp\Psr7\Request;
use Config\Services;
use GuzzleHttp\Exception\RequestException;

class Contact extends BaseController
{
    public function index()
    {
        $data = array();
        $session = Services::session();
        $client = new \GuzzleHttp\Client();

        $headers = [
            "Authorization" => "Bearer " . $_SESSION['token']
        ];

        $urlContact = getenv('API_URL') . '/jelajah-teknologi-negeri/get-contact';

        $responseContact = $client->get($urlContact, [
            'headers' => $headers
        ]);

        $urlProvider = getenv('API_URL') . '/jelajah-teknologi-negeri/get-provider';

        $responseProvider = $client->get($urlProvider, [
            'headers' => $headers
        ]);


        if ($responseContact->getBody() && $responseProvider->getBody()) {
            $responseContact = $responseContact->getBody()->getContents();
            $resultContact = json_decode($responseContact);
            $data['resultsContact'] = $resultContact->data;
            $responseProvider = $responseProvider->getBody()->getContents();
            $resultProvider = json_decode($responseProvider);
            $data['resultsProvider'] = $resultProvider->data;
            $data['title'] = "Contact";
            return view('contact/index', $data);
        }
    }

    public function create()
    {
        $data = array();

        $session = Services::session();
        $request = Services::request();
       
        $client = new \GuzzleHttp\Client();
        $accessToken = $session->get('token');

        // Payload
        $request = Services::request();
        if ($request->getPost('action') == "save") {
            $contact['phone'] = $request->getPost('nohp');
            $contact['provider_id'] = $request->getPost('provider');
        }else{
            $pattern = '08128192839';
            $patternLength = strlen($pattern);
            $result = '';

            $randomPartLength = 25 - $patternLength;
            for ($i = 0; $i < $randomPartLength; $i++) {
                $result .= mt_rand(0, 9);
            }

            $result = $pattern . $result;
            $contact['phone'] = $result;
            $contact['provider_id'] = $request->getPost('provider');
        }
        
        
        $headers = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " . $accessToken
            ],
            'json' => $contact
        ];

        $url = getenv('API_URL') . '/jelajah-teknologi-negeri/create-contact';

        $response = $client->post($url, $headers);

        if ($response->getBody()) {
            $response = $response->getBody()->getContents();
            $result = json_decode($response);
            return redirect()->to(base_url('admin/contact'));
        }
    }

    public function update($uid)
    {
        $data = array();

        $session = Services::session();
        $request = Services::request();

        $client = new \GuzzleHttp\Client();
        $accessToken = $session->get('token');           

        try {
            // Payload

            $request = Services::request();

            $contact['phone'] = $request->getPost('nohp');
            $contact['provider_id'] = $request->getPost('provider');

            $headers = [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer " . $accessToken
                ],
                'json' => $contact
            ];
            $url = getenv('API_URL') . '/jelajah-teknologi-negeri/update-contact/' . $uid;

            $response = $client->put($url, $headers);

            if ($response->getBody()) {
                $response = $response->getBody()->getContents();
                $result = json_decode($response);
                return redirect()->to(base_url('admin/contact'));
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                $responseBody = $response->getBody()->getContents();
                echo json_encode($responseBody);
                echo "Error Status Code: $statusCode\n";
            } else {
                echo "Request Exception: " . $e->getMessage() . "\n";
            }
        }
    }

    public function delete()
    {
        $data = array();

        $session = Services::session();
        $request = Services::request();

        $client = new \GuzzleHttp\Client();
        $accessToken = $session->get('token');

        try {
            // Payload
            $headers = [
                'headers' => [
                    'Content-Type' => 'application/json',
                    "Authorization" => "Bearer " . $_SESSION['token']
                ],
            ];
            $url = getenv('API_URL') . '/jelajah-teknologi-negeri/delete-contact/' . $request->getPost('uid');

            $response = $client->delete($url, $headers);

            if ($response->getBody()) {
                $response = $response->getBody()->getContents();
                $result = json_decode($response);
                return redirect()->to(base_url('admin/contact'));
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                $responseBody = $response->getBody()->getContents();
                echo json_encode($responseBody);
                echo "Error Status Code: $statusCode\n";
            } else {
                echo "Request Exception: " . $e->getMessage() . "\n";
            }
        }
    }
}
