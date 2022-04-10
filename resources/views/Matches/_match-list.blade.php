<h3 class="font-bold text-xl mb-4"> Matches</h3>
<ul>
        <ol>
            @forelse($matches as $user)
                <ul>
                    <div class="flex items-center text-sm mb-4">
                        <a href="/profiles/{{$user->id}}">
{{--                            <img src="{{$randomUser->getRandomUserPictures($user->id)}}" class="rounded mr-2">--}}
                            <img src="{{ $user->avatar }}"
                                 alt="" class="rounded mr-2">
                        </a>
                        <a href="/profiles/{{$user->id}}"> {{ $user->name }}</a>
                    </div>
                </ul>
            @empty
                No matches yet!
            @endforelse
        </ol>

</ul>
