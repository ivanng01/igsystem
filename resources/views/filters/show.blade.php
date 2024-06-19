<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Student Report')}}
        </h2>
    </x-slot>
    
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
            <form action="{{ route('reports.reportAlumns') }}" method="post">
                @csrf
                <input type="hidden" value="{{$student->id}}" name="id" id="id">
                <div class="w-100 text-end">
                    <button class="text-black bg-gray-400 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm w-full sm:w-auto px-4 py-2.5 text-end ">
                        <i class="bi bi-file-earmark-pdf"></i> Generate PDF
                    </button>
                </div>
            </form>
            <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 text-center">Fecha</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Asistio</th>
                            </tr>
                        </thead>
                        <tbody>

                        <strong>Student: {{$student->name}} {{$student->surname}}</strong>
                        @foreach($assistances as $assistance)
                            <tr>         
                                <td class="border px-4 py-2 text-gray-900 text-center">{{ \Carbon\Carbon::parse($assistance->date)->translatedFormat('l, d F Y H:i') }}</td>
                                <td class="border px-4 py-2 text-gray-900 text-center">
                                    @if($assistance->attended == 1)
                                        Sí
                                    @else
                                        No
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>     
            </table>


            <table class="table-auto w-full">
                        <th class="px-4 py-2 text-gray-900 text-center">Results</th>
                            <tr>
                                <td class="border px-4 py-2 text-gray-900 text-center">Si</td>
                                <td class="border px-4 py-2 text-gray-900 text-center">No</td>
                                <td class="border px-4 py-2 text-gray-900 text-center">Asistencia</td>
                            </tr>
                        <tbody>
                            <tr>         
                                <td class="border px-4 py-2 text-gray-900 text-center">{{$yes}}</td>
                                <td class="border px-4 py-2 text-gray-900 text-center">{{$no}}</td>
                                <td class="border px-4 py-2 text-gray-900 text-center">{{$porc}} %</td>
                            </tr>
                        </tbody>     
            </table>
                        
            <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 text-center">Fecha</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Obs</th>
                        </thead>
                            
                        <tbody>
                         @foreach ($observations as $observation)
                                <td class="border px-4 py-2 text-gray-900 text-center">{{ \Carbon\Carbon::parse($observation->created_at)->translatedFormat('l, d F Y H:i') }}</td>
                                <td class="border px-4 py-2 text-gray-900 text-center">{{ $observation->obs }}</td>
                            </tr>
                        @endforeach
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

