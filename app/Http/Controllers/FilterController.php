<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Assistance;
use App\Models\Observation;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\IsEmpty;

class FilterController extends Controller
{
    public function index(Request $request)
     {   

    // $query = Assistance::query();
    // $yes = 0;
    // $no = 0;
    // $searchPerformed = false;

    // // Verifica si se ha enviado un nombre de estudiante en la solicitud
    // if ($request->has('student_name')) {
    //     $searchPerformed = true;
    //     // Obtén el nombre del estudiante de la solicitud
    //     $studentName = $request->input('student_name');
        
    //     // Filtra las inasistencias por el nombre del estudiante
    //     if ($studentName !== '') {
            
    //         // Busca al estudiante por su nombre
    //         $student = Student::where('name', $studentName)->first();
            
    //         if ($student) {
    //             // Filtra las inasistencias por el ID del estudiante
    //             $query->where('student_id', $student->id);

    //             // Contar las asistencias
    //             $yes = Assistance::where('student_id', $student->id)
    //             ->where('attended', 1)
    //             ->count();

    //             // Contar las inasistencias
    //             $no = Assistance::where('student_id', $student->id)
    //                 ->where('attended', 0)
    //                 ->count();
    //         }
    //     }
    // }

    //    $assistances = $query ->get(); 
    //     //Pasar los datos a la vista
    //    return view('filters.index', compact('assistances','yes','no','searchPerformed')); 

    }

    public function show(string $id)
    {
        $student = Student::findOrFail($id);
        //$subject = Subject::all();        
        //$course=Course::all();
        //$subject=Subject::all();
        $observations=Observation::where('student_id', $id)->get();
        $assistances = Assistance::where('student_id', $id)->get();
        // Contar las asistencias
        $yes = Assistance::where('student_id', $student->id)
                ->where('attended', 1)
                ->count();
        // Contar las inasistencias
        $no = Assistance::where('student_id', $student->id)
                    ->where('attended', 0)
                    ->count();
        
        $total = $yes + $no;
        $porc = $total > 0 ? ($yes / $total) * 100 : 0;
        return view('filters.index', compact('student','observations','assistances','yes','no','porc'));   
    }
}
