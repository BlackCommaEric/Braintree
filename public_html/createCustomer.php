<?php 

require_once("../includes/braintree_init.php"); 

// $result = Braintree_PaymentMethodNonce::create($token);

// echo $result;

?>

<html>
<?php require_once("../includes/head.php"); ?>
<body>

    <?php require_once("../includes/header.php"); ?>

    <div class="wrapper">
        <div class="checkout container">

            <header>
                <h1>Customer Creation</h1>
                <p>
                    Create a Customer for your Braintree Vault
                </p>
            </header>

            <form action="processCustomer.php" id="create-form" method="post">
                <label for="firstName">First Name</label>
                <input id="firstName" name="firstName"></input>

                <label for="lastName">Last Name</label>
                <input id="lastName" name="lastName"></input>
                
                <label for="company">Company</label>
                <input id="company" name="company"></input>

                <label for="email">Email</label>
                <input id="email" name="email"></input>

                <label for="phone">Phone</label>
                <input id="phone" name="phone"></input>

                <label for="fax">Fax</label>
                <input id="fax" name="fax"></input>

                <label for="website">Website</label>
                <input id="website" name="website"></input>

                <h3>Payment Method Details</h3>

                <label for="number">Credit Card Number</label>
                <input id="number" name="number"></input>

                <label for="expirationDate">Expiration Date</label>
                <input id="expirationDate" name="expirationDate"></input>

                <label for="cvv">CVV Code</label>
                <input id="cvv" name="cvv"></input>
                
                <input type="submit" value="Create Customer" />
            </form>
        </div>
    </div>
</body>
</html>
