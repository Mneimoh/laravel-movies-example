<div class="relative mt-3 md:0" x-data="{ isOpen:true }" @click.away="isOpen = false">
    <input 
    wire:model.debound.500ms="search" 
    type="text" 
    class="bg-gray-800 text-sm rounded-full w-64 pl-8 px-6 py-1 focus:outline-none focus:outline-shadow" 
    name="search" 
    placeholder="Search (Press '/' to focus)"
    x-ref = "search"
    @keydown.window = "
        if (event.keyCode == 191){
            event.preventDefault();
            $refs.search.focus();
        }

    "
    @focus = "isOpen = true"
    @keydown = "isOpen = true"
    @keydown.escape.window= "isOpen = false"
    @keydown.shift.tab= "isOpen = false"
    >
    <div class="absolute top-0"> 
        <svg class="fill-curent w-4 mt-2 ml-2 text-gray-500" viewBox="0 0 24 24"><path class="heroicon-ui" d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.14-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z" fill="#929292" fill-rule="evenodd"/></svg>
    </div> 

    <div wire:loading class="spinner top-0 right-0 mr-4 mt-3"></div>

    @if( strlen($search) >= 2)
        <div 
            class="z-50 absolute bg-gray-800 text-sm rounded w-64 mt-4" 
            x-show.transition.opacity="isOpen"
            @keydown.escape.window="isOpen = false"
        >
            @if($searchResults->count() > 0)
                <ul>
                    @foreach( $searchResults as $result)
                        <li class="border-b border-gray-700">
                            <a 
                                href="{{ route('movies.show',  $result['id']) }}" class="block hover:bg-gray-700 px-3 py-3 flex items-center transition ease-in-out duration-150"
                                @if($loop->last) @keydown.tab.exact = "isOpen = false" @endif
                            >
                                @if( $result['poster_path'])
                                    <img class="w-8" src="https://image.tmdb.org/t/p/w92/{{ $result['poster_path'] }}" alt="poster">
                                @else
                                    <img class="w-8" src="https://via.placeholder.com/50x70" alt="poster">
                                @endif
                                <span class="ml-4">{{ $result['title'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="px-3 py-3">
                    No results for "{{ $search }}"
                </div>
            @endif
        </div>
    @endif
</div>