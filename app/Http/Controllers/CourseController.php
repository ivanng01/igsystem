<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        //$request->has('name');
        $course = Course::all();
        return view('courses.index', compact('course'));
        //return $post;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create'); 
        //return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          // Validar los datos del formulario
          $request->validate([
            'name' => 'required|string|min:1|max:255',
        ]);

         // Crear un nuevo curso usando el método `create` del modelo
        Course::create($request->all());

        // Redireccionar a la vista de listado de curso
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
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|min:1|max:255',
        ]);

        // Buscar el curso por su ID
        $course = Course::findOrFail($id);

        // Actualizar los datos del curso
        $course->update($request->all());

        // Redireccionar a la vista de listado de cursos
        return redirect()->route('courses.index');
        //return redirect()->route('courses.index')->with('success', 'Course updated successfully');
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
