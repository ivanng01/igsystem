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
    ];

    //relacion muchos a muchos con estudiantes
    public function student()
    {
        return $this->belongsToMany(Student::class); 
        
    }        
}
