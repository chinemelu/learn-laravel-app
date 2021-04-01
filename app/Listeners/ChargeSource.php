<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use Illuminate\Support\Facades\Session;

class ChargeSource implements ShouldQueue
{
    public function handle(WebhookCall $webhookCall)
    {
        // do your work here

        // you can access the payload of the webhook call with `$webhookCall->payload`
        error_log(print_r($webhookCall->payload, true));

        Session::forget('cart');
        return view('shop.shopping-cart');
    }
  }