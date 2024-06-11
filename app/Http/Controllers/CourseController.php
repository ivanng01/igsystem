<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $course = Course::all();
        return view('courses.index', compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valido los datos del formulario
        $request->validate([
            'name' => 'required|string|min:1|max:255',
        ]);

        // Creo un nuevo curso usando el método `create` del modelo
        Course::create($request->all());

        // Redirecciono a la vista el listado de curso
        return redirect()->route('courses.index');  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Valido los datos del formulario
        $request->validate([
            'name' => 'required|string|min:1|max:255',
        ]);

        // Busco el curso por su ID
        $course = Course::findOrFail($id);

        // Actualizo los datos del curso
        $course->update($request->all());

        // Redirecciono a la vista de listado de cursos
        return redirect()->route('courses.index');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('courses.index');
    }
}
