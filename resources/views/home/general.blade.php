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
                                    class=" form-control prose  bg-gray-100 border-none w-full @error('main_content') is-invalid @enderror">{{ old('main_content', isset($landingPageContent) ? $landingPageContent->main_content : '') }}</textarea>
                                @error('main_content')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
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
