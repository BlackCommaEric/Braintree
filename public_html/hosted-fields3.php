<?php require_once('../includes/braintree_init.php'); ?>

<html>
<?php require_once('../includes/head.php'); ?>
<body>
  <form action='checkout_hosted.php' method='post' id='cardForm'>
    <label class='hosted-fields--label' for='name'>Name</label>
    <input type='text' id='name' class='hosted-field'></div>

    <label class='hosted-fields--label' for='amount'>Amount</label>
    <input type='text' id='amount' name='amount' class='hosted-field'></div>

    <label class='hosted-fields--label' for='card-number'>Card Number</label>
    <div id='card-number' class='hosted-field'></div>

    <label class='hosted-fields--label' for='expiration-date'>Expiration Date</label>
    <div id='expiration-date' class='hosted-field'></div>

    <label class='hosted-fields--label' for='cvv'>CVV</label>
    <div id='cvv' class='hosted-field'></div>

    <div class='button-container'>
    <input type='submit' class='button button--small button--green' value='Purchase' id='submit'/>
    </div>
  </form>
</div>
<script src='https://js.braintreegateway.com/js/braintree-2.32.0.min.js'></script>
<script>
var client_authorization = '<?php echo(Braintree\ClientToken::generate()); ?>';

  braintree.setup(client_authorization, 'custom', {
    id: 'cardForm',
    hostedFields: {
      number: {
        selector: '#card-number',
        placeholder: "4111 1111 1111 1111"
      },
      cvv: {
        selector: '#cvv',
        placeholder: '111'
      },
      expirationDate: {
        selector: '#expiration-date',
        placeholder: 'MM/YY'
      },
      styles: {
        'input': {
          'font-size': '16px',
          'font-family': 'courier, monospace',
          'font-weight': 'lighter',
          'color': '#ccc'
        },
        ':focus': {
          'color': 'black'
        },
        '.valid': {
          'color': '#8bdda8'
        }
      }
    }
  });

</script>

</body>
</html>
