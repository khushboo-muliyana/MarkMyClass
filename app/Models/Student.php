<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'roll_number',
        'classroom_id',
        'phone',
        'gender',
        'date_of_birth',
        'guardian_name',
        'address',
        'photo_path',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function classes()
    {
        // alias to pivot table if you use many-to-many
        return $this->belongsToMany(Classroom::class, 'class_student');
    }

    public function attendances()
{
    return $this->hasMany(Attendance::class);
}

}
