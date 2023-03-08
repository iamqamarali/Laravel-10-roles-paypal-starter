<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',

        'temp_subscription_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'roles', // super-admin|admin|editor|customer|
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function($user){            
            $user->new_account = true;
        });

        static::saving(function ($user) {
            $user->name = $user->first_name . ' ' . $user->last_name;
        });
    }



    /**
     * relations
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class,);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_group', 'user_id', 'group_id');
    }



    /**
     * scopes
     */




    /**
     * methods
     */
    public function hasActiveSubscription(){
        return $this->subscriptions()->where('status', \App\Enums\PaypalSubscriptionStatusEnum::ACTIVE->toString())->exists();
    }


}
