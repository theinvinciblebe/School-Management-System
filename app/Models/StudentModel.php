<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{
    use HasFactory;
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'student_classes', 'student_id', 'class_id')
            ->withPivot('roll'); // To access the roll number
    }

    public function students()
    {
        return $this->belongsToMany(StudentModel::class, 'student_classes', 'class_id', 'student_id')
            ->withPivot('roll');
    }


}
