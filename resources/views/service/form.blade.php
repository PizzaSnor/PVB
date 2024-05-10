<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <x-slot name="header">
        <h2 class="font-semibold text-heading4 text-gray-800 leading-tight">
            {{ __('Auto voor service aanmelden') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <div class="flex">

            <div class="w-full ml-4">
                <div class="flex flex-col justify-start">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <form action="{{ route('service.create') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="licence_plate" class="form-label block">Kenteken</label>
                                <input type="text" class="form-control bg-gray-100 border-none w-64 block focus:outline-yellow focus:ring-0 focus:border-yellow @error('licence_plate') is-invalid @enderror"
                                    id="licence_plate" name="licence_plate" value="{{ old('licence_plate') }}">
                                @error('licence_plate')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="odometer" class="form-label block">Kilometerstand</label>
                                <input type="text" class="form-control bg-gray-100 border-none w-64 block focus:outline-yellow focus:ring-0 focus:border-yellow @error('odometer') is-invalid @enderror"
                                    id="odometer" name="odometer" value="{{ old('odometer') }}">
                                @error('odometer')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="mb-3 flex justify-end">
                                <a href="{{ route('dashboard') }}" class="m-2 underline">Terug</a>
                                    <x-primary-button class="ms-3">
                                        {{__('Opslaan') }}
                                    </x-primary-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
