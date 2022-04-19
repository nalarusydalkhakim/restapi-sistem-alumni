<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerEntrepreneur extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'business_name',
        'business_address',
        'business_sector',
        'business_phone',
        'establish_year',
        'capital_source',
        'income',
        'business_matches',
        'completed',
        'expired_date',
    ];
}
