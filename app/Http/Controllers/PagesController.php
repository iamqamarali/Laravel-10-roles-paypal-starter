<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:customer');
        $this->middleware('check-subscription');
        $this->middleware('new-account');
    }



    public function dashboard(){ 
        $customer = auth()->user();
        $group = $customer->groups[0];

        $sub = $customer->subscriptions()->active()->first();

        $products = $group->amazon_products()
                        ->where('created_at', '>=', $sub->start_date)
                        ->paginate(20);

        return view('customers.dashboard')
                    ->withProducts($products);
    }

}
