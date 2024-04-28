<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert_Sub_Cons extends Model
{
    use HasFactory;

    protected $fillable=[
       'expert_id',
       'sub_consultation_id'
    ];

    protected $hidden=[
        'pivot'
    ];

}
