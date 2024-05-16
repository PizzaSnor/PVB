<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-heading4 text-gray-800 leading-tight">
            {{ __('Auto voor service aanmelden') }}
        </h2>
    </x-slot>

    <div class="max-w-9xl md:mx-40 py-6 px-4 sm:px-6 lg:px-8 md:mt-[100px]">

        <div class="flex flex-col md:flex-row justify-between md:mb-16">
            <div class="md:w-3/5 mx-6">
                <p class="text-heading4 mt-2">Voor <span class="text-yellow">service</span> en <span
                        class="text-yellow">onderhoud</span> van alle <span class="text-yellow">merken</span> bent u bij
                    ons aan het juiste adres!</p>
                <ul class="list-disc list-inside mt-4 text-heading5">
                    <li>Al ruim 20 jaar in de auto-industrie.</li>
                    <li>Lage kosten betekenen lage prijzen voor u.</li>
                    <li>Onze monteurs hebben meer dan 15 jaar ervaring.</li>
                    <li>RDW erkend.</li>
                </ul>
            </div>
            <div class="md:w-2/5 mt-8 md:mt-0">
                <div class="flex flex-col justify-start">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <form action="{{ route('service.create') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="licence_plate" class="form-label block">Kenteken</label>
                                <input type="text"
                                    class="form-control bg-gray-100 border-none w-full block focus:outline-yellow focus:ring-0 focus:border-yellow @error('licence_plate') is-invalid @enderror"
                                    id="licence_plate" name="licence_plate" value="{{ old('licence_plate') }}">
                                @error('licence_plate')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="odometer" class="form-label block">Kilometerstand</label>
                                <input type="text"
                                    class="form-control bg-gray-100 border-none w-full block focus:outline-yellow focus:ring-0 focus:border-yellow @error('odometer') is-invalid @enderror"
                                    id="odometer" name="odometer" value="{{ old('odometer') }}">
                                @error('odometer')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="service_date" class="form-label block">Service Datum</label>
                                <input type="date"
                                    class="form-control bg-gray-100 border-none w-full block focus:outline-yellow focus:ring-0 focus:border-yellow @error('service_date') is-invalid @enderror"
                                    id="service_date" name="service_date" value="{{ old('service_date') }}">
                                @error('service_date')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 flex justify-end">
                                <a href="{{ route('home') }}" class="m-2 underline">Terug</a>
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
        <x-footer />
</x-app-layout>


