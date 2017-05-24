<?php
require_once('../includes/braintree_init.php');

$nonce = $_POST['payment_method_nonce']; //take "nonce" value from BT servers (which was obtained after the client token was submitted) and assign it to variable $nonce.
$amount = $_POST['amount']; //take the 'amount' value passed in the form and use it to complete the transaction
$fname = $_POST['firstName'];
$lname = $_POST['lastName'];

//These variables will contain something like this: Array ( [amount] => 10 [payment_method_nonce] => c2cd632a-c0cc-0733-1ca0-866ae2c00a8e )


$result = Braintree\Customer::create([
  'firstName' => $fname,
  'lastName' => $lname,
  'creditCard' => [
    'paymentMethodNonce' => $nonce,
    'options' => [
        'verifyCard' => true
      ]
    ]
]);
if ($result->success) {
    echo($result->customer->id);
    echo($result->customer->paymentMethods[0]->token);
} else {
    foreach($result->errors->deepAll() AS $error) {
        echo($error->code . ": " . $error->message . "\n");
    }
}

$customerId = $result->customer->id;
$paymentMethodToken = $result->customer->paymentMethods[0]->token;

$resultTransaction = Braintree\Transaction::sale([ //take resulting sale data from BT servers and create a variable containing all of the object's data. Call each data point with e.g. $result->transaction->amount, etc.
    'amount' => $amount,
    'paymentMethodToken' => $paymentMethodToken,
    'options' => [
        'submitForSettlement' => true, //sets whether the transaction is now final or has been processed to settle
        ]
]);

if ($resultTransaction->success || !is_null($resultTransaction->transaction)) { //if the transaction shows as a success (success = 1) OR if the transaction results are not empty, do the following:
    $transaction = $resultTransaction->transaction; //create a variable that contains all of the transaction result data

    //This object contains the following: Braintree\Transaction[id=n9s927ds, type=sale, amount=10.00, status=submitted_for_settlement, createdAt=Wednesday, 24-May-17 19:10:42 UTC, creditCardDetails=Braintree\Transaction\CreditCardDetails[token=, bin=411111, last4=1111, cardType=Visa, expirationMonth=03, expirationYear=2025, customerLocation=US, cardholderName=, imageUrl=https://assets.braintreegateway.com/payment_method_logo/visa.png?environment=sandbox, prepaid=Unknown, healthcare=Unknown, debit=Unknown, durbinRegulated=Unknown, commercial=Unknown, payroll=Unknown, issuingBank=Unknown, countryOfIssuance=Unknown, productId=Unknown, uniqueNumberIdentifier=, venmoSdk=, expirationDate=03/2025, maskedNumber=411111******1111], customerDetails=Braintree\Transaction\CustomerDetails[id=, firstName=, lastName=, company=, email=, website=, phone=, fax=]]


    header("Location: transaction_hosted.php?id=" . $transaction->id); //send the user to the transaction_hosted.php page with the trsnaction id appended to the URL
} else { //if the above conditions aren't met
    $errorString = ""; //set an empty error string variable

    foreach($resultTransaction->errors->deepAll() as $error) { //for each error message that is found, return the error code returned from BT
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n"; //append to the empty error string (essentially you're creating the string) the following: "Error: <passed error code>: <passed error code message>"
    }

    $_SESSION["errors"] = $errorString;
    header("Location: hosted-fields.php"); //append error string above to url and send back to beginning of transdaction flow
}
