@extends('layouts.master')

@section('title')
  Laravel Shopping Cart
@endsection

@section('content')
  @foreach($products->chunk(3) as $productChunk)
   <div class="row">
    @foreach($productChunk as $product)
      <div class="col-md-4 col-sm-6">
        <div class="card">
          <img src="{{ $product->imagePath }}" class="card-img-top img-responsive" alt="Harry Potter Book Poster">
          <div class="card-body">
            <h5 class="card-title">{{ $product->title }}</h5>
            <p class="card-text description"></p>
            <div class="pull-left price">{{ $product->price }}</div>
            <div class="add-to-cart-container">
              <a href="#" class="btn btn-success pull-right">Add to Cart</a>
            </div>
          </div> 
        </div>
      </div>
    @endforeach
   </div>
  @endforeach
@endsection
