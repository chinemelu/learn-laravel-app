// A reference to Stripe.js initialized with your real test publishable API key.
const stripe = Stripe("pk_test_51IRa9rJ1R3RjmJWoiDbogU7iVv55OTpFcZiDdvlJwQmUzFpRh0ZNQuKx75KpDtkhrL9ojr9jJmJlrnndpp1zkYaq00OOWUgxKJ");

// The items the customer wants to buy
const purchase = {
  items: [{ id: "xl-tshirt" }]
};

// Disable the button until we have Stripe set up on the page
document.querySelector("button").disabled = true;
fetch("/payment-intent", {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content']
  },
  body: JSON.stringify(purchase)
})
  .then((result) => {
    return result.json();
  })
  .then((data) => {
    console.log(data, 'DAAATAAAAA');
    const elements = stripe.elements();

    const style = {
      base: {
        color: "#32325d",
        fontFamily: 'Arial, sans-serif',
        fontSmoothing: "antialiased",
        fontSize: "16px",
        "::placeholder": {
          color: "#32325d"
        }
      },
      invalid: {
        fontFamily: 'Arial, sans-serif',
        color: "#fa755a",
        iconColor: "#fa755a"
      }
    };

    const cardNumber = elements.create('cardNumber');

    cardNumber.mount('#card-number');

    const cardCvc = elements.create('cardCvc');

    cardCvc.mount('#card-cvc');


    const cardExpiry = elements.create('cardExpiry');

    cardExpiry.mount('#card-expiry')

    const elementsArray = [ cardNumber, cardCvc, cardExpiry ];
    elementsArray.forEach(element => {
      element.on("change", (event) => {
        // Disable the Pay button if there are no card details in the Element
        document.querySelector("button").disabled = event.empty;
        document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
      })
    });

    const form = document.getElementById("checkout-form");
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      // Complete payment when the submit button is clicked
      payWithCard(stripe, cardNumber, data.clientSecret);
    });
  });

// Calls stripe.confirmCardPayment
// If the card requires authentication Stripe shows a pop-up modal to
// prompt the user to enter authentication details without leaving your page.
const payWithCard = (stripe, cardNumber, clientSecret) => {
  loading(true);
  stripe
    .confirmCardPayment(clientSecret, {
      payment_method: {
        card: cardNumber
      }
    })
    .then((result) => {
      if (result.error) {
        // Show error to your customer
        showError(result.error.message);
      } else {
        // The payment succeeded!
        orderComplete(result.paymentIntent.id);
      }
    });
};

/* ------- UI helpers ------- */

// Shows a success message when the payment is complete
const orderComplete = (paymentIntentId) => {
  loading(false);
  document
    .querySelector(".result-message a")
    .setAttribute(
      "href",
      "https://dashboard.stripe.com/test/payments/" + paymentIntentId
    );
  document.querySelector(".result-message").classList.remove("hidden");
  document.querySelector("button").disabled = true;
  fetch("/checkout-success", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content']
    },
    body: JSON.stringify(purchase)
  })
};

// Show the customer the error from Stripe if their card fails to charge
const showError = (errorMsgText) => {
  loading(false);
  const errorMsg = document.querySelector("#card-error");
  errorMsg.textContent = errorMsgText;
  setTimeout(() => {
    errorMsg.textContent = "";
  }, 4000);
};

// Show a spinner on payment submission
const loading = (isLoading) => {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("button").disabled = true;
    document.querySelector(".spinner-border").classList.remove("hidden");
  } else {
    document.querySelector("button").disabled = false;
    document.querySelector(".spinner-border").classList.add("hidden");
  }
};
