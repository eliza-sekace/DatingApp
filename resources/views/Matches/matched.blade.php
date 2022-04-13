<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Your matches'}}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">

            <div class="py-8 px-6 ">
                <ol>
                    @foreach($matches as $user)
                        <ul>
                            <div class="flex items-center text-sm mb-4">
                                <a href="/profiles/{{$user->id}}" class="p-2">
                                    <img src="{{$user->photo }}" width="40" height="40" style="border-radius: 50%"></a>
                                {{ $user->name }}
                            </div>
                        </ul>
                    @endforeach
                </ol>

            </div>
        </div>
    </div>

</x-app-layout>
