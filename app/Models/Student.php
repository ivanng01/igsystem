<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'name',
        'surname',
        'status',
    ];

    protected $attributes = [
        'status' => 1,
    ];

    //relacion muchos a muchos con materias
    public function subject()
    {
        return $this->belongsToMany(Subject::class);
    }

    //relacion muchos a muchos con cursos
    public function course()
    {
        return $this->belongsToMany(Course::class);
    }

    //relacion muchos a muchos con asistencia
    public function assistance()
    {
        return $this->hasMany(Assistance::class);
    }

    public function observation()
    {
        return $this->hasMany(Observation::class);
    }
}
