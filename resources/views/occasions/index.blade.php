<x-app-layout>
    <div>
        <div class="flex flex-col items-center xl:mx-64">
            <h1 class="text-4xl mx-4 text-center my-8">Onze occasions!</h1>
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
