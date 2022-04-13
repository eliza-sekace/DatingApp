<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{'Home'}}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex-1 pl-3">
                <div class="text-center items-center">
                    <h3 class="text-xl font-bold p-6">Match profiles</h3>
                    <div class="flex justify-center items-center space-x-8 p-2">
                        <img src="{{$randomUser->photo}}" style="border-radius: 10%">
                    </div>
                    <div>
                        <a href="profiles/{{$randomUser->id}}" class="text-xl"> {{$randomUser->name}} </a>
                        <p> Age: {{$randomUser->age}}</p>
                        <p class="p-2">Location: {{$randomUser->profile->location}} </p>
                        <p> {{$randomUser->profile->description}}</p>
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
        </div>
    </div>
</x-app-layout>
