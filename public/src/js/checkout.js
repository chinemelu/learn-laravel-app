var stripe = Stripe(process.env.STRIPE_PUBLISHABLE_KEY);


var form = document.querySelector('#checkout-form')
var elements = stripe.elements();

form.addEventListener('submit', () => {
  console.log('hi')
  var errorDiv = document.querySelector('#charge-error');
  errorDiv.classList.add('hidden');
  form.getElementsByTagName('button').disabled = true;
  var cardElement = elements.create('card', {
    number: document.querySelector('#card-number').value,
    cvc: document.querySelector('#card-cvc').value,
    exp_month: document.querySelector('#card-expiry-month').value,
    exp_year: document.querySelector('#card-expiry-year').value,
    name: document.querySelector('#card-name').value
  });

  stripe.createToken(cardElement).then((result) =>  {
    if (result.error) {
      errorDiv.classList.remove('hidden');
      errorDiv.textContent = result.error.message;
      form.getElementsByTagName('button').disabled = false;
    } else {
      var token = result.token; 
      var input = document.createElement('input');
      input.type = "hidden";
      input.name = "stripeToken"
      form.append(input).value = token;
      form.submit(); 
    }
  });

})
