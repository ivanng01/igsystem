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
        //dd($request);
        //$post = Student::with('subject');
        
        $post = Student::with('subject','course','assistance','observation');
        
        // if($request->input('search')) {
        //     $post->where('name', 'LIKE' , '%'.$request->input('search').'%');
        // }

        //Filtrar por apellido y nombre
        $busqueda = $request->input('search');
        if ($busqueda) {
            $post = Student::whereRaw("CONCAT(surname, ' ', name) LIKE ?", ["%{$busqueda}%"]);
        } 

        if($request->input('search2')) {
            $post->whereHas('course', function($query) use ($request) {
                $query->where('name', 'LIKE' , '%'.$request->input('search2').'%');
            });
        }
        

        $post = $post->get();
        
        return view('students.index', compact('post'));
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
        //dd($subjects);
        //return $subjects;
        return view('students.create',compact('subjects','courses','assistances','observations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'surname' => 'required|string|min:2|max:255',
            'select_subject' => 'array',
            'select_course' => 'array',
        ]);
        

        // Añadir el valor por defecto de 'status'
        $validated['status'] = 1;

        // Crear el estudiante con los datos validados
        $student = Student::create($validated);
        
        // Relacionar el estudiante con los cursos seleccionados
        if ($request->has('select_course')) {
            //$student->subject()->attach($request->input('select_subject'));
            $student->course()->attach($request->input('select_course'));
        }

        // Relacionar el estudiante con las materias seleccionadas
        if ($request->has('select_subject')) {
            //$student->subject()->attach($request->input('select_subject'));
            $student->subject()->attach($request->input('select_subject'));
        }

        return redirect()->route('students.index');
    }

    /**
     * Display the specified resource.
     */
    
    public function show($id)
    {
        // Obtener el estudiante por su ID junto con sus observaciones
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
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'surname' => 'required|string|min:2|max:255',
            'select_course' => 'array',
            'select_subject' => 'array',
        ]);

        // Buscar el estudiante por su ID
        //$student = Student::findOrFail($id);

        // Actualizar los datos del estudiante
        $student->update($request->all());

        // Sincronizar los cursos relacionados con los cursos seleccionados
        $student->course()->sync($request->input('select_course'));

        // Sincronizar los cursos relacionados con las materias seleccionadas
        $student->subject()->sync($request->input('select_subject'));

        // Redireccionar a la vista de listado de estudiantes
        return redirect()->route('students.index');
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
