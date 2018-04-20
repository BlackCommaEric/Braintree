<?php
require_once("../includes/braintree_init.php");

$_SESSION['url'] = $_POST['return_url'];
$url = $_SESSION['url'];
$token = $_POST['token'];

// echo($_SESSION['url']);


$expiration_date = $_POST["expiration_date"]; //take "amount" value from POSTed form data and assign it to variable $amount. Now it has a value, in this case, 10.
$nonce = $_POST["payment_method_nonce"]; //take "nonce" value from BT servers (which was obtained after the client token was submitted) and assign it to variable $nonce.

$result = $gateway->paymentMethod()->update(
  $token,
  [
    'expirationDate' => $expiration_date
  ]
]);

if ($result->success || !is_null($result->transaction)) { //if the transaction shows as a success (success = 1) OR if the transaction results are not empty, do the following:
    $transaction = $result->transaction; //create a variable that contains all of the transaction result data
    header("Location: transaction.php?id=" . $transaction->id); //send the user to the transaction.php page with the trsnaction id appended to the URL
} else { //if the above conditions aren't met
    $errorString = ""; //set an empty error string variable

    foreach($result->errors->deepAll() as $error) { //for each error message that is found, return the error code returned from BT
        $errorString .= 'Error: ' . $error->code . ': ' . $error->message . '\n'; //append to the empty error string (essentially you're creating the string) the following: "Error: <passed error code>: <passed error code message>"
    }

    $_SESSION['errors'] = $errorString;
    header('Location: $url'); //append error string above to url and send back to beginning of transaction flow to start over
}