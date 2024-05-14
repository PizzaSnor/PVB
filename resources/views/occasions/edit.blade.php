<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <x-slot name="header">
        <h2 class="font-semibold text-heading4 text-gray-800 leading-tight">
            {{ __('Occasions') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex">
            @include('menus.admin_menu')

            <div class="w-full ml-4">
                <div class="flex flex-col justify-start">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <form action="{{ route('dashboard.occasions.update', ['occasion' => $occasion]) }}"
                            method="post" enctype="multipart/form-data"
                            onsubmit="return confirm('Als je het kenteken aan hebt gepast word er opnieuw data opgehaald van de RDW, Weet je het zeker?');"
                            >
                            @csrf
                            @method('PUT')
                            <h2 class="font-semibold text-heading5 text-gray-800 leading-tight py-2">
                                {{ __($occasion->brand . ' ' . $occasion->model . ' aanpassen') }}
                            </h2>

                            <div class="mb-3 flex">
                                <div class="w-1/2 mr-4">
                                    <label for="title" class="form-label block">Titel</label>
                                    <input type="text"
                                        class="form-control bg-gray-100 border-none w-full focus:outline-yellow focus:ring-0 focus:border-yellow @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title', $occasion->title) }}">
                                    @error('title')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="w-1/2">
                                    <label for="price" class="form-label block">Prijs</label>
                                    <input type="text"
                                        class="form-control bg-gray-100 border-none w-full focus:outline-yellow focus:ring-0 focus:border-yellow @error('price') is-invalid @enderror"
                                        id="price" name="price" value="{{ old('price', number_format($occasion->price, 0, '', '.')) }}">
                                    @error('price')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label block">Beschrijving</label>
                                <textarea rows="6" class="form-control bg-gray-100 border-none w-full @error('description') is-invalid @enderror"
                                    id="description" name="description">{{ old('description', $occasion->description) }}</textarea>
                                @error('description')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 flex">
                                <div class="w-1/2 mr-4">
                                    <label for="licence_plate" class="form-label block">Kenteken</label>
                                    <input type="text"
                                        class="form-control bg-gray-100 border-none w-full focus:outline-yellow focus:ring-0 focus:border-yellow @error('licence_palte') is-invalid @enderror"
                                        id="licence_plate" name="licence_plate"
                                        value="{{ old('licence_plate', $occasion->licence_plate) }}">
                                    @error('licence_plate')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="w-1/2">
                                    <label for="odometer" class="form-label block">Kilometerstand</label>
                                    <input type="number"
                                        class="form-control bg-gray-100 border-none w-full focus:outline-yellow focus:ring-0 focus:border-yellow @error('odometer') is-invalid @enderror"
                                        id="odometer" name="odometer"
                                        value="{{ old('odometer', $occasion->odometer) }}">
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
                                            {{ old('transmission', $occasion->transmission) === 'Automaat' ? 'selected' : '' }}>
                                            Automaat</option>
                                        <option value="Schakel"
                                            {{ old('transmission', $occasion->transmission) === 'Schakel' ? 'selected' : '' }}>
                                            Schakel</option>
                                        <option value="Semi-automaat"
                                            {{ old('transmission', $occasion->transmission) === 'Semi-automaat' ? 'selected' : '' }}>
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
                                        id="power" name="power" value="{{ old('power', $occasion->power) }}">
                                    @error('power')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 flex">
                                <div class="w-1/2 mr-4">
                                    <label for="sold" class="form-label block">Is verkocht?</label>
                                    <input type="checkbox"
                                        class="form-checkbox h-5 w-5 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded @error('sold') is-invalid @enderror"
                                        id="sold" name="sold" value="1" {{ old('sold', $occasion->sold) ? 'checked' : '' }}>
                                    @error('sold')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="w-1/2 mr-4">
                                    <label for="show_when_sold" class="form-label block">Tonen wanneer verkocht?</label>
                                    <input type="checkbox"
                                        class="form-checkbox h-5 w-5 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded @error('show_when_sold') is-invalid @enderror"
                                        id="show_when_sold" name="show_when_sold" value="1"
                                        {{ old('show_when_sold', $occasion->show_when_sold) ? 'checked' : '' }}>
                                    @error('show_when_sold')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            

                            @if ($occasion->images->isNotEmpty())
                                <div class="mb-3">
                                    <label for="images" class="form-label">Huidige Afbeeldingen</label>
                                    <div class="flex flex-wrap">
                                        @foreach ($occasion->images as $image)
                                            <div class="w-1/4 px-2 mb-3">
                                                <div class="relative">
                                                    <img src="{{ asset('images/' . $image->path) }}" alt="Car Image"
                                                        class="object-cover w-full h-full">
                                                    <div
                                                        class="absolute top-0 right-0 bg-yellow text-white px-2 py-1 rounded-lg rounded-t-none cursor-pointer">
                                                        <input type="checkbox" name="remove_images[]"
                                                            value="{{ $image->id }}" class="mr-2">
                                                        Verwijder
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3 d-flex flex-column">
                                <label for="images" class="form-label">Afbeelding(en) toevoegen</label>
                                <input type="file" name="images[]" multiple accept="image/*">
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
