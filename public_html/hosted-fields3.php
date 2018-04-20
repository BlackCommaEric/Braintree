<?php require_once('../includes/braintree_init.php'); ?>

<html>
<?php require_once('../includes/head.php'); ?>
<body>
  <div id="paypal-button"></div>
  
    <form action="checkout_hosted.php" id="cardForm" method="post">
      <label for="card-number">Card Number</label>
      <div id="card-number"></div>

      <label for="cvv">CVV</label>
      <div id="cvv"></div>

      <label for="expiration-date">Expiration Date</label>
      <div id="expiration-date"></div>

      <input type="submit" value="Pay" disabled />
    </form>


    <script src="https://js.braintreegateway.com/web/3.31.0/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.31.0/js/hosted-fields.min.js"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js" data-version-4 log-level="warn"></script>
    <script src="https://js.braintreegateway.com/web/3.31.0/js/paypal-checkout.min.js"></script>

    <script>
      var form = document.querySelector('#cardForm');
      var submit = document.querySelector('input[type="submit"]');
      var client_authorization = '<?php echo($gateway->clientToken()->generate()); ?>';

      // Create a client.
      braintree.client.create({
        authorization: CLIENT_AUTHORIZATION
      }, function (clientErr, clientInstance) {
      // Stop if there was a problem creating the client.
      // This could happen if there is a network error or if the authorization
      // is invalid.
      if (clientErr) {
        console.error('Error creating client:', clientErr);
        return;
      }

      //Hosted Fields portion

      braintree.hostedFields.create({
          client: clientInstance,
          styles: {
            'input': {
              'font-size': '14px'
            },
            'input.invalid': {
              'color': 'red'
            },
            'input.valid': {
              'color': 'green'
            }
          },
          fields: {
            number: {
              selector: '#card-number',
              placeholder: '4111 1111 1111 1111'
            },
            cvv: {
              selector: '#cvv',
              placeholder: '123'
            },
            expirationDate: {
              selector: '#expiration-date',
              placeholder: '10/2019'
            }
          }
        }, function (hostedFieldsErr, hostedFieldsInstance) {
          if (hostedFieldsErr) {
            console.error(hostedFieldsErr);
            return;
          }

          submit.removeAttribute('disabled');

          form.addEventListener('submit', function (event) {
            event.preventDefault();

            hostedFieldsInstance.tokenize(function (tokenizeErr, payload) {
              if (tokenizeErr) {
                console.error(tokenizeErr);
                return;
              }

              // If this was a real integration, this is where you would
              // send the nonce to your server.
              console.log('Got a nonce: ' + payload.nonce);
            });
          }, false);
        });


      // PayPal portion

      braintree.paypalCheckout.create({
        client: clientInstance
      }, function (paypalCheckoutErr, paypalCheckoutInstance) {
      // Stop if there was a problem creating PayPal Checkout.
      // This could happen if there was a network error or if it's incorrectly
      // configured.
      if (paypalCheckoutErr) {
        console.error('Error creating PayPal Checkout:', paypalCheckoutErr);
        return;
      }
      // Set up PayPal with the checkout.js library
      paypal.Button.render({
      env: 'sandbox', // or 'sandbox'

      payment: function () {
        return paypalCheckoutInstance.createPayment({
          // Your PayPal options here. For available options, see
          // http://braintree.github.io/braintree-web/current/PayPalCheckout.html#createPayment
        });
      },

      onAuthorize: function (data, actions) {
        return paypalCheckoutInstance.tokenizePayment(data)
          .then(function (payload) {
            // Submit `payload.nonce` to your server.
          });
      },

      onCancel: function (data) {
        console.log('checkout.js payment cancelled', JSON.stringify(data, 0, 2));
      },

      onError: function (err) {
        console.error('checkout.js error', err);
      }
    }, '#paypal-button').then(function () {
      // The PayPal button will be rendered in an html element with the id
      // `paypal-button`. This function will be called when the PayPal button
      // is set up and ready to be used.
      });
    });
  });

    </script>
  </body>
</html>
