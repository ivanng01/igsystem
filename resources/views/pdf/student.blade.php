
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
<body>
        <div class="text-center py-2">
            <img src="{{ asset('images/IPSS.jpg') }}" alt="New Logo" class="img-fluid">
        </div>

        <style>
        .page-break {
            page-break-after: always;
        }
        </style>

    <div>
        <header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                {{__('Report ')}} {{$student->surname}} {{$student->name}} &
                @if($student->subject->count() > 0)
                    {{ $student->subject->pluck('name')->implode(', ') }}
                @endif
            </h2>
        </header>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                    <h5 class="font-semibold text-xl text-gray-800 leading-tight" > {{__('Attendance Summary')}} </h5>
                        <table class="table-auto w-full">
                            <tr>
                                <td class="border px-4 py-2 text-gray-900 text-center">Attendance</td>
                                <td class="border px-4 py-2 text-gray-900 text-center">Absence</td>
                                <td class="border px-4 py-2 text-gray-900 text-center">Percentage</td>
                            </tr>
                            <tbody>
                                <tr>
                                    <td class="border px-4 py-2 text-gray-900 text-center">{{$yes}}</td>
                                    <td class="border px-4 py-2 text-gray-900 text-center">{{$no}}</td>
                                    <td class="border px-4 py-2 text-gray-900 text-center">{{number_format($porc,2)}} %</td>
                                </tr>
                            </tbody>
                        </table>    
                    <br>

                    <h5 class="font-semibold text-xl text-gray-800 leading-tight" > {{__('Breakdown of attendance')}} </h5>
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 text-center">Date</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Attended</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assistances as $assistance)
                            <tr>
                                <td class="border px-4 py-2 text-gray-900 text-center">{{ \Carbon\Carbon::parse($assistance->date)->translatedFormat('l, d F Y H:i') }}</td>
                                <td class="border px-4 py-2 text-gray-900 text-center">
                                    @if($assistance->attended == 1)
                                    Yes
                                    @else
                                    No 
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    
                    <h5 class="font-semibold text-xl text-gray-800 leading-tight">Observations</h5>
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 text-center">Date</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Observation</th>
                        </thead>

                        <tbody>
                            @foreach ($observations as $observation)
                            <tr>
                                <td class="border px-4 py-2 text-gray-900 text-center">{{ \Carbon\Carbon::parse($observation->created_at)->translatedFormat('l, d F Y H:i') }}</td>
                                <td class="border px-4 py-2 text-gray-900 text-center">{{ $observation->obs }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                </div>
            </div>
            <br>
            <div class="w-100">
                <h5 class="text-md text-gray-500 leading-tight text-center">Report generated by <b>{{ Auth::user()->name }} {{ Auth::user()->last_name }}</b>on the day {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i') }}</h5>
            </div>
        </div>
    </div>
</body>