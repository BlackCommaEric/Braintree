<?php
require_once("../includes/braintree_init.php");

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$company = $_POST["company"];
$phone = $_POST["phone"];
$fax = $_POST["fax"];
$website = $_POST["website"];
$nonce = "fake-valid-nonce";


$result = Braintree\Customer::create([ //take resulting customer data from form on previous page and create a variable containing all of the object's data. Call each data point with e.g. $result->customer->company, etc.
    'firstName' => $firstName,
    'lastName' => $lastName,
    'company' => $company,
    'email' => $email,
    'phone' => $phone,
    'fax' => $fax,
    'website' => $website,
    'paymentMethodNonce' => $nonce
]);

if ($result->success || !is_null($result->customer->id)) { //if the transaction shows as a success (success = 1) OR if the transaction results are not empty, do the following:
    $customer = $result->customer; //create a variable that contains all of the transaction result data
    header("Location: customer.php?id=" . $customer->id); //send the user to the transaction_hosted.php page with the trsnaction id appended to the URL
} else { //if the above conditions aren't met
    $errorString = ""; //set an empty error string variable

    foreach($result->errors->deepAll() as $error) { //for each error message that is found, return the error code returned from BT
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n"; //append to the empty error string (essentially you're creating the string) the following: "Error: <passed error code>: <passed error code message>"
    }

    $_SESSION["errors"] = $errorString;
    header("Location: createCustomer.php"); //append error string above to url and send back to beginning of transaction flow to start over
}
