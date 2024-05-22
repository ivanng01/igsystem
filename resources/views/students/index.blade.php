<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Student List')}}
        </h2>
    </x-slot>
    
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

            <div class="mb-6">
                        <a href="{{route('students.create') }}" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Create Student</a>
            </div>

            <form action="{{ route('students.index') }}" method="get">
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
                            
            <table class="table-auto w-full">
                        <thead>
                            <tr>
                                
                                <th class="px-4 py-2 text-gray-900 text-center">ID Student</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Name</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Surname</th>
                                
                                <th class="px-4 py-2 text-gray-900 text-center">Course</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Subject</th>
                      
                            </tr>
                        </thead>
                        <tbody>
                        
                        
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
                                <td class="border px-4 py-2 text-center">
                                    <div class="flex justify-center">
                                        <a href="{{ route('students.edit', $student->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg></a>
                                                
                                        <button onclick="confirmDelete('{{ $student->id }}')"><svg xmlns="http://www.w3.org/2000/svg" color="red" width="24" height="24" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg> </button>
                                           
                                        <a href="{{ route('filters.show', $student->id) }}"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                                @else
                                    <p>No results found.</p>
                        @endif
                        </tbody>              
                    </table>
                </div>
            </div>
    </div>
</x-app-layout>

<script>
    function confirmDelete(id) {
        alertify.confirm("¿Confirm delete record?",
        function(){
            let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/students/' + id;
                    form.innerHTML = '@csrf @method("DELETE")';
                    document.body.appendChild(form);
                    form.submit();
            alertify.success('Ok');
        },
        function(){
            alertify.error('Cancel');
        });
    }
</script>

