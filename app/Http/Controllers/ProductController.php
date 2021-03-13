<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Exception;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function getIndex() {
        $products = Product::all();
        return view('shop.index', ['products' => $products]);
    }

    public function getAddToCart(Request $request, $id) {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
        return redirect()->route('product.index');
    }
    public function getCart() {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', [
            'products' => $cart->items, 'totalPrice' => $cart->totalPrice
        ]);
    }
    public function getCheckout() {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        return view('shop.checkout', [
            'total' => $total
        ]);
    }
    public function postCheckout(Request $request) {
        if (!Session::has('cart')) {
            return redirect()->route('shop.shoppingCart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            function calculateOrderAmount(array $items): int {
            // Replace this constant with a calculation of the order's amount
            // Calculate the order total on the server to prevent
            // customers from directly manipulating the amount on the client
                $oldCart=Session::get('cart');
                $cart = new Cart($oldCart);
                $total = $cart->totalPrice;
                return $total;
            }
            header('Content-Type: application/json');
            $YOUR_DOMAIN = 'http://localhost:4242';
            $checkout_session = \Stripe\Checkout\Session::create([
              'mode' => 'payment',
              'success_url' => $YOUR_DOMAIN . '/success.html',
              'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
            ]);
            echo json_encode(['id' => $checkout_session->id]);
        } catch(Exception $err) {

        }
    }
}
