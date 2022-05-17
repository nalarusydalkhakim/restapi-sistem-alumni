<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'nik',
        'nim',
        'faculty_id',
        'departement_id',
        'entry_year',
        'graduate_year',
        'birth_date',
        'birth_place',
        'gender',
        'address',
        'phone_number',
        'social_media',
        'gpa', //its called ipk in indo :)
        'diploma_number',
        'organization',
        'achievement',
        'photo', 
        'photo_url',
        'identity_card', //ktp
        'identity_card_url',
        'bachelor_certificate', //ijazah
        'bachelor_certificate_url',
        'first',
        'validated',
        'completed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
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
}
