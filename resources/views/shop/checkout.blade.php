@extends('layouts.master')

@section('title')
  Laravel Shopping Cart
@endsection

@section('content')
  <div class="row">
    <div class="spinner-border hidden">
    </div>
    <div class="col-sm-6 col-md-4 offset-md-4 offset-sm-3">
      <h1>Checkout</h1>
      <h4>Your Total: {{ $total }}</h4>
      <div id="charge-error" class="alert alert-danger {{ !Session::has('error') ? 'hidden' : '' }}">{{ Session::get('error') }}</div>
      <form action="{{ route('checkout') }}" method="post" id="checkout-form">
        <div class="row">
          <div class="col-xs-12">
            <div class="mb-3">
              <label for="name">Name</label>
              <input type="text" id="name" class="form-control" required>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" id="address" class="form-control" required>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="mb-3">
              <label for="card-name">Card Holder Name</label>
              <input type="text" id="card-name" class="form-control" required>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="mb-3">
              <label for="card-number">Credit Card Number</label>
              <div type="text" id="card-number" class="form-control" required></div>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-12">
                <div class="mb-3">
                  <label for="card-expiry">Expiry</label>
                  <div type="text" id="card-expiry" class="form-control" required></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="mb-3">
              <label for="card-cvc">CVC</label>
              <div type="text" id="card-cvc" class="form-control" required></div>
            </div>
          </div>
        </div>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-success" id="checkout-btn">Buy now</button>
        <p id="card-error" role="alert"></p>
        <p class="result-message hidden">
          Payment succeeded, see the result in your
          <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
      </p>
      </form>
    </div>
  </div>
  @endsection

  @section('scripts') 
  <script src="https://js.stripe.com/v3/">
      let stripePublishableKey = '{{ env("STRIPE_PUBLISHABLE_KEY") }}';
  </script>
  <script type="text/javascript" src="{{ URL::to('src/js/checkout.js') }}"></script>
  @endsection