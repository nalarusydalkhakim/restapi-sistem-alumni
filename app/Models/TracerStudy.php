<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerStudy extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'university_name',
        'university_address',
        'study_location',
        'departement',
        'entry_year',
        'graduate_year',
        'study_matches',
        'completed',
        'expired_date',
    ];
}
