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
        'company_name',
        'company_address',
        'company_sector',
        'position',
        'contract_status',
        'label',
        'salary',
        'job_matches',
        'start_working',
        'get_job_from',
        'completed',
    ];
}
