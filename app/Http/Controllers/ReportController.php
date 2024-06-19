<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\Models\Observation;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    

     /**
     * 
     */
    public function reportAsistances(Request $request)
    {
        $assistances = Assistance::select(
            'students.id as student_id',
            'students.name as student_name',
            'students.surname as student_surname',
            'courses.id as course_id',
            'courses.name as course_name',
            DB::raw('COUNT(*) as total_assistances'),
            DB::raw('SUM(attended) as attended_assistances')
            )
            ->join('students', 'students.id', '=', 'assistances.student_id')
            ->join('course_student', 'students.id', '=', 'course_student.student_id')
            ->join('courses', 'courses.id', '=', 'course_student.course_id')
            ->where('students.status', '=', 1) 
            ->groupBy('students.id', 'students.name', 'students.surname', 'courses.id', 'courses.name')
            ->orderBy('course_student.course_id');

        
        if ($request->has('search2') && !is_null($request->input('search2'))) {
            $assistances->where('courses.name',$request->input('search2'));
        }

        $assistances = $assistances->get();
        
        // $pdf = Pdf::loadView('pdf.listStudents', ["course"=>$request->input('search2','Todos'),"assistances"=>$assistances]);
        $pdf = Pdf::loadView('pdf.listStudents', [
            "course" => $request->input('search2', 'Todos'),
            "assistances" => $assistances
        ])->setPaper('a4', 'landscape')->setOption('defaultFont', 'sans-serif');
        
        return $pdf->download('Reporte asistencias de alumnos de '.$request->input('search2').'.pdf');
    }

    public function reportAlumns(Request $request)
    {
        
        $student = Student::findOrFail($request->input('id'));
        $observations=Observation::where('student_id', $request->input('id'))
                    ->get();
        $assistances = Assistance::where('student_id', $request->input('id'))
                    ->orderBy('date', 'desc')
                    ->get();
        //Cuento las asistencias
        $yes = Assistance::where('student_id', $student->id)
                    ->where('attended', 1)
                    ->count();
        //Cuento las inasistencias
        $no = Assistance::where('student_id', $student->id)
                    ->where('attended', 0)
                    ->count();
        
        $total = $yes + $no;
        $porc = $total > 0 ? ($yes / $total) * 100 : 0;

        $pdf = Pdf::loadView('pdf.student', [
            "student" => $student,
            "observations" => $observations,
            "assistances" => $assistances,
            "yes" => $yes,
            "no" => $no,
            "porc" => $porc,
        ])->setPaper('a4', 'landscape')->setOption('defaultFont', 'sans-serif');
        
        return $pdf->download('Reporte de '.$student->name.' '.$student->last_name.'.pdf');
    }
}
