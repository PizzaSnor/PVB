<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <x-slot name="header">
        <h2 class="font-semibold text-heading4 text-gray-800 leading-tight">
            {{ __('Occasion toevoegen') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex">
            @include('menus.admin_menu')

            <div class="w-full ml-4">
                <div class="flex flex-col justify-start">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <form action="{{ route('dashboard.occasions.create') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="mb-3 flex">
                                <div class="w-1/2 mr-4">
                                    <label for="title" class="form-label block">Titel</label>
                                    <input type="text"
                                        class="form-control bg-gray-100 border-none w-full focus:outline-yellow focus:ring-0 focus:border-yellow @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title') }}">
                                    @error('title')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="w-1/2">
                                    <label for="price" class="form-label block">Prijs</label>
                                    <input type="number"
                                        class="form-control bg-gray-100 border-none w-full focus:outline-yellow focus:ring-0 focus:border-yellow @error('price') is-invalid @enderror"
                                        id="price" name="price" value="{{ old('price') }}">
                                    @error('price')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label block">Beschrijving</label>
                                <textarea rows="6" class="form-control bg-gray-100 border-none w-full @error('description') is-invalid @enderror"
                                    id="description" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 flex">
                                <div class="w-1/2 mr-4">
                                    <label for="licence_plate" class="form-label block">Kenteken</label>
                                    <input type="text"
                                        class="form-control bg-gray-100 border-none w-full focus:outline-yellow focus:ring-0 focus:border-yellow @error('licence_plate') is-invalid @enderror"
                                        id="licence_plate" name="licence_plate" value="{{ old('licence_plate') }}">
                                    @error('licence_plate')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="w-1/2">
                                    <label for="odometer" class="form-label block">Kilometerstand</label>
                                    <input type="number"
                                        class="form-control bg-gray-100 border-none w-full focus:outline-yellow focus:ring-0 focus:border-yellow @error('odometer') is-invalid @enderror"
                                        id="odometer" name="odometer" value="{{ old('odometer') }}">
                                    @error('odometer')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 flex">
                                <div class="w-1/2 mr-4">
                                    <label for="transmission" class="form-label block">Transmissie</label>
                                    <select id="transmission" name="transmission"
                                        class="form-select bg-gray-100 border-none w-64 block focus:outline-yellow focus:ring-0 focus:border-yellow @error('transmission') is-invalid @enderror">
                                        <option value="Automaat"
                                            {{ old('transmission') === 'Automaat' ? 'selected' : '' }}>
                                            Automaat</option>
                                        <option value="Schakel"
                                            {{ old('transmission') === 'Schakel' ? 'selected' : '' }}>
                                            Schakel</option>
                                        <option value="Semi-automaat"
                                            {{ old('transmission') === 'Semi-automaat' ? 'selected' : '' }}>
                                            Semi-automaat</option>
                                    </select>
                                    @error('transmission')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="w-1/2 mr-4">
                                    <label for="power" class="form-label block">Vermogen in PK</label>
                                    <input type="text"
                                        class="form-control bg-gray-100 border-none w-64 block focus:outline-yellow focus:ring-0 focus:border-yellow @error('power') is-invalid @enderror"
                                        id="power" name="power" value="{{ old('power') }}">
                                    @error('power')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 d-flex flex-column">
                                <label for="images" class="form-label">Afbeelding(en) toevoegen</label>
                                <input type="file" name="images[]" multiple accept="image/*" class="@error('images') is-invalid @enderror">
                                @error('images')
                                    @foreach ($errors->get('images') as $error)
                                        <div class="text-red-500">{{ $error }}</div>
                                    @endforeach
                                @enderror
                            </div>
                            

                            <div class="mb-3 flex justify-end">
                                <a href="{{ route('dashboard.occasions.index') }}" class="m-2 underline">Terug</a>
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
