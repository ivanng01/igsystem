<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('All Student Report')}}
        </h2>
    </x-slot>
    
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-gray-900 text-center">ID</th>
                        <th class="px-4 py-2 text-gray-900 text-center">Surname and Name</th>
                        <th class="px-4 py-2 text-gray-900 text-center">Course</th>
                        <th class="px-4 py-2 text-gray-900 text-center">Porcentage</th>
                    </tr>
                </thead>
                <tbody>
       

                @foreach ($assistances as $assistance)
                @php
                    $percentage = $assistance->total_assistances > 0 ? ($assistance->attended_assistances / $assistance->total_assistances) * 100 : 0;
                @endphp
                <tr>
                    <td class="border px-4 py-2 text-gray-900 text-center">{{ $assistance->student_id }}</td>
                    <td class="border px-4 py-2 text-gray-900 text-center">{{ $assistance->student_surname }} {{ $assistance->student_name }}</td>
                    <td class="border px-4 py-2 text-gray-900 text-center">{{ $assistance->course_name }}</td>
                    <td class="border px-4 py-2 text-center {{ $percentage < 70 ? 'text-red-500' : 'text-gray-900' }}">{{ number_format($percentage, 2) }}%</td>
                </tr>
                @endforeach

                </tbody>
            </table>

            <br>
            <strong>Status Disable</strong>
            <br>
                <table class="table-auto w-full">
                    <thead>
                    <tr>
                        <th class="px-4 py-2 text-gray-900 text-center">ID</th>
                        <th class="px-4 py-2 text-gray-900 text-center">Surname and Name</th>
                        <th class="px-4 py-2 text-gray-900 text-center">Course</th>
                        <th class="px-4 py-2 text-gray-900 text-center">Status</th>
                        
                    </tr>    
                    </thead>
                    <tbody>
                        <tr>
                        @foreach ($coursesAndStudents as $record)
                            <td class="border px-4 py-2 text-gray-900 text-center">{{ $record->student_id }} 
                            <td class="border px-4 py-2 text-gray-900 text-center">{{ $record->student_surname }} {{ $record->student_name }} </td>
                            <td class="border px-4 py-2 text-gray-900 text-center">{{ $record->course_name }} </td>
                            <td class="border px-4 py-2 text-gray-900 text-center">{{ $record->student_status }} </td>
                        </tr>
                        @endforeach
                        </tr>
                    </tbody>
                </table>

                <br>
                <strong>Student Counts by Course</strong>
                <br>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2 text-gray-900 text-center">Course ID</th>
                <th class="px-4 py-2 text-gray-900 text-center">Course Name</th>
                <th class="px-4 py-2 text-gray-900 text-center">Count Active</th>
                <th class="px-4 py-2 text-gray-900 text-center">Count Disabled</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($studentCounts as $count)
            <tr>
                    <td class="border px-4 py-2 text-gray-900 text-center">{{ $count->course_id }}</td>
                    <td class="border px-4 py-2 text-gray-900 text-center">{{ $count->course_name }}</td>
                    <td class="border px-4 py-2 text-gray-900 text-center">{{ $count->count_status_1 }}</td>
                    <td class="border px-4 py-2 text-gray-900 text-center">{{ $count->count_status_0 }}</td>
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

