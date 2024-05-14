<x-app-layout>
    <div class="xl:mx-80">
        <div class="py-4">
            <a href="{{ route('occasions.home') }}">
                <x-yellow-button content="Terug" />
            </a>
        </div>
        <main class="bg-white p-4 shadow-lg rounded-lg">
            @if($occasion->sold && $occasion->show_when_sold)
                <div class="flex justify-center bg-yellow text-4xl font-bold rounded-lg py-4 mb-4">
                    <h1>VERKOCHT</h1>
                </div>
            @endif
            <x-image-container :imageId="$imageId" :occasion="$occasion" />
            <div class="flex flex-col gap-y-4">
                <div class="flex justify-between">
                    <h1 class="text-4xl font-bold">{{ $occasion->brand }} {{ $occasion->model }}</h1>
                    <h1 class="text-4xl font-bold text-green-500">€{{ number_format($occasion->price, 0, '', '.') }}</h1>
                </div>
                <div class="flex flex-col gap-y-2">
                    <h2 class="text-2xl">{{ $occasion->title }}</h2>
                    <p>{{ $occasion->description }}</p>
                </div>
                <div class="flex flex-col gap-y-4 md:flex-row justify-between">
                    <ul class="text-lg flex flex-col flex-wrap">
                        <li><strong>- Kenteken: </strong>{{ $occasion->licence_plate }}</li>
                        <li><strong>- Tellerstand: </strong>{{ $occasion->odometer }} KM</li>
                        <li><strong>- Vermogen: </strong>{{ $occasion->power }} PK</li>
                        <li><strong>- Merk: </strong>{{ $occasion->brand }}</li>
                        <li><strong>- Model: </strong>{{ $occasion->model }}</li>
                        <li><strong>- Kleur: </strong>{{ $occasion->color }}</li>
                        <li><strong>- Carroserievorm: </strong>{{ $occasion->body }}</li>
                        <li><strong>- Aantal deuren: </strong>{{ $occasion->doors }}</li>
                        <li><strong>- Aantal stoelen: </strong>{{ $occasion->seats }}</li>
                        <li><strong>- Brandstofsoort: </strong>{{ $occasion->fuel_type }}</li>
                        <li><strong>- Bouwjaar: </strong>{{ $occasion->year }}</li>
                        <li><strong>- Motorinhoud: </strong>{{ $occasion->cc }} cc</li>
                        <li><strong>- Gewicht: </strong>{{ $occasion->weight }}</li>
                    </ul>
                    <div class="bg-black rounded-lg p-4 h-fit flex flex-col gap-y-4 md:w-fit">
                        <h1 class="text-yellow font-bold text-4xl">Interesse?</h1>
                        <p class="bg-white px-4 py-2 font-bold text-center rounded-lg">{{ $siteInfo->contact_number }}</p>
                        <p class="bg-white px-4 py-2 font-bold text-center rounded-lg">{{ $siteInfo->contact_email }}</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <x-footer />
</x-app-layout>
