<?php 
require_once('vendor/autoload.php');
use WdevRs\PhpEsir\Request\Item as Item;

$itm = new Item();

$errorJsonString = '{"message":"Bad Request","modelState":[{"property":"referentDocumentNumber","errors":["2806"]}]}';
$errorArray = json_decode($errorJsonString, true, 15);

var_dump($errorArray);
