<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Cart;
use Session;
use Mail;
use App\Mail\InvoiceMail;

class PaymentController extends Controller
{
    public function Payment(Request $request)
    {
        $data = [];
        $data = $request->except(["_token"]);
        // // dd($data);

        if ($request->payment == 'stripe') {
            return view('pages.payment.stripe', compact('data'));
        } elseif ($request->payment == 'paypal') {
            # code...
        } elseif ($request->payment == 'ideal') {
            # code...
        } else {
            echo "Cash On Delivery";
        }
    }
    public function buyByStripe(request $request)
    {
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_XHDYe5qHOaEJPOzTRCJXhD4Q00V435DosZ');

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];

        $charge = \Stripe\Charge::create([
            'amount' => 999,
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $token,
            'metadata' => ['order_id' => uniqid()],
        ]);
        dd($charge);
    }
}
