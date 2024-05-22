<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;


class SubjectController extends Controller
{
    public function index()
    {
        //$request->has('name');
        $subject = Subject::all();
        return view('subjects.index', compact('subject'));
        //return $post;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subjects.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          // Validar los datos del formulario
          $request->validate([
            'name' => 'required|string|min:5|max:255',
        ]);

         // Crear una nueva materia usando el método `create` del modelo
        Subject::create($request->all());

        // Redireccionar a la vista de listado de estudiantes
        return redirect()->route('subjects.index');  
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
        $subject = Subject::findOrFail($id);
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|min:5|max:255',
        ]);

        // Buscar la materia por su ID
        $subject = Subject::findOrFail($id);

        // Actualizar los datos de las materias
        $subject->update($request->all());

        // Redireccionar a la vista de listado de materias
        return redirect()->route('subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return redirect()->route('subjects.index');
    }
}
