<x-app-layout>
    @vite('resources/css/app.css')

    <x-slot name="header">
        <h2 class="font-semibold text-heading4 text-gray-800 leading-tight">
            {{ __('Algemene informatie wijzigen') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <div class="flex">
            @include('menus.admin_menu')

            <div class="w-full ml-4">
                <div class="flex flex-col justify-start">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <form action="{{ route('dashboard.home.general.update') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 ">
                                <label for="main_content" class="form-label block">Algemene Informatie</label>
                                <textarea id="main_content" name="main_content" rows="6"
                                    class="form-control prose  bg-gray-100 border-none w-full @error('main_content') is-invalid @enderror">{{ old('main_content', isset($contactInfo) ? $contactInfo->main_content : '') }}</textarea>
                                @error('main_content')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="max_cars_per_day" class="form-label block">Maximaal aantal auto's per dag <i>( vanaf nu geplande service auto's )</i></label>
                                <input type="number"
                                    class="form-control bg-gray-100 border-none w-full focus:outline-yellow focus:ring-0 focus:border-yellow @error('max_cars_per_day') is-invalid @enderror"
                                    id="max_cars_per_day" name="max_cars_per_day" value="{{ old('max_cars_per_day', isset($contactInfo) ? $contactInfo->max_cars_per_day : '') }}">
                                @error('max_cars_per_day')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 flex justify-end">
                                <a href="{{ route('dashboard.users.index') }}" class="m-2 underline">Terug</a>
                                <x-primary-button class="ms-3">
                                    {{ __('Opslaan') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
