<?php
use OpenApi\Generator;

require ("../../vendor/autoload.php");
$openapi = Generator::scan([
    '../../module/Application/src/Controller',
    '../../module/Authentication/src/Controller',
   
]);
// $openapi = \OpenApi\Generator::scan();
header('Content-Type: application/json');
echo $openapi->toJson();