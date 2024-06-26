<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 lg:p-4">


                @if(count($errors))
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                <form method="POST" action="{{ route('students.update', $student->id) }}" class="max-w-sm mx-auto">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    </div>

                    <div class="mb-3">
                        <label for="surname" class="block mb-2 text-sm font-medium text-gray-900">Surname</label>
                        <input type="text" name="surname" id="surname" value="{{ old('surname', $student->surname) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    </div>

                    <div class="mb-3">
                        <label for="course" class="block mb-2 text-sm font-medium text-gray-900">Course</label>
                        <select class="form-select" name="select_course[]">
                            @foreach($course as $cour)
                                <option value="{{$cour->id}}"
                                {{ in_array($cour->id, $student->course->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $cour->name }}
                                </option> 
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900">Subject</label>
                        <select name="select_subject[]">
                            @foreach($subject as $sub)
                                <option value="{{$sub->id}}"
                                {{ in_array($sub->id, $student->subject->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $sub->name }}
                                </option> 
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="obs" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                        <p>Obs: 1 Active | 0 Inactive</p>
                        <input type="text" name="status" id="status" value="{{ old('status', $student->status) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    </div>
                    
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update</button>
                    <a href="{{ route('students.index') }}" class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
