<form action="transaction.php" id="hosted-form" method="post">
  <label for="card-number">Card Number</label>
  <div id="card-number"></div>
  <label for="cvv">CVV</label>
  <div id="cvv"></div>
  <label for="expiration-date">Expiration Date</label>
  <div id="expiration-date"></div>
  <input type="submit" value="Pay" />
</form>

<script src="https://js.braintreegateway.com/js/braintree-2.29.0.min.js"></script>
<script>
  var clientTokenHosted = "<?php echo(Braintree_ClientToken::generate()); ?>";

  braintree.setup(clientTokenHosted, "custom", {
    id: "hosted-form",
    hostedFields: {
      number: {
        selector: "#card-number"
      },
      cvv: {
        selector: "#cvv"
      },
      expirationDate: {
        selector: "#expiration-date"
      }
    }
  });
</script>