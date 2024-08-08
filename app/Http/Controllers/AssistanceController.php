<?php

namespace App\Http\Controllers;
use App\Models\Assistance;
use App\Models\Student;
use Illuminate\Http\Request;

class AssistanceController extends Controller
{
    public function index(Request $request)
    {
        $searchPerformed = false;
        $post = Student::with('subject', 'course', 'assistance')
            ->where('status', 1); // Filtro status = 1 o activo

        // Filtro por apellido y nombre
        $busqueda = $request->input('search');
        if ($busqueda) {
            $searchPerformed = true;
            $post->whereRaw("CONCAT(surname, ' ', name) LIKE ?", ["%{$busqueda}%"]);
        }

        // Filtro por nombre del curso
        if ($request->input('search2')) {
            $searchPerformed = true;
            $post->whereHas('course', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->input('search2') . '%');
            });
        }

        $post = $post->get();
        return view('assistances.index', compact('post', 'searchPerformed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('assistances.create'); 
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'assistance' => 'required|array',
            'assistance.*' => 'required|array',
        ], [
            'assistance.required' => 'Debe enviar al menos una asistencia.',
        ]);
    
        // Contador para el total de asistencias enviadas
        $totalAssistances = 0;
    
        // Comprobar los campos de búsqueda
        $search = $request->input('search');
        $search2 = $request->input('search2');
    
        // Iterar sobre cada asistencia enviada
        foreach ($request->assistance as $studentId => $courses) {
            foreach ($courses as $courseId => $assistanceValue) {
                // Si se usa search2 o no se está buscando por search, enviar todos los valores
                if ($search2 || !$search) {
                    $assistance = new Assistance();
                    $assistance->date = now(); 
                    $assistance->student_id = $studentId;
                    $assistance->course_id = $courseId;
                    $assistance->attended = $assistanceValue; // Asignar el valor de asistencia correcto
                    $assistance->save();
    
                    // Incrementar el contador de asistencias válidas
                    $totalAssistances++;
                } elseif ($search && $assistanceValue == 1) {
                    // Si se usa search y la asistencia es 1, enviar solo los valores tildados
                    $assistance = new Assistance();
                    $assistance->date = now(); 
                    $assistance->student_id = $studentId;
                    $assistance->course_id = $courseId;
                    $assistance->attended = $assistanceValue; // Asignar el valor de asistencia correcto
                    $assistance->save();
    
                    // Incrementar el contador de asistencias válidas
                    $totalAssistances++;
                }
            }
        }
    
        // Redireccionar al índice de asistencias con un mensaje de éxito
        return redirect()->route('assistances.index')->with('success', 'Total de asistencias enviadas correctamente: ' . $totalAssistances);
    }
    
    public function show (Request $request)
    {
    }

    public function edit($studentId)
    {
        //Recupero las asistencias del estudiante por su ID
        $student = Student::find($studentId);
        // Recupero los cursos y materias del estudiante
        $courses = $student->course;  
        $subjects = $student->subject;  // Para la relación muchos a muchos
        $assistances = Assistance::where('student_id', $studentId)
        ->orderBy('date', 'desc') 
        ->get();
        return view('assistances.edit', compact('student', 'assistances','courses','subjects'));
    }

    public function update(Request $request, $studentId)
    {
    foreach ($request->assistances as $assistanceData) {
        $assistance = Assistance::find($assistanceData['id']);

        $originalDate = $assistance->date;
        $originalAttended = $assistance->attended;

        $newDate = $assistanceData['date'];
        $newAttended = isset($assistanceData['attended']) ? 1 : 0;

        $hasChanged = false;

        // Verifico si ha cambiado la asistencia
        if ($originalAttended != $newAttended) {
            $assistance->attended = $newAttended;
            $hasChanged = true; // Se ha modificado el check
        }

        // Verifico si ha cambiado la fecha/hora
        if ($originalDate != $newDate) {
            $assistance->date = $newDate;
            $hasChanged = true; // Se ha modificado la fecha/hora
        }

        // Si ha habido algún cambio, guardo la asistencia
        if ($hasChanged) {
            $assistance->save();
        }
    }

    return redirect()->back()->with([
        'success' => 'Asistencias actualizadas correctamente',
    ]);
    }
}


