<div class="w-1/6 bg-white h-fit rounded-lg sticky top-0  shadow-md">
    <div class="flex flex-col justify-start h-full">
        <ul class="list-group text-center space-y-2 py-2">
            <li class="list-group-item">
                <a href="{{ route('dashboard.users.index') }}" class="btn btn-light btn-block text-decoration-none font-bold text-xl text-gray-800 hover:bg-gray-200 block w-full p-2">Gebruikers</a>
            </li>
            <li class="list-group-item">
                <form action="{{ route('logout') }}" method="POST" class="inline-block btn btn-light btn-block text-decoration-none font-bold text-xl text-gray-800 hover:bg-gray-200 w-full p-2">
                    @csrf
                    <button type="submit" class="">Uitloggen</button>
                </form>
            </li>
        </ul>
    </div>
</div>
