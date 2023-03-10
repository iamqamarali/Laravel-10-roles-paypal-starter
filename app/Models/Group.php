<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];


    /**
     * 
     * 
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_group');
    }

    public function amazon_products()
    {
        return $this->hasMany(AmazonProduct::class);
    }


    /**
     * 
     * Scopes
     */
    public function scopeCanAddMembers($query){
        return $query->has('users', '<', 15);
    }


}
