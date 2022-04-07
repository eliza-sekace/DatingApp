<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex p-6">
                <div >
                    @include('layouts._sidebar-links')</div>
                <div class="flex-1 pl-3">
                    <div class="text-center items-center">
                        <h3 class="text-xl font-bold">Match profiles</h3>
                        <div class="flex justify-center items-center space-x-8 space-y-2">
                            <img src="{{$randomUser->profilePicture}}">
                        </div>
                        <div>
                            {{$randomUser->name}}
{{--                            {{$user->getRandom()}}--}}
                        </div>
                    </div>
                    <form action="" >
                        <div class="flex  justify-center items-center space-x-8 py-6">
                            <button class="text-xl" id="dislike" name="dislike" value="dislike"> Nope 👎</button>
                            <button class="text-xl" id="like" name="like" value="like"> Like 👍 </button>
                        </div>
                    </form>

                </div>
                <div class="sm:rounded-lg lg:px-8" style="background-color: lightsalmon">@include('Matches._match-list')</div>

            </div>
        </div>
    </div>

</x-app-layout>
