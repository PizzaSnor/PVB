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
                        <form action="{{ route('dashboard.home.contact.update') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="mb-3">
                                        <label for="contact_email" class="form-label block">Contact E-mail</label>
                                        <input type="email"
                                            class="form-control bg-gray-100 border-none w-full @error('contact_email') is-invalid @enderror"
                                            id="contact_email" name="contact_email"
                                            value="{{ old('contact_email', $landingPageContent->contact_email) }}">
                                        @error('contact_email')
                                            <div class="text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-3">
                                        <label for="contact_number" class="form-label block">Contact Nummer</label>
                                        <input type="text"
                                            class="form-control bg-gray-100 border-none w-full @error('contact_number') is-invalid @enderror"
                                            id="contact_number" name="contact_number"
                                            value="{{ old('contact_number', $landingPageContent->contact_number) }}">
                                        @error('contact_number')
                                            <div class="text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-3">
                                        <label for="address_line" class="form-label block">Adres</label>
                                        <input type="text"
                                            class="form-control bg-gray-100 border-none w-full @error('address_line') is-invalid @enderror"
                                            id="address_line" name="address_line"
                                            value="{{ old('address_line', $landingPageContent->address_line) }}">
                                        @error('address_line')
                                            <div class="text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-3">
                                        <label for="city" class="form-label block">Stad</label>
                                        <input type="text"
                                            class="form-control bg-gray-100 border-none w-full @error('city') is-invalid @enderror"
                                            id="city" name="city"
                                            value="{{ old('city', $landingPageContent->city) }}">
                                        @error('city')
                                            <div class="text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        
                            <div class="mb-3 flex justify-end">
                                <a href="{{ route('dashboard.tasks.index') }}" class="m-2 underline">Terug</a>
                                <button type="submit"
                                    class="rounded-md bg-orange cursor-pointer px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Opdracht
                                    Aanpassen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
    
</x-app-layout>
