<?php require_once("../includes/braintree_init.php"); ?>

<html>
<?php require_once("../includes/head_bs.php"); ?>
<body>

    <?php require_once("../includes/header.php"); ?>

    <div class="wrapper">
        <div class="checkout container">

            <header>
                <h1>Hi, <br>Let's test a transaction</h1>
                <p>
                    Make a test payment with Braintree using PayPal or a card
                </p>
            </header>

            <form method="post" id="update-payment-method-form" action="update-payment-method.php">
                <section>
                    <label for="expiration_date">
                        <span class="input-label">Expiration Date</span>
                        <div class="input-wrapper amount-wrapper">
                            <input id="expiration_date" name="expiration_date" type="tel" min="1" placeholder="Expiration Date" value="">
                        </div>
                    </label>
                    <label for="token">
                        <span class="input-label">Token</span>
                        <div class="input-wrapper amount-wrapper">
                            <input id="token" name="token" type="tel" min="1" placeholder="Token" value="dy92yc">
                        </div>
                    </label>

          

                    <div class="bt-drop-in-wrapper">
                        <div id="bt-dropin"></div>
                    </div>
                </section>

                <input id="nonce" name="payment_method_nonce" type="hidden" />
                <input id="returnUrl" name="return_url" type="hidden" />
                <button class="button" type="submit"><span>Test Transaction</span></button>
            </form>
        </div>
    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.10.0/js/dropin.min.js"></script>
    <script>
        var form = document.querySelector('#update-payment-method-form');
        var client_token = "<?php echo($gateway->ClientToken()->generate()); ?>";
        braintree.dropin.create({
          authorization: client_token,
          selector: '#bt-dropin',
          paypal: {
            flow: 'vault',
            amount: '10',
            currency: 'USD'
          }
        }, function (createErr, instance) {
          if (createErr) {
            console.log('Create Error', createErr);
            return;
          }
          form.addEventListener('submit', function (event) {
            event.preventDefault();
            instance.requestPaymentMethod(function (err, payload) {
              if (err) {
                console.log('Request Payment Method Error', err);
                return;
              }
              // Add the nonce to the form and submit
              document.querySelector('#nonce').value = payload.nonce;
              document.querySelector('#returnUrl').value = location.href.split("/").slice(-1);
              document.querySelector('#token').value = payload.token;
              document.querySelector('#expiration_date').value = payload.expiration_date;
              form.submit();
            });
          });
        });
    </script>
    <script src="javascript/demo.js"></script>
</body>
</html>