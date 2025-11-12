<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\Student;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        public function attendances()
    {
        return $this->hasMany(Attendance::class, 'teacher_id');
    }

    public function classroom()
    {
        return $this->hasOne(Classroom::class, 'teacher_id'); // correct
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // When user role is updated, sync teacher/student records
        static::updating(function ($user) {
            if ($user->isDirty('role')) {
                $oldRole = $user->getOriginal('role');
                $newRole = $user->role;

                // If changing from teacher to something else, delete teacher record
                if ($oldRole === 'teacher' && $newRole !== 'teacher') {
                    Teacher::where('user_id', $user->id)->delete();
                }

                // If changing from student to something else, delete student record
                if ($oldRole === 'student' && $newRole !== 'student') {
                    Student::where('user_id', $user->id)->delete();
                }

                // If changing to teacher, create teacher record if doesn't exist
                if ($newRole === 'teacher' && !Teacher::where('user_id', $user->id)->exists()) {
                    Teacher::create([
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ]);
                }

                // If changing to student, create student record if doesn't exist
                if ($newRole === 'student' && !Student::where('user_id', $user->id)->exists()) {
                    Student::create([
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ]);
                }
            }
        });

        // When user is created with a role, create corresponding teacher/student record
        static::created(function ($user) {
            if ($user->role === 'teacher' && !Teacher::where('user_id', $user->id)->exists()) {
                Teacher::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
            }

            if ($user->role === 'student' && !Student::where('user_id', $user->id)->exists()) {
                Student::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
            }
        });
    }
}
