<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PaymentDeliveryController extends Controller
{
    public function paymentDelivery(): View
    {
        return view('payment-delivery');
    }
}
