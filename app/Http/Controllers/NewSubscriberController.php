<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NewSubscriberController extends Controller
{   

    public function changeNewAccountPassword(Request $request, $user, $paypal_subscription_id){

        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::findOrFail($user);
        $subExists = $user->subscriptions()
                    ->where('paypal_subscription_id', $paypal_subscription_id)
                    ->exists();
        if(!$subExists){
            return abort(403, 'Unauthorized action.');
        }

        $user->password = bcrypt($request->password);
        $user->save();
        
        return route('login'); 
    }



}
