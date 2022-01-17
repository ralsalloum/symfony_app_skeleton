<?php

namespace App\Service;

use App\AutoMapping;
use App\Request\MapPlaceAutoCompleteRequest;
use App\Response\MapPlaceResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserService
{
    private $autoMapping;
    private $httpClient;

    public function __construct(AutoMapping $autoMapping, HttpClientInterface $httpClient)
    {
        $this->autoMapping = $autoMapping;
        $this->httpClient = $httpClient;
    }

    public function getMapPlace(MapPlaceAutoCompleteRequest $request)
    {
        $url = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input=';

        $url = $url . $request->getInput();

        $key = 'key=AIzaSyDxTV3a6oL6vAaRookXxpiJhynuUpSccjY';

        $url = $url . '&' . $key;

        //dd($url);

        $response = $this->httpClient->request('GET', 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input=Syria&key=AIzaSyDxTV3a6oL6vAaRookXxpiJhynuUpSccjY');

        $jsonResponse = json_decode($response->getContent(), true);

//        $result = $this->autoMapping->map('array', MapPlaceResponse::class, $jsonResponse);

        //dd($result);
        return $jsonResponse;
    }
}