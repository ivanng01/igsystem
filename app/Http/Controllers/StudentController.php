<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Assistance;
use App\Models\Observation;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $searchPerformed = false;
        $post = Student::with('subject','course','assistance','observation');

        //Filtro por apellido y nombre
        $busqueda = $request->input('search');
        if ($busqueda) {
            $searchPerformed = true;
            $post = Student::whereRaw("CONCAT(surname, ' ', name) LIKE ?", ["%{$busqueda}%"]);
        } 

        if($request->input('search2')) {
            $searchPerformed = true;
            $post->whereHas('course', function($query) use ($request) {
                $query->where('name', 'LIKE' , '%'.$request->input('search2').'%');
            });
        }

        // Obtengo los resultados
        $post = $post->get();
        
        return view('students.index', compact('post','searchPerformed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::select('id','name')->get();
        $courses = Course::select('id','name')->get();
        $assistances = Assistance::select('id')->get();
        $observations = Observation::select('id')->get();
        return view('students.create',compact('subjects','courses','assistances','observations'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valido los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'surname' => 'required|string|min:2|max:255',
            'select_subject' => 'array',
            'select_course' => 'array',
        ]);
        

        // Añado el valor por defecto de 'status'
        $validated['status'] = 1;

        // Creo el estudiante con los datos validados
        $student = Student::create($validated);
        
        // Relaciono el estudiante con los cursos seleccionados
        if ($request->has('select_course')) {
            //$student->subject()->attach($request->input('select_subject'));
            $student->course()->attach($request->input('select_course'));
        }

        // Relaciono el estudiante con las materias seleccionadas
        if ($request->has('select_subject')) {
            //$student->subject()->attach($request->input('select_subject'));
            $student->subject()->attach($request->input('select_subject'));
        }

        //return redirect()->route('students.index');
        
        return redirect()->route('students.create')->with('success', 'Alumno creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    
    public function show($id)
    {
        // Obtengo el estudiante por su ID junto con sus observaciones
        $student = Student::with('observations')->findOrFail($id);
        return view('students.show', compact('student'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::findOrFail($id);
        //$subject = Subject::all();        
        $course=Course::all();
        $subject=Subject::all();
        return view('students.edit', compact('student','course','subject'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // Valido los datos del formulario
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'surname' => 'required|string|min:2|max:255',
            'select_course' => 'array',
            'select_subject' => 'array',
        ]);

        // Busco el estudiante por su ID
        //$student = Student::findOrFail($id);

        // Actualizo los datos del estudiante
        $student->update($request->all());

        // Relaciono el estudiante con las materias seleccionadas
        $student->course()->sync($request->input('select_course'));

        // Relaciono el estudiante con las materias seleccionadas
        $student->subject()->sync($request->input('select_subject'));

        // Redirecciono a la vista el listado de estudiantes
        return redirect()->route('students.index')->with('success', 'Edición guardada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index');
    }

}
