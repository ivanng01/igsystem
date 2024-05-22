<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Confirmation Assistance')}}
        </h2>
    </x-slot>
    
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

            <form action="{{ route('assistances.index') }}" method="get">
            @csrf
                <div class="mb-2">
                    <div class="form-group flex flex-wrap gap-2 items-center">
                        <input type="text" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2"
                        placeholder="Ingrese apellido y nombre">
                        
                        <input type="text" name="search2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2"
                        placeholder="Ingrese curso">
                        
                        <div class="ml-auto">
                            <button class="text-black bg-gray-400 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </div>
                </div>
            </form>


            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{route('assistances.index')}}">
            @csrf 
            <button type="submit" class="text-white bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Send Assistance</button>
                <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-gray-900 text-center">ID Student</th>
                                    <th class="px-4 py-2 text-gray-900 text-center">Name</th>
                                    <th class="px-4 py-2 text-gray-900 text-center">Surname</th>
                                    <th class="px-4 py-2 text-gray-900 text-center">Course</th>
                                    <th class="px-4 py-2 text-gray-900 text-center">Subject</th>
                                    <th class="px-4 py-2 text-gray-900 text-center">Assistance (Yes/No)</th>
                                </tr>
                            </thead>

                            <tbody>
                            @if ($searchPerformed==true) 
                                @foreach($post as $student)
                                <tr>                                 
                                    <td class="border px-4 py-2 text-gray-900 text-center">{{ $student->id }}</td>
                                    <td class="border px-4 py-2 text-gray-900 text-center">{{ $student->name }}</td>
                                    <td class="border px-4 py-2 text-gray-900 text-center">{{ $student->surname }}</td>
                                    <td class="border px-4 py-2 text-gray-900 text-center">
                                        @if ($student->course->isNotEmpty())
                                            @foreach($student->course as $course)
                                                <p>{{ $course->name }}</p>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td class="border px-4 py-2 text-gray-900 text-center">
                                        @if ($student->subject->isNotEmpty())
                                            @foreach($student->subject as $subject)
                                                <p>{{ $subject->name }}</p>
                                            @endforeach
                                        @endif
                                    </td>
                                        
                                    <td class="border px-4 py-2 text-gray-900 text-center">
                                        <input class="form-check-input" type="hidden" id="disabledstudent-{{$student->id}}" name="assistance[]" value="{{ $student->id }}-0">
                                        <input class="form-check-input" type="checkbox" id="student-{{$student->id}}"· name="assistance[]" onchange="CheckAssistance({{ $student->id }})" value="{{ $student->id }}-1">
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>              
                </table>
                <br>
                <div class="mb-6">
                    <a href="{{route('students.index') }}" class="text-white bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center float-right sm:w-auto"><i class="bi bi-house"></i> Home</a>    
                </div>
            </form>            
                    
            </div>
        </div>
    </div>

<script>
    function CheckAssistance(student) {
        if(document.getElementById('student-'+student).checked){
            document.getElementById('disabledstudent-'+student).disabled = true;
        }else{
            document.getElementById('disabledstudent-'+student).removeAttribute('disabled');
        }   
    }
</script>
</x-app-layout>


