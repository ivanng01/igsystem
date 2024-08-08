<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use Illuminate\Http\Request;


class SubjectController extends Controller
{
    public function index()
    {
        $subject = Subject::all();
        return view('subjects.index', compact('subject'));
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
        // Valido los datos del formulario
        $request->validate([
            'name' => 'required|string|min:5|max:255',
        ]);

        // Creo una nueva materia usando el método 'create' del modelo
        Subject::create($request->all());

        // Redirecciono a la vista el listado de estudiantes
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
        // Valido los datos del formulario
        $request->validate([
            'name' => 'required|string|min:5|max:255',
        ]);

        // Busco la materia por su ID
        $subject = Subject::findOrFail($id);

        // Actualizo los datos de las materias
        $subject->update($request->all());

        // Redirecciono a la vista el listado de materias
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
