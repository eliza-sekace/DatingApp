<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
{{--            <div class="flex p-6">--}}
{{--                <div>--}}
{{--                    @include('layouts._sidebar-links')</div>--}}
                <div class="flex-1 pl-3">
                    <div class="text-center items-center">
                        <h3 class="text-xl font-bold p-6">Match profiles</h3>
                        <div class="flex justify-center items-center space-x-8 p-2">
                           <img src="{{$randomUser->getRandomUserPictures($randomUser->id)}}" style="border-radius: 10%">
{{--                         {{$randomUser->getRandomUserPictures($randomUser->id)}}--}}
                        </div>

                        <div>
                            <a href="profiles/{{$randomUser->id}}"> {{$randomUser->name}} </a>
                            <p> Age: {{$randomUser->age}}</p>
                            {{--                            {{$user->getRandom()}}--}}
                        </div>
                    </div>
                    <div class="flex  justify-center items-center space-x-8 py-6">
                        <form method="post" action="{{ route('dislike', ['user'=>$randomUser]) }}">
                            @csrf
                            <div>
                                <button type='submit' class="text-xl" id="dislike" name="reaction" value="dislike"> Nope
                                    👎
                                </button>
                            </div>
                        </form>
                        <form method="post" action="{{ route('like', ['user'=>$randomUser]) }}">
                            @csrf
                            <div>
                                <button type="submit" class="text-xl" id="like" name="reaction" value="like"> Like 👍
                                </button>
                            </div>
                        </form>
                    </div>


                </div>
{{--                <div class="sm:rounded-lg lg:px-8"--}}
{{--                     style="background-color: lightsalmon">@include('Matches._match-list')</div>--}}

{{--            </div>--}}
        </div>
    </div>

</x-app-layout>
