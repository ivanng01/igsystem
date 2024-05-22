<?php

namespace App\Http\Controllers;
use App\Models\Assistance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssistanceController extends Controller
{
    public function index(Request $request)
    {
        $searchPerformed = false;
        $post = Student::with('subject','course','assistance')
        ->where('status', 1); // Filtrar status = 1 o active
      
        // if($request->input('search')) {
        //      $searchPerformed = true;
        //      $post->where('name', 'LIKE' , '%'.$request->input('search').'%');
        // }

        //Filtrar por apellido y nombre
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
        return view('assistances.create'); 
    }

    public function store(Request $request)
    {
        // dd($request->assistance);
        $currentHs = Carbon::now()->format('H:00:00');
        $nextHs = Carbon::now()->addHour()->format('H:00:00');
        foreach ($request->assistance as $studentsAssitances) {
            
             list($studentId,$assistanceValue) = explode('-',$studentsAssitances);
            //dd($studentsAssitances);

            $existAssistance = Assistance::where('student_id',$studentId)
                        ->whereTime('date','>=',$currentHs)
                        ->whereTime('date','<',$nextHs)
                        ->exists();
            // dd($existAssistance);
            if(!$existAssistance) {
                $assistance = new Assistance();
                $assistance->date=now();
                $assistance->student_id = $studentId;
                $assistance->attended = $assistanceValue; 
                $assistance->save();
            }
        }

        session()->flash('success', 'Asistencia guardada correctamente');

        return redirect()->route('assistances.index');
    }

    
    public function show (Request $request)
    {
    }
}

    

