<?php

namespace App\Http\Controllers;
use App\Models\Observation;
use App\Models\Student;

use Illuminate\Http\Request;

class ObservationController extends Controller
{
    public function index(Request $request)
    {
        {
            $searchPerformed = false;
            $observations = Student::with('subject', 'course', 'assistance', 'observation');
    
            // if ($request->input('search')) {
            //     $searchPerformed = true;
            //     $observations->where('name', 'LIKE', '%' . $request->input('search') . '%');
            // }

            //Filtrar por apellido y nombre
            $busqueda = $request->input('search');
            if ($busqueda) {
                $searchPerformed = true;
                $observations = Student::whereRaw("CONCAT(surname, ' ', name) LIKE ?", ["%{$busqueda}%"]);
            } 

    
            if ($request->input('search2')) {
                $searchPerformed = true;
                $observations->whereHas('course', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->input('search2') . '%');
                });
            }
    
            $observations = $observations->get();
            return view('observations.index', compact('observations','searchPerformed'));
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($student_id)
    {
        $student = Student::findOrFail($student_id);
        return view('observations.create', compact('student'));
    }

    
    public function store(Request $request)
    {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'obs' => 'required|string|max:255',
            ]);
    
            $observations = Observation::create([
                'student_id' => $request->input('student_id'),
                'obs' => $request->input('obs'),
            ]);
    
            $student = Student::find($request->input('student_id'));
            $student->observation()->attach($observations->id);
    
            return redirect()->route('observations.index')->with('success', 'Observación guardada correctamente.');
        }
}
