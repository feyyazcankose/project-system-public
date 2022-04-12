<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table="students";
    protected $fillable = [
        'role_id',
        'tc',
        'student_number',
        'email',
        'name',
        'birth',
        'departman',
        'faculty',
        'university',
        'picture',
        'phone_number',
        'password'
    ];

}
