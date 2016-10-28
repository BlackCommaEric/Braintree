<?php 

require_once("../includes/braintree_init.php");

?>
<html>
<?php require_once("../includes/head.php"); ?>
<body>

    <?php require_once("../includes/header.php"); ?>

    <div class="wrapper">
        <div class="checkout container">

            <header>
                <h1>Susbcription Creation</h1>
                <p>
                    Create a Subscription
                </p>
            </header>

            <form action="processSubscription.php" id="subscribe-form" method="post">
                <label for="oncepermonth">Bill me once per month - $10 each billing</label>
                <input type="radio" name="planId" value="q7vg"></input>

                <label for="twiceperyear">Bill me once every six months - $50 each billing</label>
                <input type="radio" name="planId" value="69wm"></input>

                <label for="onceperyear">Bill me once per year - $85 each billing</label>
                <input type="radio" name="planId" value="b88b"></input>
                
                <input type="submit" value="Subscribe" />
            </form>

            <script src="https://js.braintreegateway.com/js/braintree-2.29.0.min.js"></script>
            <script>
            var client_authorization = "<?php echo(Braintree\ClientToken::generate()); ?>";
            braintree.setup(client_authorization, "custom", {
                id: "subscribe-form",
                styles: {
                    '#card-number': {
                        'font-size': '13pt',
                        'line-height': '35px'
                    },
                    'input.invalid': {
                        'color': 'red'
                    },
                    'input.valid': {
                        'color': 'green'
                    }
                }
            });
            </script>
        </div>
    </div>
</body>
</html>
