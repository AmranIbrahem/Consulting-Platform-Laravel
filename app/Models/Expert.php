<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Expert extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $guard = 'experts';

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'address',
        'mobile',
        'image',
        'balance',
        'price',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        //'remember_token',
        'pivot'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function experiences()
    {
        return $this->hasMany('App\Models\Experience', 'expert_id', 'id');
    }
    public function appointments()
    {
        return $this->hasMany('App\Models\Appointment', 'expert_id', 'id');
    }
    public function getExpertSubconsultation()
    {
        return $this->belongsToMany('App\Models\Sub_Consultation', 'expert__sub__cons', 'expert_id', 'sub_consultation_id', 'id', 'id');
    }

    public function reserved_appointments()
    {
        return $this->hasMany('App\Models\ExpertUser', 'expert_id', 'id');
    }
}
