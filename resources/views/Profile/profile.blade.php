<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
            @csrf
            <h2 class="text-center font-bold text-xl py-4">{{optional($user->profile)->gender}}. {{$user->name}} </h2>
            <h2 class="text-center font-bold text-xl py-4"> age : {{$user->age}}</h2>
            <br>
            <div class="flex justify-center items-center">
                <img src="/storage/{{ $photos->last()->photo }}.jpg">
            </div>
            <div class="flex justify-center items-center space-x-8 py-8">
                {{ $photos->links() }}
            </div>
            <div class="p-6 text-center text-xl">
                {{optional($user->profile)->description }}
            </div>

            <div class="px-6 text-l">
                Interested in: {{optional($user->profile)->interested_in}}
            </div>
            <div class="px-6 text-l">
                Location: {{optional($user->profile)->location}}
            </div>

            @if ($user->id == auth()->user()->id)
                <div class="sm:text-right px-6">
                    <a class="font-bold block"
                       href="{{$user->id}}/edit"> Edit profile</a>
                </div>

                <div class="sm:text-right px-6 py-6">
                    <a class="font-bold block"
                       href="{{$user->id}}/user/edit"> Edit User data</a>
                </div>

            @endif
        </div>
    </div>
</x-app-layout>
