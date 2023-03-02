<?php

namespace App\Http\Controllers\OnlineArbitrageLead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct()
    {
        
    }


    public function index(): View 
    { 
        return view('online-arbitrage-lead.checkout');
    }


}
