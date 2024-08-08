<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Assistance') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 lg:p-4">

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <label for="assistances" class="block mb-2 text-lg font-medium text-gray-900">
                {{ $student->surname }} {{ $student->name }}
                @if ($subjects->isNotEmpty())
                    -
                    @foreach ($subjects as $subject)
                        {{ $subject->name }}@if (!$loop->last), @endif
                    @endforeach
                @endif
                </label>
                <br>
                
                <form method="POST" action="{{ route('assistances.update', $student->id) }}">
                @csrf
                @method('PUT')

                <div class="overflow-x-auto flex justify-center">
                    <table class="table-auto" style="width: 35%;">
                        <thead>
                            <tr>
                                <th class="text-left p-2">Date and Time</th>
                                <th class="text-left p-2">Assistance (Yes/No)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assistances as $index => $assistance)
                            <tr>
                                <td class="p-2 border border-gray-300">
                                    <label for="date-{{ $index }}" class="sr-only"></label>
                                    <input type="datetime-local" name="assistances[{{ $index }}][date]" id="date-{{ $index }}" value="{{ \Carbon\Carbon::parse($assistance->date)->format('Y-m-d\TH:i') }}" required class="w-full">
                                </td>
                                <td class="p-2 border border-gray-300 text-center">
                                    <label for="attended-{{ $index }}" class="sr-only"></label>
                                    <input class="form-check-input" type="checkbox" name="assistances[{{ $index }}][attended]" id="attended-{{ $index }}" value="1" {{ $assistance->attended ? 'checked' : '' }}>
                                    <input type="hidden" name="assistances[{{ $index }}][id]" value="{{ $assistance->id }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-center">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update</button>
                    <a href="{{route('assistances.index')}}" class="ml-2 text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Cancel</a>
                </div>
                </form>    


            </div>
        </div>
    </div>
</x-app-layout>
