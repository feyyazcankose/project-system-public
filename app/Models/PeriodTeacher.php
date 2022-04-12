<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodTeacher extends Model
{
    use HasFactory;
    protected $table="period_teachers";
    protected $fillable=[
        'period_id',
        'teacher_id'
    ];
}
