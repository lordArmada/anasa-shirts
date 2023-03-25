<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clothing Store</title>
  <link rel="stylesheet" href="/src/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>

<body>
  <div class="navbar">
    <a href="index.html">
      <h2>Clothing Store</h2>
    </a>

    <a href="cart.html">
      <div class="cart">
        <i class="bi bi-cart2"></i>
        <div id="cartAmount" class="cartAmount">0</div>
      </div>
    </a>

  </div>
  <form id="paymentForm">
    <div class="form-group">
      <label for="email">Email Address:</label>
      <input type="email" id="email-address" required />
    </div>
    <div class="form-group">
      <label for="amount">Amount:</label>
      <input type="text" id="amount" onclick="setValue()" />
    </div>
    <div class="form-group">
      <label for="first-name">First Name:</label>
      <input type="text" id="first-name" />
    </div>
    <div class="form-group">
      <label for="last-name">Last Name:</label>
      <input type="text" id="last-name" />
    </div>
    <div class="form-submit">
      <button type="submit" onclick="payWithPaystack()"> Pay </button>
    </div>
  </form>

  <script src="https://js.paystack.co/v1/inline.js"></script>
  <script src="/src/cart.js"></script>
  <script src="/src/Data.js"></script>
  <script>
    const paymentForm = document.getElementById("paymentForm");
    paymentForm.addEventListener("submit", payWithPaystack, false);

    function payWithPaystack(e) {
      e.preventDefault();
      let handler = PaystackPop.setup({
        key: "pk_test_623f6cd423f61cafe5da0922d3fab2fd13f86f78", // Replace with your public key
        email: document.getElementById("email-address").value,
        amount: document.getElementById("amount").value * 100,
        firstName: document.getElementById("first-name").value,
        lastName: document.getElementById("last-name").value,
        ref: "Tr" + Math.floor(Math.random() * 1000000000 + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
        // label: "Optional string that replaces customer email"
        onClose: function() {
          window.location = "/index.html";
          alert("Transaction Cancelled!.");
        },
        callback: function(response) {
          let message = "Payment complete! Reference: " + response.reference;
          alert(message);
          window.location =
            "http://localhost:3000/php/verify.php?reference=" + response.reference;
        },
      });

      handler.openIframe();
    }
  </script>


</body>

</html>