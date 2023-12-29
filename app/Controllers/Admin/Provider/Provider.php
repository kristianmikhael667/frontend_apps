<?php

namespace App\Controllers\Admin\Provider;

use App\Controllers\Base\BaseController;
use GuzzleHttp\Psr7\Request;
use Config\Services;
use GuzzleHttp\Exception\RequestException;

class Provider extends BaseController
{
    public function index()
    {
        $data = array();
        $session = Services::session();
        $client = new \GuzzleHttp\Client();

        $headers = [
            "Authorization" => "Bearer " . $_SESSION['token']
        ];

        $url = getenv('API_URL') . '/jelajah-teknologi-negeri/get-provider';

        $response = $client->get($url, [
            'headers' => $headers
        ]);

        if ($response->getBody()) {
            $response = $response->getBody()->getContents();
            $result = json_decode($response);
            $data['results'] = $result->data;
            $data['title'] = "Provider";
            return view('provider/index', $data);
        }
    }

    public function create()
    {
        $data = array();

        $session = Services::session();
        $request = Services::request();
        $client = new \GuzzleHttp\Client();
        $accessToken = $session->get('token');

        // Upload Image
        $urlImage = getenv('API_URL') . '/media-service/upload';
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept' => 'application/json',
        ];

        // Membuat objek Request dengan multipart data
        $requests = new Request('POST', $urlImage, $headers);

        $body = new \GuzzleHttp\Psr7\MultipartStream([
            [
                'name' => 'file',
                'contents' => fopen($_FILES['image_url']['tmp_name'], 'r'),
                'filename' => $_FILES['image_url']['name'],
            ],
            [
                'name' => 'tags',
                'contents' => 'Banner',
            ],
            [
                'name' => 'description',
                'contents' => 'Banner ' . $request->getPost('caption'),
            ],
        ]);

        $request = $requests->withBody($body);

        try {
            $response_image = $client->send($request);
            $statusCode = $response_image->getStatusCode();
            $responseBody = $response_image->getBody()->getContents();
            $result = json_decode($responseBody);

            // Payload
            $request = Services::request();

            $product['image_url'] = $result->data->links->url;
            $product['caption'] = $request->getPost('caption');
            $product['lauch_url'] = $request->getPost('lauch_url');
            $product['description'] = $request->getPost('description');
            $product['status'] = 1;
            $product['module_type'] = 'module.banner';

            $headers = [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer " . $accessToken
                ],
                'json' => $product
            ];
            $url = getenv('API_URL') . '/media-service/banner';

            $response = $client->post($url, $headers);

            if ($response->getBody()) {
                $response = $response->getBody()->getContents();
                $result = json_decode($response);
                return redirect()->to(base_url('admin/banner'));
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

    public function update($uid)
    {
        $data = array();

        $session = Services::session();
        $request = Services::request();

        $client = new \GuzzleHttp\Client();
        $accessToken = $session->get('token');

        // echo json_encode($_FILES['image_url']['name']);

        if ($_FILES['image_url']['name'] != "") {
            $imgold = $request->getPost('image_url');
            $substringToRemove = "/media-service/image/";
            $imgolder = str_replace($substringToRemove, "", $imgold);
            // Upload Image
            $urlImage = getenv('API_URL') . '/media-service/upload';
            $headers = [
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/json',
            ];

            // Membuat objek Request dengan multipart data
            $requests = new Request('POST', $urlImage, $headers);

            $body = new \GuzzleHttp\Psr7\MultipartStream([
                [
                    'name' => 'file',
                    'contents' => fopen($_FILES['image_url']['tmp_name'], 'r'),
                    'filename' => $_FILES['image_url']['name'],
                ],
                [
                    'name' => 'tags',
                    'contents' => 'Banner',
                ],
                [
                    'name' => 'description',
                    'contents' => 'Banner ' . $request->getPost('caption'),
                ],
            ]);

            $request = $requests->withBody($body);
            $response_image = $client->send($request);
            $statusCode = $response_image->getStatusCode();
            $responseBody = $response_image->getBody()->getContents();
            $result = json_decode($responseBody);

            // Delete Image in aws s3
            $headers_admin = [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer " . $accessToken
                ],
            ];
            $url_delete = getenv('API_URL') . '/media-service/media/' . $imgolder;

            $client->delete($url_delete, $headers_admin);
        }

        try {
            // Payload

            $request = Services::request();

            $banner['image_url'] = $_FILES['image_url']['name'] != "" ? $result->data->links->url : $request->getPost('image_url');
            $banner['caption'] = $request->getPost('caption');
            $banner['lauch_url'] = $request->getPost('lauch_url');
            $banner['description'] = $request->getPost('description');
            $banner['status'] = intval($request->getPost('status'), 10);
            $banner['module_type'] = 'module.banner';

            $headers = [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer " . $accessToken
                ],
                'json' => $banner
            ];
            $url = getenv('API_URL') . '/media-service/banner/' . $uid;

            $response = $client->put($url, $headers);

            if ($response->getBody()) {
                $response = $response->getBody()->getContents();
                $result = json_decode($response);
                return redirect()->to(base_url('admin/banner'));
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
            $url = getenv('API_URL') . '/media-service/banner/' . $request->getPost('uid');

            $response = $client->delete($url, $headers);
            
            // Delete aws s3 image
            $imgold = $request->getPost('image');
            $substringToRemove = "/media-service/image/";
            $imgolder = str_replace($substringToRemove, "", $imgold);

            // Delete Image in aws s3
            $url_delete = getenv('API_URL') . '/media-service/media/' . $imgolder;

            $client->delete($url_delete, $headers);

            if ($response->getBody()) {
                $response = $response->getBody()->getContents();
                $result = json_decode($response);
                return redirect()->to(base_url('admin/banner'));
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
