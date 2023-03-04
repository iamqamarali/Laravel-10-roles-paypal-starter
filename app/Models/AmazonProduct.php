<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmazonProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'data',
        'group_id',
    ];

    protected $casts = [
        'data' => 'object',
    ];

    /**
     * relations
     * 
     */

    public function group() : BelongsTo
    {
        return $this->belongsTo(Group::class);
    }



    /**
     * 
     * accessors
     */
    // protected function data(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => json_decode($value, true),
    //         set: fn (string $value) => json_encode($value)
    //     );
    // }

}
