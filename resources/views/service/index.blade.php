<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-heading4 text-gray-800 leading-tight">
            {{ __("Service auto's") }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <div class="flex">
            @include('menus.admin_menu')

            <div class="w-full ml-4">
                <div class="flex flex-col justify-start">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-semibold">Service auto's</h2>
                            <form action="{{ route('dashboard.service.index') }}" method="GET" class="flex">
                                <input type="text" name="query"
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
                                        <th class="text-lg px-4 py-2 text-left">Kenteken</th>
                                        <th class="text-lg hidden md:table-cell px-4 py-2 text-left">Service datum
                                        </th>
                                        <th class="px-4 py-2 text-left">Afronden</th>
                                        <th class="px-4 py-2 text-left"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($cars as $car)
                                        <tr class="even:bg-white odd:bg-slate-100 border">
                                            <td class="px-4 py-2 text-left">{{ $car->licence_plate }}</td>
                                            <td class="px-4 py-2 text-left">
                                                @if ($car->plannedService->isNotEmpty())
                                                    {{ \Carbon\Carbon::parse($car->plannedService->last()->service_date)->format('d-m-Y') }}
                                                @endif
                                            </td>
                                            </td>
                                            @if ($car->plannedService->isNotEmpty() && !$car->plannedService->last()->completed)
                                                <td class="text-right px-4 py-2">
                                                    <a class="btn"
                                                        href="{{ route('dashboard.service.complete', $car->id) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m4.5 12.75 6 6 9-13.5" />
                                                        </svg>

                                                    </a>
                                                </td>
                                            @else
                                                <td class="px-4 py-2">Afgerond</td>
                                            @endif
                                            <td class="text-left px-4 py-2">
                                                @can('delete', $car)
                                                <form action="{{ route('dashboard.service.destroy', $car->id) }}" method="post" class="inline-block" onsubmit="return confirm('Weet je zeker dat je deze auto wilt verwijderen?');">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endcan
                                            </td>                         
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center border px-4 py-2">Geen auto's
                                                gevonden.</td>
                                        </tr>
                                    @endforelse
                                </tbody>


                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $cars->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
