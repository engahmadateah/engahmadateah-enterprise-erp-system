@extends('layouts.app')

@section('title','Edit Role')

@section('content')

<div class="max-w-6xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Edit Role
        </h1>

        <p class="text-orange-100 mt-2">
            Update role information and manage assigned permissions.
        </p>

    </div>



    {{-- Form --}}
    <form
        method="POST"
        action="{{ route('roles.update',$role) }}"
        class="bg-white rounded-3xl shadow-xl border border-slate-200">


        @csrf
        @method('PUT')



        <div class="p-8 space-y-8">



            {{-- Role Name --}}
            <div>


                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Role Name
                </label>


                <input
                    type="text"
                    name="name"
                    value="{{ old('name',$role->name) }}"
                    placeholder="Example: HR Manager"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-orange-100
                           focus:border-orange-500 outline-none transition">


                @error('name')

                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror


            </div>




            {{-- Permissions Header --}}
            <div>


                <div class="flex items-center justify-between mb-5">


                    <div>

                        <h2 class="text-xl font-bold text-slate-800">
                            Permissions
                        </h2>

                        <p class="text-slate-500 text-sm">
                            Modify the permissions assigned to this role.
                        </p>

                    </div>



                    <button
                        type="button"
                        id="togglePermissions"
                        class="px-4 py-2 bg-orange-100 text-orange-700 rounded-xl hover:bg-orange-200 transition">

                        Select All

                    </button>


                </div>




                {{-- Permissions --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">


                    @foreach($permissions as $permission)


                        <label
                            class="flex items-center gap-4 border border-slate-200 rounded-xl p-4
                                   hover:bg-orange-50 hover:border-orange-300
                                   cursor-pointer transition">


                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->name }}"
                                class="permission-checkbox rounded text-orange-600 focus:ring-orange-500"

                                @checked(
                                    $role->hasPermissionTo($permission->name)
                                )
                            >



                            <div>


                                <div class="font-medium text-slate-800">

                                    {{ ucwords(str_replace('.',' → ',$permission->name)) }}

                                </div>


                                <div class="text-xs text-slate-400">

                                    {{ $permission->name }}

                                </div>


                            </div>


                        </label>


                    @endforeach


                </div>


            </div>



        </div>





        {{-- Footer --}}
        <div class="border-t bg-slate-50 px-8 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">


            <div class="text-sm text-slate-400">

                Current Role:

                <span class="font-semibold text-orange-600">

                    {{ $role->name }}

                </span>

            </div>



            <div class="flex justify-end gap-4">


                <a href="{{ route('roles.index') }}"
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

                    Update Role

                </button>


            </div>


        </div>



    </form>


</div>



<script>

const toggleButton = document.getElementById('togglePermissions');


toggleButton.addEventListener('click', function () {


    const checkboxes = document.querySelectorAll('.permission-checkbox');


    const allChecked = [...checkboxes].every(item => item.checked);


    checkboxes.forEach(item => item.checked = !allChecked);


    this.innerText = allChecked ? 'Select All' : 'Unselect All';


});


</script>


@endsection