<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSystem extends Model
{
    use HasFactory;
    protected $table="file_systems";
    protected $fillable = [
        'report_id',
        'file_url',
    ];
}
