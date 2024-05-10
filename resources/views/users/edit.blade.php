<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <x-slot name="header">
        <h2 class="font-semibold text-heading4 text-gray-800 leading-tight">
            {{ __('Gebruikers') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <div class="flex">
            @include('menus.admin_menu')

            <div class="w-full ml-4">
                <div class="flex flex-col justify-start">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <form action="{{ route('dashboard.users.update', ['user' => $user]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <h2 class="font-semibold text-heading5 text-gray-800 leading-tight py-2">
                                {{ __($user->name .' aanpassen') }}
                            </h2>
                            <div class="mb-3">
                                <label for="name" class="form-label block">Naam</label>
                                <input type="text" class="form-control bg-gray-100 border-none w-64 block @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label block">E-mailadres</label>
                                <input type="text" class="form-control bg-gray-100 border-none w-64 block @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="text-500-red">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="role_id" class="form-label block">Rol</label>
                                <select class="form-control select2 bg-gray-100 border-none w-64 block @error('role_id') is-invalid @enderror"
                                        id="role_id" name="role_id">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                                @if ($role->id == old('role_id', $user->role_id)) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            

                            <div class="mb-3 flex justify-end">
                                <a href="{{ route('dashboard.users.index') }}" class="m-2 underline">Terug</a>
                                <input type="submit"
                                    class="rounded-md bg-orange cursor-pointer px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                    value="Gebruiker Aanpassen">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

</x-app-layout>
