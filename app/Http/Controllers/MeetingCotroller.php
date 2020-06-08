<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Builder;


class MeetingController extends Controller
{
    //
    public function create_access_token(){
      $client_key = env('CLIENT_KEY');
      $client_secret = env('CLIENT_SECRET');

      $signer = new Sha256;
      $time = time();
      $token = (new Builder())->issuedBy($client_key)
                              ->expiresAt($time + 3600)
                              ->getToken($signer,new Key($client_secret));

      return $token;
    }

    public function get_users(){
      $token = $this->create_access_token();
      $request = new Request;
      $api_base_url = 'https://api.zoom.us/v2/';
      $url = 'users';

      $client = new Client([
        'base_uri' => $api_base_url,
      ]);

      $options = [
        'headers' => [
          'Accept' => 'application/json, application/xml',
          'Content-Type' => 'application/json',
          'Authorization' => 'Bearer '.$token
        ]
      ];

      $res = $client->request('GET',$url,$options)->getBody()->getContents();

      $users = json_decode($res,true);

      return $users['users'][0];

    }

    public function get_user_id(){
      $users = $this->get_users();
      return $users['id'];.
    }

    public function create_meeting(){
      $token = $this->create_access_token();



    }

    public function check_file(){

    }
}
