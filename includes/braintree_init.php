<?php
session_start();
require_once("../vendor/autoload.php");

$token = substr(md5(rand()), 0, 7);

Braintree\Configuration::environment(getenv('BT_ENVIRONMENT'));
Braintree\Configuration::merchantId(getenv('BT_MERCHANT_ID'));
Braintree\Configuration::publicKey(getenv('BT_PUBLIC_KEY'));
Braintree\Configuration::privateKey(getenv('BT_PRIVATE_KEY'));
