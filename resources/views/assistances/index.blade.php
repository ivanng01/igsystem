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
                <x-custom-button></x-custom-button>
            </form>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{route('assistances.index')}}">
            @csrf 
            <button type="submit" class="text-white bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Send Assistance</button>
                <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-gray-900 text-center">ID</th>
                                    <th class="px-4 py-2 text-gray-900 text-center">Name</th>
                                    <th class="px-4 py-2 text-gray-900 text-center">Surname</th>
                                    <th class="px-4 py-2 text-gray-900 text-center">Course</th>
                                    <th class="px-4 py-2 text-gray-900 text-center">Subject</th>
                                    <th class="px-4 py-2 text-gray-900 text-center">Assistance (Yes/No)</th>
                                </tr>
                            </thead>

                            <tbody>
                            @if ($searchPerformed==true) 
                                @if ($post->isNotEmpty())
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
                                        <td class="border px-4 py-2 text-center">
                                        <div class="flex justify-center">
                                            <a href="{{ route('assistances.edit', $student->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg></a>
                                                    
                                        </div>
                                    </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="px-4 py-2 text-gray-900 text-center">No results found.</td>
                                    </tr>
                                @endif
                                @else
                                    <p>No assistance performed.</p>
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

