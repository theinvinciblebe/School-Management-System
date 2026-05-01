<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionModel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nick_name', 'class_id', 'teacher_id'];
}
