<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;
    protected $table="periods";
    protected $fillable=[
        'period_title',
        'period_date_start',
        'period_date_end',
    ];
}
