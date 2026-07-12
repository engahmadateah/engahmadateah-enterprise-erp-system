@extends('layouts.app')

@section('title','Create Role')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Create Role
        </h1>

        <p class="text-indigo-100 mt-2">
            Create a new role and assign permissions.
        </p>

    </div>


    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">

        <form
            action="{{ route('roles.store') }}"
            method="POST"
            class="space-y-8">

            @csrf

            {{-- Role Name --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Role Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Example: HR Manager"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">

                @error('name')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Permissions Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>

                    <h2 class="text-2xl font-bold text-slate-800">
                        Permissions
                    </h2>

                    <p class="text-slate-500 mt-1">
                        Select the permissions assigned to this role.
                    </p>

                </div>

                <button
                    type="button"
                    id="togglePermissions"
                    class="px-6 py-3 rounded-xl
                           bg-indigo-100 text-indigo-700
                           hover:bg-indigo-200
                           font-semibold transition">

                    Select All

                </button>

            </div>


            {{-- Permissions Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($permissions as $permission)

<label
    class="flex items-center gap-4
           border border-slate-200
           rounded-xl
           p-5
           hover:bg-indigo-50
           hover:border-indigo-300
           cursor-pointer
           transition">

    <input
        type="checkbox"
        name="permissions[]"
        value="{{ $permission->name }}"
        class="rounded text-indigo-600 permission-checkbox">


    <div>

        <div class="font-semibold text-slate-800">

            {{ ucwords(str_replace('.',' → ',$permission->name)) }}

        </div>

        <div class="text-sm text-slate-400 mt-1">

            {{ $permission->name }}

        </div>

    </div>

</label>

@endforeach

</div>


{{-- Buttons --}}
<div class="flex justify-end gap-4 pt-4">

<a href="{{ route('roles.index') }}"
   class="px-6 py-3 rounded-xl
          border border-slate-300
          text-slate-700
          hover:bg-slate-100
          transition">

    Cancel

</a>


<button
    type="submit"
    class="px-8 py-3 rounded-xl
           bg-gradient-to-r from-indigo-600 to-violet-600
           hover:from-indigo-700 hover:to-violet-700
           text-white font-semibold
           shadow-lg
           transition">

    Save Role

</button>

</div>


</form>

</div>

</div>


<script>

document.getElementById('togglePermissions').addEventListener('click', function () {

let checkboxes = document.querySelectorAll('.permission-checkbox');

let allChecked = [...checkboxes].every(c => c.checked);

checkboxes.forEach(c => c.checked = !allChecked);

this.innerText = allChecked ? 'Select All' : 'Unselect All';

});

</script>


@endsection