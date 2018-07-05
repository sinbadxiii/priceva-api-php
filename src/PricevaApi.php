<?php
/**
 *
 * Author: sinbadxiii
 * Date: 05.07.18
 * Time: 11:15
 */

namespace Sinbadxiii\PricevaApi;

class PricevaApi
{

    const ENDPOINT_BASE = "https://app.priceva.com/api/v1";

    protected $client;
    protected $apiKey;

    public function __construct($config)
    {
        $this->apiKey = $config['apiKey'];
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getListProducts()
    {
        $url = "product/list";
        return $this->request($url);
    }


    protected function request($url, $data = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::ENDPOINT_BASE . DS . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Apikey: " . $this->apiKey
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

    }
}