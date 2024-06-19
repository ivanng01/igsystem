<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Assistance;
use App\Models\Observation;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index(Request $request)
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
            ->orderBy('course_student.course_id')
            ->get();

        $coursesAndStudents = DB::select(
                'SELECT s.id AS student_id, c.name AS course_name, s.name AS student_name, s.surname AS student_surname, s.status AS student_status
                FROM course_student cs
                JOIN courses c ON cs.course_id = c.id
                JOIN students s ON cs.student_id = s.id
                WHERE s.status = 0'
        );

        $studentCounts = DB::select(
            'SELECT c.id AS course_id, c.name AS course_name,
                SUM(CASE WHEN s.status = 0 THEN 1 ELSE 0 END) AS count_status_0,
                SUM(CASE WHEN s.status = 1 THEN 1 ELSE 0 END) AS count_status_1
            FROM course_student cs
            JOIN courses c ON cs.course_id = c.id
            JOIN students s ON cs.student_id = s.id
            GROUP BY c.id, c.name'
        );
    
        return view('filters.index', compact('assistances','coursesAndStudents','studentCounts'));
    }

    public function show(string $id)
    {
        $student = Student::findOrFail($id);
        $observations=Observation::where('student_id', $id)
                    ->get();
        $assistances = Assistance::where('student_id', $id)
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
        return view('filters.show', compact('student','observations','assistances','yes','no','porc'));   
    
    }
}
