<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Report') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                <strong>{{$student->surname}} {{$student->name}} & </strong>
                @foreach($subjects as $subject)
                    <strong>{{$subject->name}}</strong>
                @endforeach  

                <form id="pdfForm" action="{{ route('reports.reportAlumns') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{$student->id}}" name="id" id="id">
                    <div class="w-100 text-end">
                        <button type="button" id="generatePdfButton" class="text-black bg-gray-400 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm w-full sm:w-auto px-4 py-2.5 text-end">
                            <i class="bi bi-file-earmark-pdf"></i> Generate PDF
                        </button>
                    </div>
                </form>
                
                <div id="loadingMessage" style="display:none; text-align:center; margin-top:20px;">
                    <p>Downloading PDF, please wait...</p>
                    <div id="loadingSpinner" style="border: 8px solid #f3f3f3; border-radius: 50%; border-top: 8px solid #3498db; width: 50px; height: 50px; animation: spin 1s linear infinite; margin: 0 auto;"></div>
                </div>

                <style>
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                </style>

                <!-- Código-->
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


            <table class="table-auto w-full">
                        <th class="px-4 py-2 text-gray-900 text-center">Results</th>
                            <tr>
                                <td class="border px-4 py-2 text-gray-900 text-center">Yes</td>
                                <td class="border px-4 py-2 text-gray-900 text-center">No</td>
                                <td class="border px-4 py-2 text-gray-900 text-center">Attendance</td>
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
                                <th class="px-4 py-2 text-gray-900 text-center">Date</th>
                                <th class="px-4 py-2 text-gray-900 text-center">Observation</th>
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

    <script>
        document.getElementById('generatePdfButton').addEventListener('click', function() {
            if (confirm('Do you want to download the PDF?')) {
                var form = document.getElementById('pdfForm');
                var formData = new FormData(form);
                var xhr = new XMLHttpRequest();

                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.responseType = 'blob';

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        var matches = /filename="([^"]*)"/.exec(disposition);
                        var filename = (matches != null) ? matches[1] : 'downloaded.pdf';

                        var blob = new Blob([xhr.response], { type: 'application/pdf' });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = filename;
                        link.click();
                        document.getElementById('loadingMessage').style.display = 'none';
                    }
                };

                xhr.onprogress = function(event) {
                    if (event.lengthComputable) {
                        var percentComplete = (event.loaded / event.total) * 100;
                        // Indicador de progreso
                    }
                };

                xhr.onerror = function() {
                    alert('An error occurred while downloading the file.');
                    document.getElementById('loadingMessage').style.display = 'none';
                };

                document.getElementById('loadingMessage').style.display = 'block';
                xhr.send(formData);
            }
        });
    </script>
</x-app-layout>