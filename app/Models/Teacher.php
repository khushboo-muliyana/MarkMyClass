<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Classroom;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'qualification',
        'join_date',
        'classroom_id',
        'photo_path'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

        // Link teacher to a User login record
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
