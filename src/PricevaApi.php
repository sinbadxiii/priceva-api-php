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
    /**
     * const base url
     */
    const ENDPOINT_BASE = "https://app.priceva.com/api/v1";

    /**
     * Api Key: generate https://app.priceva.com/ai/client/keg/settings/api
     * @var string
     */
    protected $apiKey;

    /**
     * list errors in fail request
     * @var array
     */
    protected $errors = [];

    /**
     * count errors
     * @var int
     */
    protected $countErrors = 0;

    /**
     * params filter
     * @var
     */
    protected $filter;

    /**
     * PricevaApi constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->apiKey = $config['apiKey'];
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * get list errors
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * get count errors
     * @return int
     */
    public function getCountErrors()
    {
        return $this->countErrors;
    }

    /**
     * set params filter
     * @param $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * get params filter
     * @return array
     */
    public function getFilter()
    {
        return $this->filter;
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
        $products = $this->productList($id, 1, 1, $term);

        return $products->result->objects[0];
    }

    /**
     * get list goods
     *
     * @url POST https://app.priceva.com/api/v1/product/list
     * @param int $page
     * @param int $limit
     * @return mixed
     */

    public function productList($filter = [], $term = true)
    {
        $url = "product/list";

        if ($filter) {
            $this->filter = $filter;
        }

        $filter = (object)[
            'params' =>  (object)[
                'filters' => (object) $this->filter,
                'sources' => (object) [
                    'add_term' => $term
                ]
            ],
        ];

        return $this->request($url, $filter);
    }

    /**
     * reports on goods
     *
     * @url POST https://app.priceva.com/api/v1/report/list
     * @param int $page
     * @param int $limit
     * @return mixed
     *
     */
    public function reportList($filter = [])
    {
        $url = "report/list";

        if ($filter) {
            $this->filter = $filter;
        }

        $filter = (object)[
            'params' =>  (object)[
                'filters' => (object) $filter
            ],
        ];

        return $this->request($url, $filter);
    }

    /**
     * test check access API
     *
     * @url GET https://app.priceva.com/api/v1/main/ping
     * @return array
     */
    public function ping()
    {
        $url = "main/ping";

        return $this->request($url);
    }

    /**
     * create filter array for request
     *
     * @return Filter
     */
    public function createFilter()
    {
        return new Filter($this);
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

        if (!empty($response->errors)) {
            $this->errors      = $response->errors;
            $this->countErrors = $response->errors_cnt;
        }

        return $response;

    }
}