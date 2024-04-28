<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class consultation extends Model
{
    use HasFactory;
    protected $fillable=[
        'consultations_name'
    ];

    public function sub(){
        return $this->hasMany('App\Models\Sub_Consultation' , 'consultation_id' , 'id' );
    }
}
