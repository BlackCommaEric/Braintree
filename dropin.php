<form id="checkout" method="post" action="transaction.php">
  <div id="payment-form"></div>
  <input type="submit" value="Pay $10">
</form>

<script src="https://js.braintreegateway.com/js/braintree-2.29.0.min.js"></script>
<script>
// We generated a client token for you so you can test out this code
// immediately. In a production-ready integration, you will need to
// generate a client token on your server (see section below).
var clientToken = "<?php echo(Braintree_ClientToken::generate()); ?>";

braintree.setup(clientToken, "dropin", {
  container: "payment-form",
  paypal: {
    button: {
      type: 'checkout'
    }
  }
});
</script>