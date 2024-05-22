<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Student Observations')}}
        </h2>
    </x-slot>
    
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

           

            @if(session('success'))
            <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('observations.index') }}" method="get">
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
                    <th class="px-4 py-2 text-gray-900 text-center">Name</th>
                    <th class="px-4 py-2 text-gray-900 text-center">Surname</th>
                    <th class="px-4 py-2 text-gray-900 text-center">Observation</th>
                    <th class="px-4 py-2 text-gray-900 text-center"></th>
                </tr>
            </thead>
            <tbody>
                @if ($searchPerformed==true) 
                @foreach($observations as $student)
                    <tr>
                        <td class="border px-4 py-2 text-gray-900 text-center">{{ $student->name }}</td>
                        <td class="border px-4 py-2 text-gray-900 text-center">{{ $student->surname }}</td>
                        <td class="border px-4 py-2 text-gray-900 text-center">
                            @foreach($student->observation as $obs)
                                <p>{{ $obs->obs }}</p>
                            @endforeach
                        </td>
                        <td class="border px-4 py-2 text-gray-900 text-center">
                            <a href="{{ route('observations.create', $student->id) }}"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="margin: auto;" fill="currentColor" class="bi bi-person-exclamation" viewBox="0 0 16 16">
                            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                            <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5m0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                            </svg></a>
                        </td>
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
                    
            </div>
        </div>
    </div>


</x-app-layout>

