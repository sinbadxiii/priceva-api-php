# Priceva API PHP

Public API Priceva - Competitor Monitoring Price Tracking Solution https://priceva.com.

# Getting Started

### Requirements
To use this component, you need at least:
 - Composer
 - PHP >= 5.5

NOTE: Support for legacy PHP versions (down to 7.0) is provided on a best-effort basis.

### Installing

#### Composer


```
$ php composer require sinbadxiii/priceva-api-php
```

or create the composer.json file as follows:

```
{
    "require": {
        "sinbadxiii/priceva-api-php": "dev-master"
    }
}
```

# Use

```
$api = new PricevaApi(['apiKey' => 'xxxxxxxxxxxxxx']);

//check access api
$api->ping()

//get all products
$api->productList();

//get one product
$api->getProduct($codeProduct);

//get all report
$api->reportList();

```

If you want to use a filter, you can set the condition in two ways.

The first way is to create an array with filter fields and pass it to the method, for example:

```
$api = new PricevaApi(['apiKey' => 'xxxxxxxxxxxxxx']);

$filter = [
    'limit' => 10,
    'brand_id' => 't'
];

$api->productList($filter);
...
$api->reportList($filter);
```

fields for the filter

```
$filter = [
    'page'        => 1;
    'limit'       => 100;
    'category_id' => [];
    'brand_id'    => [];
    'company_id'  => "";
    'region_id'   => "";
    'active'      => 1;
    'name'        => "";
    'articul'     => "";
    'client_code' => [];
];
```


The second way is to query using the filter constructor createFilter():

```
$api = new PricevaApi(['apiKey' => 'xxxxxxxxxxxxxx']);

$result = $api->createFilter()
              ->setLimit(10)
              ->setPage(2)
              ->setCompany('b')
              ->execute()         //the required method for assembling the filter
              ->productList();
              
...

$result = $api->createFilter()
              ->setLimit(10)
              ->setPage(2)
              ->setCompany('b')
              ->execute()         
              ->reportList();              
                
```

Constructor methods:

- setPage($page);
- setLimit($limit);
- setCategory($category_id);
- setBrand($brand_id);
- setCompany($company_id);
- setRegion($region_id);
- setActive($active);
- setName($name);
- setSku($sku);
- setCodeProduct($client_code);





