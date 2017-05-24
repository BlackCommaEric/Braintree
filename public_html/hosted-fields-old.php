<?php require_once("../includes/braintree_init.php"); ?>

<html>
<?php require_once("../includes/head.php"); ?>
<body>
<h1>Hosted Fields</h1>
    <?php require_once("../includes/header.php"); ?>
      <form action="checkout.php" id="hosted-form" method="post">
        <label for="card-number">Card Number</label>
        <div id="card-number"></div>

        <label for="cvv">CVV</label>
        <div id="cvv"></div>

        <label for="expiration-date">Expiration Date</label>
        <div id="expiration"></div>

        <input type="submit" value="Pay" />
      </form>

    <script src="https://js.braintreegateway.com/js/braintree-2.32.0.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.16.0/js/hosted-fields.min.js"></script>
    <script>
    var client_authorization = '<?php echo(Braintree\ClientToken::generate()); ?>';
      braintree.setup(client_authorization, "custom", {
        id: "hosted-form",
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
            selector: "#expiration-date",
            placeholder: "10/2018"
          },
          styles: {
            "#card-number": {
              "font-size": "13px",
              "line-height": "35px"
            },
            "#cvv": {
              'font-size': '13px',
              'line-height': '35px'
            },
            "#expiration-date": {
              'font-size': '13px',
              'line-height': '35px'
            },
            "input.invalid": {
              'color': 'red'
            },
            "input.valid": {
              "color": "green"
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