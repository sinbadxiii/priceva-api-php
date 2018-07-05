<?php

namespace Sinbadxiii;

/**
 * Library Priceva API for https://priceva.docs.apiary.io/
 *
 * @package Sinbadxiii
 * @author  Sergey Mukhin <sinbadxiii@gmail.com>
 * @version 1.0
 */

class PricevaApi
{

    const ENDPOINT_BASE = "https://app.priceva.com/api/v1";

    /**
     * Api Key: generate https://app.priceva.com/ai/client/keg/settings/api
     * @var string
     */
    protected $apiKey;

    public function __construct($config)
    {
        $this->apiKey = $config['apiKey'];
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * get one product by $id
     *
     * @param string $id The Id product
     * @param boolean $term sources autput in result
     * @return array
     */
    public function getProduct($id, $term = true)
    {
        $url = "product/list";

        $filter = (object)[
            'params' =>  (object)[
                'filters' => (object)[
                    'active' => 1,
                    'client_code' => [$id]
                    ],
                'sources' => (object) [
                    'add_term' => $term
                ]
            ],
        ];

        $products = $this->request($url, $filter);
        return $products->result->objects[0];
    }

    public function productList($page = 1, $limit = 100)
    {
        $url = "product/list";

        $filter = (object)[
            'params' =>  (object)[
                'filters' => (object)[
                    'page'  => $page,
                    'limit' => $limit,
                    'active' => 1
                    ],
                'sources' => (object) [
                    'add_term' => true
                ]
            ],
        ];

        return $this->request($url, $filter);
    }

    public function reportList($page = 1, $limit = 100)
    {
        $url = "report/list";

        $filter = (object)[
            'params' =>  (object)[
                'filters' => (object)[
                    'page'  => $page,
                    'limit' => $limit,
                    'active' => 1
                    ]
            ],
        ];

        return $this->request($url, $filter);
    }


    /**
     * curl request
     *
     * @param string $url the route
     * @param array $filter The filter request
     * @return mixed
     */
    protected function request($url, $filter = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::ENDPOINT_BASE . '/' . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($filter));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Apikey: " . $this->apiKey
        ));

        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $response;

    }
}