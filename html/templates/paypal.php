<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('menu.php');
require_once('model/model.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="stylesheet" href="">
</head>

<body>

  <div class="container" style="margin-top: 20vw;">

    <div class="left">
      <div class="product-pic">
        <h1> Passer au mode Pro a partir de 3 euros </h1>
      </div>
      <div class="gallery">

      </div>
    </div>

    <div class="right">
      <div class="bloc">




        <div class="price-infos">
          <div class="price">

          </div>

        </div>

        <div class="description">

        </div>

        <div id="paypal-payment-button"></div>

      </div>
    </div>
  </div>

  <script src="https://www.paypal.com/sdk/js?client-id=ARMF8oM_mbhLxNLp66VvkwgecwMY113CHwa_axGivZ_1Xly-h_8r9Zb0_reTTkd31v-M0LOCn6k7JPX2&currency=EUR"></script>
  <script>
    paypal.Buttons({
      style: {
        color: 'blue'
      },
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: 3.0
            }
          }]
        })
      },
      onApprove: function(data, actions) {
        // This function captures the funds from the transaction.
        return actions.order.capture().then(function(details) {
          console.log(details)
          window.location.replace("index.php?action=success")
        })
      }
    }).render('#paypal-payment-button');
  </script>
</body>

</html>