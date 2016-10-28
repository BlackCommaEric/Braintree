<?php
require_once("../includes/braintree_init.php");

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$company = $_POST["company"];
$phone = $_POST["phone"];
$fax = $_POST["fax"];
$website = $_POST["website"];
$email = $_POST["email"];
$cvv = $_POST["cvv"];
$number = $_POST["number"];
$expirationDate = $_POST["expirationDate"];
$billingFirstName = $_POST["billingFirstName"];
$billingLastName = $_POST["billingLastName"];
$billingAddress = $_POST["billingAddress"];
$billingPostalCode = $_POST["billingPostalCode"];
$billingCity = $_POST["billingCity"];
$billingState = $_POST["billingState"];
$company = $_POST["company"];
$phone = $_POST["phone"];

//$cId = substr(md5(rand()), 0, 7);

$result = Braintree\Customer::create([ //take resulting customer data from form on previous page and create a variable containing all of the object's data. Call each data point with e.g. $result->customer->company, etc.
    //'id' => $id,
    'firstName' => $firstName,
    'lastName' => $lastName,
    'company' => $company,
    'email' => $email,
    'phone' => $phone,
    'fax' => $fax,
    'website' => $website,
    'creditCard' => [
        'billingAddress' => [
            'firstName' => $billingFirstName,
            'lastName' => $billingLastName,
            'company' => $company,
            'streetAddress' => $billingAddress,
            'locality' => $billingCity,
            'region' => $billingState,
            'postalCode' => $billingPostalCode
        ],
        'cardholderName' => $firstName . "" . $lastName,
        'number' => $number,
        'expirationDate' => $expirationDate,
        'cvv' => $cvv
    ]
]);

if ($result->success || !is_null($result->customer->id)) { //if the transaction shows as a success (success = 1) OR if the transaction results are not empty, do the following:
    $customer = $result->customer; //create a variable that contains all of the transaction result data

    $paymentMethodToken = $customer->paymentMethods[0]->token;

    header("Location: customer.php?id=" . $customer->id . "&" . "paymentMethodToken=" . $paymentMethodToken); //send the user to the transaction_hosted.php page with the trsnaction id appended to the URL
} else { //if the above conditions aren't met
    $errorString = ""; //set an empty error string variable

    foreach($result->errors->deepAll() as $error) { //for each error message that is found, return the error code returned from BT
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n"; //append to the empty error string (essentially you're creating the string) the following: "Error: <passed error code>: <passed error code message>"
    }

    $_SESSION["errors"] = $errorString;
    header("Location: createCustomer.php"); //append error string above to url and send back to beginning of transaction flow to start over
}

//$paymentInfo = Braintree_PaymentMethodNonce::create($result->);
