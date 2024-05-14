<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <x-slot name="header">
        <h2 class="font-semibold text-heading4 text-gray-800 leading-tight">
            {{ __($car->licence_plate. ' afronden') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <div class="flex">
            @include('menus.admin_menu')

            <div class="w-full ml-4">
                <div class="flex flex-col justify-start">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <form action="{{ route('dashboard.service.finish', ['car' => $car]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        
                            <div class="mb-3">
                                <label for="description" class="form-label block ">Bericht over de auto's onderhoudsbeurt</label>
                                <textarea rows="6" class="form-control bg-gray-100 border-none w-full @error('description') is-invalid @enderror"
                                    id="description" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="mb-3 flex justify-end">
                                <a href="{{ route('dashboard.service.index') }}" class="m-2 underline">Terug</a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

</x-app-layout>
