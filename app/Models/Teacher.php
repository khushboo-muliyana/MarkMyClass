<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
        protected $fillable = [
        'name', 'email', 'phone', 'gender',
        'qualification', 'join_date',
        'classroom_id', 'photo_path'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

}
