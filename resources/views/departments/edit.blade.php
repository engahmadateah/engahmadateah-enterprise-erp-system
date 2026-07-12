@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')

<div class="max-w-4xl mx-auto space-y-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Edit Department
        </h1>

        <p class="text-orange-100 mt-2">
            Update the department information.
        </p>

    </div>

    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">

        <form method="POST"
              action="{{ route('departments.update', $department) }}"
              class="space-y-6">

            @csrf
            @method('PUT')

            {{-- Department Name --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Department Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $department->name) }}"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-orange-100
                           focus:border-orange-500 outline-none transition">

                @error('name')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Department Code --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Department Code
                </label>

                <input
                    type="text"
                    name="code"
                    value="{{ old('code', $department->code) }}"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-orange-100
                           focus:border-orange-500 outline-none transition">

                @error('code')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Description --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="5"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-orange-100
                           focus:border-orange-500 outline-none transition">{{ old('description', $department->description) }}</textarea>

                @error('description')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Status --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-3">
                    Department Status
                </label>

                <label class="inline-flex items-center gap-3 cursor-pointer">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        @checked(old('is_active', $department->is_active))
                        class="w-5 h-5 rounded text-green-600 focus:ring-green-500">

                    <span class="text-slate-700 font-medium">
                        Active Department
                    </span>

                </label>

            </div>

            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-6 border-t">

                <a href="{{ route('departments.index') }}"
                   class="px-6 py-3 rounded-xl border border-slate-300
                          text-slate-700 hover:bg-slate-100 transition">

                    Cancel

                </a>

                <button
                    type="submit"
                    class="px-8 py-3 rounded-xl
                           bg-gradient-to-r from-orange-500 to-red-500
                           hover:from-orange-600 hover:to-red-600
                           text-white font-semibold shadow-lg transition">

                    Update Department

                </button>

            </div>

        </form>

    </div>

</div>

@endsection