<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate; 

class ProductsController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:customer');
        $this->middleware('check-subscription');
        $this->middleware('new-account');
    }


    public function index(Request $request, Group $group){
        Gate::authorize('show-group', $group);

        $subscription = auth()->user()
                                ->subscriptions()
                                ->where('group_id', $group->id)
                                ->firstOrFail();


        $products = $group->amazon_products()
                            ->where('created_at', '>=', $subscription->start_date->toDateString())
                            ->orderBy('created_at', $request->created_at ?? 'desc' )
                            ->paginate(50);

        return view('customers.products.index', compact('group', 'products'));
    }



}
