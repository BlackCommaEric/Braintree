<html>
<?php require_once("../includes/head.php"); ?>
<?php require_once("../includes/braintree_init.php"); ?>
<body>

<?php
    require_once("../includes/header.php");
    if (isset($_GET["id"])) { //if a transaction id is present in the URL, do the following:
        $customer = Braintree\Customer::find($_GET["id"]); //retrieve the transaction by its id and set it as the $transaction variable

        if ($customer) { //if the transaction's status ($transaction->status) matches one of the $transactionSuccessStatuses above, use the following information for the page's HTML:
            $header = "Sweet Success!";
            $icon = "success";
            $message = "Your customer has been successfully processed. See the Braintree API response and try again.";
        } else { //if the transaction's status does not macth one of the $transactionSuccessStatuses above, use the following information for the page's HTML:
            $header = "Customer Creation Failed";
            $icon = "fail";
            $message = "Your test transaction has a status of " . $customer->status . ". See the Braintree API response and try again."; //display the transaction's status within the page's HTML
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
                <a class="button primary back" href="createCustomer.php">
                    <span>Create Another Customer</span>
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
            <h5>Customer Information</h5>
            <table cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>id</td>
                        <td><?php echo($customer->id)?></td>
                    </tr>
                    <tr>
                        <td>First Name</td>
                        <td><?php echo($customer->firstName)?></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td><?php echo($customer->lastName)?></td>
                    </tr>
                    <tr>
                        <td>email</td>
                        <td><?php echo($customer->email)?></td>
                    </tr>
                    <tr>
                        <td>company</td>
                        <td><?php echo($customer->company)?></td>
                    </tr>
                    <tr>
                        <td>phone</td>
                        <td><?php echo($customer->phone)?></td>
                    </tr>
                    <tr>
                        <td>fax</td>
                        <td><?php echo($customer->fax)?></td>
                    </tr>
                    <tr>
                        <td>company</td>
                        <td><?php echo($customer->website)?></td>
                    </tr>
                    <tr>
                        <td>created_at</td>
                        <td><?php echo($customer->createdAt->format('Y-m-d H:i:s'))?></td>
                    </tr>
                    <tr>
                        <td>updated_at</td>
                        <td><?php echo($customer->updatedAt->format('Y-m-d H:i:s'))?></td>
                    </tr>
                </tbody>
            </table>
        </section>

<!--         <section>
            <h5>Payment Information</h5>

            <table cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>paymentMethodNonce</td>
                        <td><?php echo($customer->creditCard->cardholderName)?></td>
                    </tr>
                </tbody>
            </table>
        </section> -->
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
