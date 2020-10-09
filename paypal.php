<!-- reference: https://developer.paypal.com/docs/checkout/quick-start/ -->
<div id="paypal-button-container"></div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  var total_price=document.getElementById('total_price').innerHTML; //To get the total price of the product

  //added new
   function openPage(cid) {//function to redirect into a new page
    var urlpage='addorder.php?cid='+cid; //url added to a variable with cart id
    document.location.href=urlpage; //code to redirect to the page
  } 
  //added new 

// Render the PayPal button
paypal.Button.render({
// Set your environment
env: 'sandbox', // sandbox | production

// Specify the style of the button
style: {
  layout: 'vertical',  // horizontal | vertical
  size:   'medium',    // medium | large | responsive
  shape:  'rect',      // pill | rect
  color:  'gold'       // gold | blue | silver | white | black
},

// Specify allowed and disallowed funding sources
//
// Options:
// - paypal.FUNDING.CARD
// - paypal.FUNDING.CREDIT
// - paypal.FUNDING.ELV
funding: {
  allowed: [
    paypal.FUNDING.CARD,
    paypal.FUNDING.CREDIT
  ],
  disallowed: []
},

// Enable Pay Now checkout flow (optional)
commit: true,

// PayPal Client IDs - replace with your own
// Create a PayPal app: https://developer.paypal.com/developer/applications/create
client: {
  sandbox: 'AZDxjDScFpQtjWTOUtWKbyN_bDt4OgqaF4eYXlewfBP4-8aqX3PiV8e1GWU6liB2CUXlkA59kJXE7M6R',
  production: '<insert production client id>'
},

payment: function (data, actions) {
  return actions.payment.create({
    payment: {
      transactions: [
        {
          amount: {
            total: total_price,
            currency: 'GBP'
          }
        }
      ]
    }
  });
},

onAuthorize: function (data, actions) {
  return actions.payment.execute()
    .then(function () {
      window.alert('Payment Complete!');
      openPage(<?php echo $cart_id ?>);//openPage function is called with cart id as argument
    });
}
}, '#paypal-button-container');
</script>