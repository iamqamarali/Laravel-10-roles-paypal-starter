<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * roles authenticated methods
     */
    public function syncRoles($roles) : void
    {
        if(is_string($roles))
            $roles = explode('|', $roles);

        $this->roles = implode('|', $roles);
        $this->save();
    }

    public function getRoles() : array
    {
        return explode('|', $this->roles);
    }

    public function hasRole(mixed $role) : Bool
    {
        return $this->hasAnyRole($role);
    }

    public function hasAnyRole(mixed $roles) : Bool
    {
        if(is_string($roles))
            $roles = explode('|', $roles);

        return count(array_intersect($roles, $this->getRoles())) > 0;
    }



}
