<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertUser extends Model
{
    use HasFactory;

    protected $fillable = [
        "expert_id",
        "user_id",
        "day_date",
        "start_date",
        "end_date",
        "type"
        // "status"
    ];
}