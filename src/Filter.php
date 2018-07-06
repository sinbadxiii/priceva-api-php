<?php

namespace Sinbadxiii;

class Filter {

    public $page;
    public $limit;
    public $category_id;
    public $brand_id;
    public $company_id;
    public $region_id;
    public $active;
    public $name;
    public $articul;
    public $client_code;
    
    protected $pricevaApi;

    public function __construct(PricevaApi $pricevaApi)
    {
        $this->pricevaApi = $pricevaApi;
    }

    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function setCategory($category_id)
    {
        $this->category_id = $category_id;
        return $this;
    }

    public function setBrand($brand_id)
    {
        $this->brand_id = $brand_id;
        return $this;
    }

    public function setCompany($company_id)
    {
        $this->company_id = $company_id;
        return $this;
    }

    public function setRegion($region_id)
    {
        $this->region_id = $region_id;
        return $this;
    }

    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setSku($sku)
    {
        $this->articul = $sku;
        return $this;
    }

    public function setCodeProduct(array $client_code)
    {
        $this->client_code = $client_code;
        return $this;
    }

    public function execute()
    {
        $fields = get_object_vars($this);
        unset($fields['pricevaApi']);
        $this->pricevaApi->setFilter($fields);
        return $this->pricevaApi;
    }


}
