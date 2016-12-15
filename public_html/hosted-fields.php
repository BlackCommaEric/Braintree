<?php require_once("../includes/braintree_init.php"); ?>

<html>
<?php require_once("../includes/head.php"); ?>
<body>
<h1>Hosted Fields</h1>
    <?php require_once("../includes/header.php"); ?>
    <form action="checkout_hosted.php" id="hosted-form" method="post">
<!--       <label for="fname">First Name</label>

      <input id="fname"></input>

      <label for="lname">Last Name</label>
      <input type ="text" id="lname"></input>

      <label for="card-number">Card Number</label>
      <div id="card-number"></div>

      <label for="cvv">CVV</label>
      <div id="cvv"></div>

      <label for="expiration">Expiration Date</label>
      <div id="expiration"></div> -->

      <label for="amount">Amount</label>
      <input id="amount" name="amount" type="tel" min="1" placeholder="Amount" value="10">

      <div id="pp"></div>

      <input type="submit" value="Pay" />
    </form>

    <script src="https://js.braintreegateway.com/js/braintree-2.29.0.min.js"></script>
    <script>
    var client_authorization = '<?php echo(Braintree\ClientToken::generate()); ?>';
      braintree.setup(client_authorization, "custom", {
        id: "hosted-form",
        paypal: {
          container: 'pp',
          singleUse: true,
          amount: 10.00,
          currency: 'USD',
          displayName: 'Store',
          enableShippingAddress: true,
          shippingAddressOverride: {
            recipientName: 'Scruff McGruff',
            streetAddress: '1234 Main St.',
            extendedAddress: 'Unit 1',
            locality: 'Chicago',
            countryCodeAlpha2: 'US',
            postalCode: '60652',
            region: 'IL',
            phone: '123.456.7890',
            editable: false
          }
        },
        hostedFields: {
          number: {
            selector: "#card-number",
            placeholder: "4111 1111 1111 1111"
          },
          cvv: {
            selector: "#cvv",
            placeholder: "123"
          },
          expirationDate: {
            selector: '#expiration',
            placeholder: '10/2018'
          },
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
        },
        function (hostedFieldsErr, hostedFieldsInstance) {
        if (hostedFieldsErr) { // Handle error in Hosted Fields creation
          return;
        }
      }
    });
    </script>
  </body>
</html>