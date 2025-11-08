<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'section',
        'teacher_id',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(\App\Models\User::class, 'teacher_id');
    }
}
