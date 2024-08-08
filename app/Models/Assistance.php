<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'student_id',
        'attended',   //verifico si "asistio" o no.
        'course_id'
    ];

    // Relación muchos a muchos con estudiantes OK
    public function student()
    {
          return $this->belongsTo(Student::class);
    }

    
    
    // Relación muchos a muchos con cursos
    public function course()
    {
        return $this->belongsTo(Course::class);
    }        
}
