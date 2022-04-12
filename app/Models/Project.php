<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;



class Project extends Model
{
    use HasFactory;
    use Searchable;
    
    protected $table="projects";
    protected $fillable = [
        'title',
        'goal',
        'material',
        'student_id',
        'teach_id',
        'status',
        'explain',
        'assign_id'
    ];

    public function searchableAs()
    {
        return 'Project';
    }
}
