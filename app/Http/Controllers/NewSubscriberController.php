<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewSubscriberController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:customer');
        $this->middleware('check-subscription');
    }


    /**
     * show password change view
     */
    public function changePasswordView() : View
    {
        return view('new-subscription.change-password');
    }


    /**
     * Post route 
     * change password for new subscribers
     */
    public function changePassword(Request $request){

        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);
 
        $user = auth()->user();
        $user->password = bcrypt($request->password);

        $user->should_change_password = false;
        $user->save();
        
        return redirect()->route('dashboard');
    }



    // /**
    //  * show choose groups view
    //  */
    // public function chooseGroupsView() : View
    // {
    //     return view('new-subscription.choose-groups');
    // }


    // /**
    //  * save the groups customer choose
    //  */
    // public function chooseGroups(Request $request){
    //     $request->validate([

    //     ]);

    //     $user = auth()->user();
    //     $user->should_choose_groups = false;
    //     $user->save();


    // }


}









