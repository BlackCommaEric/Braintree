<html>
<?php require_once("../includes/head.php"); ?>
<?php require_once("../includes/braintree_init.php"); ?>
<body>

<?php
    $paymentMethodToken = $_GET["paymentMethodToken"];
    require_once("../includes/header.php");
    if (isset($_GET["id"])) { //if a transaction id is present in the URL, do the following:
        $customer = Braintree\Subscription::find($_GET["id"]); //retrieve the transaction by its id and set it as the $transaction variable

        if ($subscritpion) { //if the transaction's status ($transaction->status) matches one of the $transactionSuccessStatuses above, use the following information for the page's HTML:
            $header = "Sweet Success!";
            $icon = "success";
            $message = "Your subscription has been successfully processed. See the Braintree API response and try again.";
        } else { //if the transaction's status does not macth one of the $transactionSuccessStatuses above, use the following information for the page's HTML:
            $header = "Subscription Creation Failed";
            $icon = "fail";
            $message = "Your test subscription has a status of " . $customer->status . ". See the Braintree API response and try again."; //display the transaction's status within the page's HTML
        }
    }
?>
<div class="wrapper">
    <div class="response container">
        <div class="content">
            <div class="icon">
            <!-- <img src="/images/<?php echo($icon)?>.svg" alt=""> -->
            </div>

            <h1><?php echo($header)?></h1>
            <section>
                <p><?php echo($message)?></p>
            </section>
            <section>
                <a class="button primary back" href="createSubscription.php">
                    <span>Create Another Subscription</span>
                </a>
            </section>
        </div>
    </div>
</div>

<aside class="drawer dark">
    <header>
        <div class="content compact">
            <a href="https://developers.braintreepayments.com" class="braintree" target="_blank">Braintree</a>
            <h3>API Response</h3>
        </div>
    </header>

    <article class="content compact">
        <section>
            <h5>Subscription Information</h5>
            <table cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>id</td>
                        <td><?php echo($subscription->id)?></td>
                    </tr>
                    <tr>
                        <td>First Name</td>
                        <td><?php echo($subscription->firstName)?></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td><?php echo($subscription->lastName)?></td>
                    </tr>
                    <tr>
                        <td>First Billing Date</td>
                        <td><?php echo($subscription->firstBillingDate)?></td>
                    </tr>
                    <tr>
                        <td>Discounts</td>
                        <td><?php echo($subscription->discounts)?></td>
                    </tr>
                    <tr>
                        <td>Billing Day of Month</td>
                        <td><?php echo($subscription->billingDayOfMonth)?></td>
                    </tr>
                    <tr>
                        <td>balance</td>
                        <td><?php echo($subscription->balance)?></td>
                    </tr>
                    <tr>
                        <td>AddOns</td>
                        <td><?php echo($subscription->addOns)?></td>
                    </tr>
                    <tr>
                        <td>created_at</td>
                        <td><?php echo($subscription->createdAt->format('Y-m-d H:i:s'))?></td>
                    </tr>
                    <tr>
                        <td>updated_at</td>
                        <td><?php echo($subscription->updatedAt->format('Y-m-d H:i:s'))?></td>
                    </tr>
                </tbody>
            </table>
        </section>

         <section>
            <h5>Payment Information</h5>

            <table cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>PaymentMethodToken</td>
                        <td><?php echo($paymentMethodToken)?></td>
                    </tr>
                    <!-- <tr>
                        <td>CVV</td>
                        <td><?php echo($customer->creditCard->cvv)?></td>
                    </tr>
                    <tr>
                        <td>Credit Card Number</td>
                        <td><?php echo($customer->creditCard->number)?></td>
                    </tr>
                    <tr>
                        <td>Expiration Date</td>
                        <td><?php echo($customer->creditCard->expirationDate)?></td>
                    </tr> -->
                </tbody>
            </table>
        </section>
        <section>
            <p class="center small">Integrate with the Braintree SDK for a secure and seamless checkout</p>
        </section>

        <section>
            <a class="button secondary full" href="https://developers.braintreepayments.com/guides/drop-in" target="_blank">
                <span>See the Docs</span>
            </a>
        </section>
    </article>
</aside>


</body>
</html>
