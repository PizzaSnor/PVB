<div class="flex flex-col gap-y-4 mb-4">
    @if($occasion->images->isNotEmpty())
        @if(!isset($occasion->images[$imageId]))
            <img class="w-full h-96 object-cover rounded-lg shadow-md" src="{{ asset('images/' . $occasion->images[0]->path) }}" alt="Occasion image">
        @else
            <img class="w-full h-96 object-cover rounded-lg shadow-md" src="{{ asset('images/' . $occasion->images[$imageId]->path) }}" alt="Occasion image">
        @endif
        <div class="flex gap-x-4 gap-y-4 flex-wrap md:flex-nowrap overflow-x-auto">
            @foreach($occasion->images as $key => $image)
                <a href="{{route('occasions.view', ['id' => $occasion->id, 'imageId' => $key])}}">
                    <img class="w-24 h-24 rounded-lg object-cover shadow-md hover:brightness-75" src="{{asset('images/' . $image->path)}}" alt="Occasion image">
                </a>
            @endforeach
        </div>
    @else
        <img class="w-full h-96 object-cover rounded-lg shadow-md" src="{{ asset('images/carPlaceholder.png') }}" alt="Occasion image">
    @endif
</div>
