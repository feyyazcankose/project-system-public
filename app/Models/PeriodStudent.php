<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodStudent extends Model
{
    use HasFactory;
    protected $table="period_students";
    protected $fillable=[
        'period_id',
        'student_id'
    ];
}
