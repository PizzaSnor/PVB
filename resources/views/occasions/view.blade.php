<x-app-layout>
    <div class="lg:mx-80">
        <div class="py-4">
            <a href="{{ url()->previous() }}">
                <x-yellow-button content="Terug"/>
            </a>
        </div>
        <main class="bg-white p-4 shadow-lg rounded-lg">
    {{--        <x-image-container :images="$occasion->images}}" />--}}
            <div class="flex flex-col gap-y-4">
                <div class="flex justify-between">
                    <h1 class="text-4xl font-bold">{{ $occasion->brand }} {{$occasion->model}}</h1>
                    <h1 class="text-4xl text-green-500">€{{ $occasion->price }}</h1>
                </div>
                <div class="flex flex-col gap-y-2">
                    <h2 class="text-2xl">{{$occasion->title}}</h2>
                    <p>{{$occasion->description}}</p>
                </div>
                <div>
                    <ul class="text-lg ">
                        <li><strong>Kenteken: </strong>{{$occasion->licence_plate}}</li>
                        <li><strong>Merk: </strong>{{$occasion->brand}}</li>
                        <li><strong>Model: </strong>{{$occasion->model}}</li>
                        <li><strong>Tellerstand: </strong>{{$occasion->odometer}} KM</li>
                        <li><strong>Carroserievorm: </strong>{{$occasion->body}}</li>
{{--                        <li><strong>Transmissie: </strong>{{$occasion->transmission}}</li>--}}
                        <li><strong>Aantal deuren: </strong>{{$occasion->doors}}</li>
                        <li><strong>Brandstofsoort: </strong>{{$occasion->fuel_type}}</li>
                        <li><strong>Bouwjaar: </strong>{{$occasion->year}}</li>
                        <li><strong>Kleur: </strong>{{$occasion->color}}</li>
                        <li><strong>Motorinhoud: </strong>{{$occasion->cc}}</li>
                        <li><strong>Aantal cilinders: </strong>{{$occasion->cc}} cc</li>
                        <li><strong>Vermogen: </strong>{{$occasion->power}} KW</li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
    <x-footer />
</x-app-layout>
