<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assistance Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <form action="{{ route('assistances.index') }}" method="get">
                    @csrf
                    <div class="mb-2">
                        <div class="form-group flex flex-wrap gap-2 items-center">
                            <input type="text" id="search" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2"
                            placeholder="Ingrese apellido y nombre">
                            
                            <input type="text" id="search2" name="search2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2"
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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('assistances.store') }}">
                    @csrf
                    <!-- Agregar campos de búsqueda ocultos al formulario -->
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="search2" value="{{ request('search2') }}">

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 text-center">ID</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Surname</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Name</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Course</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Subject</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Attended (Yes/No)</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($searchPerformed && $post->isNotEmpty())
                                @foreach ($post as $student)
                                    <tr>
                                        <td class="border px-4 py-2 text-gray-900 text-center">{{ $student->id }}</td>
                                        <td class="border px-4 py-2 text-gray-900 text-center">{{ $student->surname }}</td>
                                        <td class="border px-4 py-2 text-gray-900 text-center">{{ $student->name }}</td>
                                        <td class="border px-4 py-2 text-gray-900 text-center">
                                            @if ($student->course->isNotEmpty())
                                                @foreach ($student->course as $course)
                                                    <input type="hidden" name="assistance[{{ $student->id }}][{{ $course->id }}]" value="0">
                                                    <p>{{ $course->name }}</p>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2 text-gray-900 text-center">
                                            @if ($student->subject->isNotEmpty())
                                                @foreach ($student->subject as $subject)
                                                    <p>{{ $subject->name }}</p>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2 text-gray-900 text-center">
                                            @foreach ($student->course as $course)
                                                <input type="checkbox" name="assistance[{{ $student->id }}][{{ $course->id }}]" value="1">
                                            @endforeach
                                        </td>
                                        <td class="border px-4 py-2 text-center">
                                            <div class="flex justify-center">
                                                <a href="{{ route('assistances.edit', $student->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="px-4 py-2 text-gray-900 text-center">
                                        @if (!empty(request('search')) || !empty(request('search2')))
                                            No results found.
                                        @else
                                            No search performed.
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="text-white bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Enviar Asistencia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>



