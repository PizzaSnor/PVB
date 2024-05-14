<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-heading4 text-gray-800 leading-tight">
                {{ __('Occasions') }}
            </h2>
            <x-primary-button class="ms-3">
                <a href="{{ route('dashboard.occasions.create') }}">
                    {{ __('Auto toevoegen') }}
                </a>
            </x-primary-button>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <div class="flex">
            @include('menus.admin_menu')

            <div class="w-full ml-4">
                <div class="flex flex-col justify-start">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-semibold">Occasions</h2>
                            <form action="{{ route('dashboard.occasions.index') }}" method="GET" class="flex">
                                <input type="text" value="{{ $query }}" name="query"
                                    class="form-input w-48 focus:outline-none focus:ring-0 focus:border-yellow border-yellow"
                                    placeholder="Zoek...">
                                <button type="submit"
                                    class="rounded-s-none rounded-md bg-yellow px-3 py-2 text-sm font-semibold text-black shadow-sm hover:bg-lime-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-lime-300">Zoeken</button>
                            </form>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full bg-white shadow-md rounded my-6">
                                <thead>
                                    <tr class="bg-slate-100 border">
                                        <th class="text-lg px-4 py-2 text-left">Merk en model</th>
                                        <th class="text-lg hidden md:table-cell px-4 py-2 text-left">Kenteken</th>
                                        <th class="text-lg hidden md:table-cell px-4 py-2 text-left">Verkocht</th>
                                        <th class="px-4 py-2"></th>

                                        <th class="text-lg px-4 py-2 text-left">
                                            <a
                                                href="{{ route('dashboard.occasions.index', ['sort_by' => 'brand', 'sort_direction' => $sortBy === 'brand' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                                Brand
                                                @if ($sortBy === 'brand')
                                                    @if ($sortDirection === 'asc')
                                                        <i class="fas fa-sort-up"></i>
                                                    @else
                                                        <i class="fas fa-sort-down"></i>
                                                    @endif
                                                @endif
                                            </a>
                                        </th>
                                        <th class="text-lg px-4 py-2 text-left">
                                            <a
                                                href="{{ route('dashboard.occasions.index', ['sort_by' => 'price', 'sort_direction' => $sortBy === 'price' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                                Price
                                                @if ($sortBy === 'price')
                                                    @if ($sortDirection === 'asc')
                                                        <i class="fas fa-sort-up"></i>
                                                    @else
                                                        <i class="fas fa-sort-down"></i>
                                                    @endif
                                                @endif
                                            </a>
                                        </th>
                                        <th class="px-4 py-2"></th>
                                        <th class="px-4 py-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($occasions as $occasion)
                                        <tr class="even:bg-white odd:bg-slate-100 border">
                                            <td class="px-4 py-2 text-left">{{ $occasion->brand }}
                                                {{ $occasion->model }}</td>
                                            <td class="hidden md:table-cell  px-4 py-2 text-left">
                                                {{ $occasion->licence_plate }}</td>
                                            @if ($occasion->sold)
                                                <td class="hidden md:table-cell  px-4 py-2 text-left">Ja</td>
                                                <td></td>
                                            @else
                                                <td class="hidden md:table-cell  px-4 py-2 text-left">Nee</td>
                                                <td class="w-fit px-4 py-2">
                                                    <form
                                                        action="{{ route('dashboard.occasions.sell', $occasion->id) }}"
                                                        method="post" class="inline-block"
                                                        onsubmit="return confirm('Weet je zeker dat je deze occasion als verkocht wil markeren?');">
                                                        @csrf
                                                        @method('put')
                                                        <button>
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m4.5 12.75 6 6 9-13.5" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endif
                                            <td class="hidden md:table-cell px-4 py-2 text-left"></td>
                                            <td class="hidden md:table-cell px-4 py-2 text-left"></td>

                                            <td class="w-fit px-4 py-2">
                                                @can('delete', $occasion)
                                                    <a class="btn"
                                                        href="{{ route('dashboard.occasions.edit', $occasion->id) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" fill="currentColor" class="bi bi-pen-fill"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z" />
                                                        </svg>
                                                    </a>
                                                @endcan
                                            </td>

                                            <td class="w-fit px-4 py-2">
                                                @can('delete', $occasion)
                                                    <form
                                                        action="{{ route('dashboard.occasions.destroy', $occasion->id) }}"
                                                        method="post" class="inline-block"
                                                        onsubmit="return confirm('Weet je zeker dat je deze occasion wilt verwijderen?');">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn" type="submit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" fill="currentColor" class="bi bi-trash-fill"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center border px-4 py-2">Geen occasions
                                                gevonden.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $occasions->links('pagination::tailwind') }}
                        </div>
                        
                    </div>
                </div>
            </div>
            
        </div>
        <div class="flex mt-8 gap-x-4 items-stretch">
            <div class="w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6 h-full">
                    <h2 class="text-2xl font-semibold mb-4">Verkochte auto's (Afgelopen week)</h2>
                    <p><strong>Aantal:</strong> {{ $soldLastWeek }}</p>
                    <p><strong>Omzet:</strong> €{{ number_format($revenueLastWeek, 2) }}</p>
                </div>
            </div>
        
            <div class="w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6 h-full">
                    <h2 class="text-2xl font-semibold mb-4">Verkochte auto's (Afgelopen maand)</h2>
                    <p><strong>Aantal:</strong> {{ $soldLastMonth }}</p>
                    <p><strong>Omzet:</strong> €{{ number_format($revenueLastMonth, 2) }}</p>
                </div>
            </div>
        
            <div class="w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6 h-full">
                    <h2 class="text-2xl font-semibold mb-4">Totale omzet (Allertijde)</h2>
                    <p><strong>Omzet:</strong> €{{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        
            <div class="w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6 h-full">
                    <h2 class="text-2xl font-semibold mb-4">Auto's op voorraad</h2>
                    <p><strong>Aantal:</strong> {{ $carsInStock }}</p>
                </div>
            </div>
        </div>
        
            </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        //deze is voor sold
        document.querySelectorAll('.sold-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const occasionId = this.getAttribute('data-id');
                const isChecked = this.checked;
                updateOccasion(occasionId, {
                    sold: isChecked
                });
            });
        });
        // deze is voor sold when show
        document.querySelectorAll('.show-when-sold-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const occasionId = this.getAttribute('data-id');
                const isChecked = this.checked;
                updateOccasion(occasionId, {
                    show_when_sold: isChecked
                });
            });
        });

        // fetchen van de data en versturen naar de juiste functie
        function updateOccasion(occasionId, data) {
            fetch(`/dashboard/occasions/${occasionId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network error opgetreden.');
                    }
                    return response.json();
                })
        }
    });
</script>
