    <div class="p-2 bg-white rounded-xl shadow-2xl hover:brightness-90 cursor-pointer">
        <div class="w-80 h-40 object-contain overflow-hidden relative">
            @if($occasion->images->isNotEmpty())
                <img class="w-80 h-40 object-cover absolute rounded-md" src="{{ asset('images/' . $occasion->images[0]->path) }}" alt="Occasion image">
            @else
                <img class="w-80 h-40 object-cover absolute rounded-md" src="{{ URL::asset('images/carPlaceholder.png')}}" alt="Occasion placeholder image">
            @endif
            @if($occasion->sold && $occasion->show_when_sold)
                <div class="z-10 absolute bg-yellow w-96 top-10 -left-10 py-4 text-center text-4xl font-bold transform rotate-12">
                    VERKOCHT
                </div>
            @endif
        </div>
        <div>
            <div class="flex justify-between my-2">
                <h2 class="text-lg text-ellipsis">{{$occasion->brand . " " . $occasion->model }}</h2>
                <h2 class="font-bold text-green-500 text-xl">€ {{$occasion->price}}</h2>
            </div>
            <div>
                <ul class="flex justify-between text-gray-500">
                    <li>{{$occasion->odometer . "km"}}</li>
                    <li>{{$occasion->fuel_type}}</li>
                    <li>{{$occasion->year}}</li>
                    <li>{{$occasion->transmission}}</li>
                </ul>
            </div>
        </div>
    </div>
