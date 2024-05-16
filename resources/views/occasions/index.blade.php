<x-app-layout>
    <div @class(['h-[calc(100vh-15rem)]' => count($occasions) <= 4])>
        <div class="flex flex-col items-center xl:mx-64">

            <div class="flex items-center flex-col md:flex-row mb-4 justify-between">
                <h1 class="text-4xl mx-4 text-center my-8">Onze occasions!</h1>
                <form action="{{ route('occasions.home') }}" method="GET" class="flex">
                    <input type="text" value="{{ $query }}" name="query"
                        class="form-input w-48 focus:outline-none focus:ring-0 focus:border-yellow border-yellow"
                        placeholder="Zoek...">
                    <button type="submit"
                        class="rounded-s-none rounded-md bg-yellow px-3 py-2 text-sm font-semibold text-black shadow-sm hover:bg-lime-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-lime-300">Zoeken</button>
                </form>
            </div>
            <div class="flex justify-center flex-col md:flex-row flex-wrap gap-4">
                @forelse($occasions as $occasion)
                    <a href="{{ route('occasions.view', ['id' => $occasion->id]) }}">
                        <x-occasion-card :occasion="$occasion" />
                    </a>
                @empty
                    <p>Niks beschikbaar :(</p>
                @endforelse
            </div>
        </div>
        <div class="pagination mx-6 xl:mx-80 mt-6">
            {{ $occasions->links() }}
        </div>
    </div>
    <x-footer />
</x-app-layout>
