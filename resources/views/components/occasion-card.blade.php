<div class="p-2 bg-white rounded-xl shadow-2xl hover:brightness-90 cursor-pointer">
    <div class="w-80 h-40 object-contain">
    @if($occasion->images === [])
        <img class="w-80 h-40 object-cover rounded-md" src="{{ URL::asset($occasion->images[0]['path'])}}" alt="">
    @else
        <img class="w-80 h-40 object-cover rounded-md" src="{{ URL::asset('images/carPlaceholder.png')}}" alt="">
    @endif
    </div>
    <div>
        <div class="flex justify-between my-2">
            <h2 class="text-lg text-ellipsis">{{$occasion->brand . " " . $occasion->model }}</h2>
            <h2 class="font-bold text-green-500 text-xl">{{$occasion->price}}</h2>
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
