<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Observations Create ') }}
        </h2>
    </x-slot>

   <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 lg:p-4">

            @if(session('success'))
                <div style="color: green;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('observations.store') }}">
            @csrf
            <input type="hidden" name="student_id" value="{{ $student->id }}">
                <div class="mb-3">
                    <label for="obs" class="block mb-2 text-lg font-medium text-gray-900">{{ $student->name }} {{ $student->surname }}</label>
                    <input type="text" name="obs" id="obs" required class="border border-gray-300 p-2 w-full">
                    @error('obs')
                        <div style="color: red;">{{ $message }}</div>
                    @enderror
                </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save</button>
            </form>

            <div class="mb-6">
                        <a href="{{route('students.index') }}" class="text-white bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center float-right sm:w-auto"><i class="bi bi-house"></i> Home</a>
            </div>

            </div>
        </div>
    </div>
</x-app-layout>