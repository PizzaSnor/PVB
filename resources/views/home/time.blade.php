<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-heading4 text-gray-800 leading-tight">
            {{ __('Contactgegevens wijzigen') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <div class="flex">
            @include('menus.admin_menu')

            <div class="w-full ml-4">
                <div class="flex flex-col justify-start">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <form action="{{ route('dashboard.home.time') }}" method="post">
                            @csrf
                            @method('PUT')
                            @foreach ($days as $day)
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="mb-3">
                                        <label class="form-label block">
                                            {{ $weekdayNames[$day->weekday] }}
                                        </label>
                                        <input type="time" class="form-control bg-gray-100 border-none w-full"
                                            name="days[{{ $day->id }}][opening_time]"
                                            value="{{ old('days.'.$day->id.'.opening_time', $day->opening_time ? \Carbon\Carbon::parse($day->opening_time)->format('H:i') : '') }}">
                                        @error('days.' . $day->id . '.opening_time')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                        <input type="time" class="form-control bg-gray-100 border-none w-full"
                                            name="days[{{ $day->id }}][closing_time]"
                                            value="{{ old('days.'.$day->id.'.closing_time', $day->closing_time ? \Carbon\Carbon::parse($day->closing_time)->format('H:i') : '') }}">
                                        @error('days.' . $day->id . '.closing_time')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
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
