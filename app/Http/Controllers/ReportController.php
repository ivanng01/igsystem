<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
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
        $assistancesQuery = Student::select(
            'students.id as student_id',
            'students.name as student_name',
            'students.surname as student_surname',
            'courses.id as course_id',
            'courses.name as course_name',
            DB::raw('COUNT(assistances.id) as total_assistances'),
            DB::raw('SUM(assistances.attended) as attended_assistances')
        )
        ->join('course_student', 'students.id', '=', 'course_student.student_id')
        ->join('courses', 'courses.id', '=', 'course_student.course_id')
        ->leftJoin('assistances', 'students.id', '=', 'assistances.student_id')
        ->where('students.status', 1)
        ->groupBy('students.id', 'students.name', 'students.surname', 'courses.id', 'courses.name')
        ->orderBy('course_student.course_id');

        if ($request->has('search2') && !is_null($request->input('search2'))) {
            $assistancesQuery->where('courses.name', $request->input('search2'));
        }

        $assistances = $assistancesQuery->get();
        
        $pdf = Pdf::loadView('pdf.listStudents', [
            "course" => $request->input('search2', 'Todos'),
            "assistances" => $assistances
        ])->setPaper('a4', 'landscape')->setOption('defaultFont', 'sans-serif');
        
        return $pdf->download('Reporte asistencias de alumnos de '.$request->input('search2').'.pdf');
    }

    public function reportObservations(Request $request)
{
    $search2 = $request->input('search2');

    $observationsQuery = Student::select(
        'students.id as student_id',
        'students.name as student_name',
        'students.surname as student_surname',
        'courses.name as course_name',
        'observations.id as observation_id',
        'observations.obs as observation_obs',
        'observations.created_at as observation_date'
    )
    ->leftJoin('course_student', 'students.id', '=', 'course_student.student_id')
    ->leftJoin('courses', 'courses.id', '=', 'course_student.course_id')
    ->leftJoin('observations', 'students.id', '=', 'observations.student_id')
    ->orderBy('students.surname')
    ->orderBy('students.name')
    ->orderBy('observations.created_at');

    if (!empty($search2)) {
        $observationsQuery->where('courses.name', $search2);
    }

    $observations = $observationsQuery->get()->groupBy('student_id');

    $courseName = $search2 ?: 'All Student Observation List';

    // Eliminar caracteres no válidos para nombres de archivos
    $courseName = preg_replace('/[^A-Za-z0-9 _\-]/', '', $courseName);

    $pdf = Pdf::loadView('pdf.listObservationsStudents', [
        "course" => $courseName,
        "search2" => $search2,
        "observations" => $observations
    ])->setPaper('a4', 'landscape')->setOption('defaultFont', 'sans-serif');

    return $pdf->download('Reporte observaciones de alumnos de ' . $courseName . '.pdf');
}


    public function reportAlumns(Request $request)
    {
        $studentId = $request->input('id');
        
        $student = Student::with(['observation', 'assistance' => function($query) {
            $query->orderBy('date', 'desc');
        }, 'subject'])
        ->findOrFail($studentId);

        $assistancesStats = Assistance::where('student_id', $studentId)
            ->selectRaw('SUM(attended = 1) as attended_count, SUM(attended = 0) as not_attended_count')
            ->first();

        $yes = $assistancesStats->attended_count;
        $no = $assistancesStats->not_attended_count;
        
        $total = $yes + $no;
        $porc = $total > 0 ? ($yes / $total) * 100 : 0;

        // Obtener el nombre de la materia asignada al estudiante
        $subjectNames = $student->subject->pluck('name')->implode(', ');

        $subjectName = !empty($subjectNames) ? $subjectNames : 'Sin Materias Asignadas'; 

        $pdf = Pdf::loadView('pdf.student', [
            "student" => $student,
            "observations" => $student->observation,
            "assistances" => $student->assistance,
            "yes" => $yes,
            "no" => $no,
            "porc" => $porc,
        ])->setPaper('a4', 'landscape')->setOption('defaultFont', 'sans-serif');
        
        return $pdf->download('Reporte de '.$student->surname.' '.$student->name.' '.$subjectName.'.pdf');
    }

    public function reportListStudents(Request $request)
    {
    $studentsQuery = Student::select(
        'students.id as student_id',
        'students.name as student_name',
        'students.surname as student_surname',
        'courses.id as course_id',
        'courses.name as course_name'
    )
    ->join('course_student', 'students.id', '=', 'course_student.student_id')
    ->join('courses', 'courses.id', '=', 'course_student.course_id')
    ->where('students.status', 1)
    ->groupBy('students.id', 'students.name', 'students.surname', 'courses.id', 'courses.name')
    ->orderBy('course_student.course_id');


    if ($request->has('search2') && !is_null($request->input('search2'))) {
        $studentsQuery->where('courses.name', $request->input('search2'));
    }

    $students = $studentsQuery->get();

    $pdf = Pdf::loadView('pdf.listStudentsCourse', [
        "course" => $request->input('search2', 'Todos'),
        "students" => $students
    ])->setPaper('a4', 'landscape')->setOption('defaultFont', 'sans-serif');
    
    return $pdf->download('Reporte de alumnos de '.$request->input('search2', 'Todos').'.pdf');
    }


}
