<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User info') }}
        </h2>
    </x-slot>
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors"/>


    <div class="py-12 mx-auto lg:px-8 ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-center">

            <form method="POST" action="{{ route('user.edit', auth()->user()->id) }}">
                @csrf

                <div class="mt-4 ">
                    <x-label for="name" :value="'Name'"/>

{{--                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required--}}
{{--                             autofocus/>--}}

                    <x-input class="block mt-1 w-full" type="text" id="name" name="name" value="{{ $user->name }}"></x-input>

                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-label for="email" :value="__('Email')"/>
{{--                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"--}}
{{--                             required/>--}}
                    <x-input class="block mt-1 w-full" type="text" id="email" name="email" value="{{ $user->email }}"></x-input>

                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-label for="password" :value="__('Password')"/>
                    <x-input id="password" class="block mt-1 w-full"
                             type="password"
                             name="password"
                             required autocomplete="new-password"/>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-label for="password_confirmation" :value="__('Confirm Password')"/>
                    <x-input id="password_confirmation" class="block mt-1 w-full"
                             type="password"
                             name="password_confirmation" required/>
                </div>
                <br>
                <x-button class="ml-4"> Save data</x-button>

            </form>
        </div>
    </div>
</x-app-layout>
