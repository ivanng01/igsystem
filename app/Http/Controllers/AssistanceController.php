<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Assistance;
use App\Models\Student;


use Illuminate\Http\Request;

class AssistanceController extends Controller
{
    public function index(Request $request)
    {
        $searchPerformed = false;
        $post = Student::with('subject','course','assistance')
        ->where('status', 1); // Filtro status = 1 o active

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
        

        $post = $post->get();
        return view('assistances.index', compact('post','searchPerformed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('assistances.create'); 
    }


    //OK OK
    public function store(Request $request)
    {
        //dd($request->assistance);

         // Valido los datos del formulario
        $request->validate([
            'assistance' => 'required|array|min:1',
            'assistance.*' => 'required|string'
        ], [
            'assistance.required' => 'Debe enviar al menos una asistencia.',
            'assistance.min' => 'Debe enviar al menos una asistencia.',
        ]);    

        //Cuento el total de asistencias enviadas
        $totalAssistances = count($request->assistance); 
        foreach ($request->assistance as $studentsAssitances) {
            
            list($studentId,$assistanceValue) = explode('-',$studentsAssitances);
            
            $assistance = new Assistance();
            $assistance->date=now();
            $assistance->student_id = $studentId;
            $assistance->attended = $assistanceValue; 
            $assistance->save();
        }
        
        return redirect()->route('assistances.index')->with('success', 'Total de asistencias enviadas correctamente: ' . $totalAssistances);
    }

    
    public function show (Request $request)
    {
    }

    public function edit($studentId)
    {
        //Recupero las asistencias del estudiante por su ID
        $student = Student::find($studentId);
        $assistances = Assistance::where('student_id', $studentId)
        ->orderBy('date', 'desc') 
        ->get();
        return view('assistances.edit', compact('student', 'assistances'));
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


