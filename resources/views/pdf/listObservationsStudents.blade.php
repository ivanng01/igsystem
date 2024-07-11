<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IGS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{asset('js/alertify.min.js')}}"></script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/alertify.min.css')}}">
</head>
<style>
.page-break {
    page-break-after: always;
}
</style>
    <div class="py-4">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Observaciones de ') }} "{{ $course }}"
        </h2>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-gray-900 text-center">Apellido y Nombre</th>
                            <th class="px-4 py-2 text-gray-900 text-center">Fecha</th>
                            <th class="px-4 py-2 text-gray-900 text-center">Observación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($observations as $student_id => $studentObservations)
                            @if($studentObservations->isNotEmpty())
                                @php $firstObservation = true; @endphp
                                @foreach($studentObservations as $observation)
                                    <tr>
                                        @if($firstObservation)
                                            <td class="border px-4 py-2 text-gray-900 text-center" rowspan="{{ $studentObservations->count() }}">
                                                {{ $studentObservations->first()->student_surname }} {{ $studentObservations->first()->student_name }}
                                            </td>
                                            @php $firstObservation = false; @endphp
                                        @endif
                                        <td class="border px-4 py-2 text-gray-900 text-center">{{ $observation->observation_date }}</td>
                                        <td class="border px-4 py-2 text-gray-900 text-center">{{ $observation->observation_obs }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="border px-4 py-2 text-gray-900 text-center">{{ $studentObservations->first()->student_surname }} {{ $studentObservations->first()->student_name }}</td>
                                    <td class="border px-4 py-2 text-gray-900 text-center" colspan="2">No hay observaciones.</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="w-100">
            <h5 class="text-md text-gray-500 leading-tight text-center">Reporte Generado por <b>{{ Auth::user()->name }} {{ Auth::user()->last_name }}</b> el día {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i') }}</h5>
        </div>
    </div>

