<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',  // Add role to fillable attributes
        'photo',
    ];

    protected $appends = [
        'photo_url',
    ];

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id', 'id');
    }

    public function getPhotoUrlAttribute(): string
    {
        // 1. If photo is directly set on the user record
        if (!empty($this->photo) && $this->photo !== 'noimg.jpg') {
            $folder = match ((int) $this->role) {
                1 => 'teachers_image',
                2 => 'students_image',
                3, 4 => 'staffs_image',
                default => 'admin_image',
            };

            if (file_exists(public_path($folder . '/' . $this->photo))) {
                return asset($folder . '/' . $this->photo);
            }

            // Fallback scan other folders
            foreach (['admin_image', 'teachers_image', 'students_image', 'staffs_image'] as $dir) {
                if (file_exists(public_path($dir . '/' . $this->photo))) {
                    return asset($dir . '/' . $this->photo);
                }
            }
        }

        // 2. Check linked role tables if user.photo is not set
        if ((int) $this->role === 1) {
            $teacher = \Illuminate\Support\Facades\DB::table('teacher')->where('user_id', $this->id)->first();
            if ($teacher && !empty($teacher->photo) && $teacher->photo !== 'noimg.jpg' && file_exists(public_path('teachers_image/' . $teacher->photo))) {
                return asset('teachers_image/' . $teacher->photo);
            }
        } elseif ((int) $this->role === 2) {
            $student = \Illuminate\Support\Facades\DB::table('student')->where('user_id', $this->id)->first();
            if ($student && !empty($student->photo) && $student->photo !== 'noimg.jpg' && file_exists(public_path('students_image/' . $student->photo))) {
                return asset('students_image/' . $student->photo);
            }
        } elseif ((int) $this->role === 3 || (int) $this->role === 4) {
            $staff = \Illuminate\Support\Facades\DB::table('staff')->where('user_id', $this->id)->first();
            if ($staff && !empty($staff->photo) && $staff->photo !== 'noimg.jpg' && file_exists(public_path('staffs_image/' . $staff->photo))) {
                return asset('staffs_image/' . $staff->photo);
            }
        }

        // 3. Fallback to default avatar image
        if (file_exists(public_path('user-profile-default.png'))) {
            return asset('user-profile-default.png');
        }
        if (file_exists(public_path('noimg.jpg'))) {
            return asset('noimg.jpg');
        }

        return asset('admin_image/noimg.jpg');
    }

    public function hasRole($role)
    {
        return $this->role === $role; // Example: '0' for admin, '1' for teacher, etc.
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'integer',  // Ensure role is cast as an integer
    ];
}
