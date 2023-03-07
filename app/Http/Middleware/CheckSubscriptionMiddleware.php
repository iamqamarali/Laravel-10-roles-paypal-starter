<?php

namespace App\Http\Middleware;

use App\Enums\PaypalSubscriptionStatusEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $product_id): Response
    {
        if(!$user = auth()->user())
            return redirect()->route('login');
        
        $subscription = $user->subscriptions()
                            ->where('product_id', $product_id)
                            ->first();

        if($subscription->status == PaypalSubscriptionStatusEnum::ACTIVE)
            return $next($request);


        return redirect('/checkouts/online-arbitrage-lead');
    }

}
