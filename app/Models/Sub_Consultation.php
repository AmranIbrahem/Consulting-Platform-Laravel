<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Consultation extends Model
{
    use HasFactory;
    protected $fillable = [
      'consultation_id',
      'sub_cons_name'
    ];

        protected $hidden=[
        'pivot'
    ];

    public function getExperts(){
        return $this->belongsToMany('App\Models\Expert', 'expert__sub__cons' , 'sub_consultation_id' , 'expert_id' , 'id' , 'id');
    }
}
