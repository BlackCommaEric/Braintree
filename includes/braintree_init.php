<?php
session_start();
require_once("../vendor/autoload.php");

$gateway = new Braintree_Gateway([
    'environment' => 'sandbox',
    'merchantId' => 's3mj6vssjy3tfsn7',
    'publicKey' => 'bj94n2qqxp4chcwm',
    'privateKey' => '00ba9b602a9f536e9c6ac094f57a65d2'
]);
