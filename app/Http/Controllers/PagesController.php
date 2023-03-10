<?php

namespace App\Http\Controllers;

use App\Models\Group;
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
        $customer->load('groups');


        $groups = Group::canAddMembers()
                        ->whereNotIn('id', $customer->groups->pluck('id'))
                        ->paginate(15);
        return view('customers.dashboard', compact('groups', 'customer'));
    }

    

}
