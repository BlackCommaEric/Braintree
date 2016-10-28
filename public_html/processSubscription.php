<?php
require_once("../includes/braintree_init.php");

$planId = $_POST["planId"];
$nonce = $_POST["payment_method_nonce"];


$result = Braintree\Subscription::create([ //take resulting customer data from form on previous page and create a variable containing all of the object's data. Call each data point with e.g. $result->customer->company, etc.
    'planId' => $planId,
    'paymentMethodNonce' => $nonce
]);

if ($result->success || !is_null($result->subscription->id)) { //if the transaction shows as a success (success = 1) OR if the transaction results are not empty, do the following:
    $subscription = $result->subscription; //create a variable that contains all of the transaction result data

    $paymentMethodToken = $subscription->paymentMethods[0]->token;

    header("Location: subscription.php?id=" . $subscription->id . "&" . "paymentMethodToken=" . $paymentMethodToken); //send the user to the transaction_hosted.php page with the trsnaction id appended to the URL
} else { //if the above conditions aren't met
    $errorString = ""; //set an empty error string variable

    foreach($result->errors->deepAll() as $error) { //for each error message that is found, return the error code returned from BT
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n"; //append to the empty error string (essentially you're creating the string) the following: "Error: <passed error code>: <passed error code message>"
    }

    $_SESSION["errors"] = $errorString;
    header("Location: createSubscription.php"); //append error string above to url and send back to beginning of transaction flow to start over
}

//$paymentInfo = Braintree_PaymentMethodNonce::create($result->);
