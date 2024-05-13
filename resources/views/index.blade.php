<x-app-layout>
    <main>
        <div class="relative">
            <img class="absolute z-0 w-full h-96 object-cover filter brightness-50 " src="{{ URL::asset('/images/autobedrijf.jpg') }}" alt="">
            <div class="flex flex-col absolute top-0 left-0 w-full h-full items-center justify-center z-10">
                <div class="text-white text-center mt-96">
                    <h1 class="text-4xl font-bold">NP-Auto</h1>
                    <p class="mt-4 text-md md:text-lg md:w-1/2 px-4 mx-auto">Altijd al je auto willen verkopen?  Of wil je gewoon een
                        simpele onderhoudsbeur?Hier kan het gemakkelijk en snel!
                        Verkoop je auto aan ons zodat wij er winst op kunnen maken!
                        Ook kan je hier gemakkelijk occasions bekijken!
                    </p>
                    <div class="flex justify-center gap-12 mt-10">
                        <x-basic-button content="Plan service"/>
                        <x-yellow-button content="Occasions"/>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="pt-96"></div>
    <div class="flex flex-col items-center">
        <h1 class="text-4xl mx-4 text-center my-8">Onze nieuwste occasions!</h1>
        <div class="flex justify-center flex-col md:flex-row flex-wrap gap-4">
        @forelse($occasions as $occasion)
            <x-occasion-card :occasion="$occasion" />
        @empty
            <p>Niks beschikbaar :(</p>
        @endforelse
        </div>
    </div>
    <x-footer />
</x-app-layout>
