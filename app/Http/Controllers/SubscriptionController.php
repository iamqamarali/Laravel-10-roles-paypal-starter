<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{   

    public function __construct()
    {
        
    }


    public function initiateSubscription(Request $request)
    {        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',            
        ]);

        $product = Product::first();

        $provider = new \Srmklive\PayPal\Services\PayPal(config('paypal'));
        $provider->getAccessToken();

 
        $data = json_decode('{
            "plan_id": "'.$product->paypal_plan_id.'",
            "quantity": "1",
            "subscriber": {
            "name": {
                "given_name": "Qamar",
                "surname": "Ali"
            },
            "email_address": "qamar@example.com"
            },
            "application_context": {
                "brand_name": "Fbacity",
                "locale": "en-US",
                "shipping_preference": "NO_SHIPPING",
                "user_action": "SUBSCRIBE_NOW",
                "return_url": "http://localhost:8000/paypal-success",
                "cancel_url": "https://localhost:8000/paypal-cancel"
            }
        }', true);

        $subscription = $provider->createSubscription($data);

        return redirect($subscription['links'][0]['href']);
    }


    /**
     * 
     * (Paypal Return URL) if the subscription succeed
     */
    public function success(Request $request): View
    {
        // $provider = new \Srmklive\PayPal\Services\PayPal(config('paypal'));
        // $provider->getAccessToken();
        // $subscription = $provider->showSubscriptionDetails($request->subscription_id);  

        // // fetch the product to attach to user subscription
        // $product = Product::where('paypal_plan_id', $subscription['plan_id'])->first();
        
        // $sub = Subscription::create([
        //     'status' => $subscription['status'],
        //     'paypal_subscription_id' => $subscription['id'],
        //     'paypal_plan_id' => $product->paypal_plan_id,
        //     'product_id' => $product->id,
        //     'price' => $product->price,
        // ]);
            $sub = null;
        
        return view('subscription.success')
                    ->with('subscription', $sub);
    }


    /**
     * 
     * (Paypal Return URL) if the subscription failed
     */
    public function failed(Request $request): View
    {
        $provider = new \Srmklive\PayPal\Services\PayPal(config('paypal'));
        $provider->getAccessToken();
        $subscription = $provider->showSubscriptionDetails($request->subscription_id);

        return view('subscription.failed')
                    ->with('subscription', $subscription);
    }



}
