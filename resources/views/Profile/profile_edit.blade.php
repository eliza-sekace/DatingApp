<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit profile') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form method="post" action="{{route('users.profiles.store', ['user' => auth()->user()])}}">
                @csrf

                About <input type="text" id="description" name="description" value="{{ optional($user->profile)->description }}">
                Birthday <input type="date" id="birthday" name="birthday" value="{{ optional($user->profile)->birthday }}">
                Gender <select class="form-control" id="gender" name="gender" value="{{ optional($user->profile)->gender }}">
                    <option value="Ms">Ms</option>
                    <option value="Mr">Mr</option>
                    <option value="Mx">Mx</option>
                </select>
                Interested in <select class="form-control" id="interested_in" name="interested_in">
                    <option value="Ms">Ms</option>
                    <option value="Mr">Mr</option>
                    <option value="Mx">Mx</option>
                    <option value="Everyone">Everyone</option>
                </select>
                Location (municipality)<select class="form-control" id="location" name="location">
                    <option value="Aizkraukle">Aizkraukle</option>
                    <option value="Aluksne">Aluksne</option>
                    <option value="Adazi">Adazi</option>
                    <option value="Balvi">Balvi</option>
                    <option value="Bauska">Bauska</option>
                    <option value="Cesis">Cesis</option>
                    <option value="Dobele">Dobele</option>
                    <option value="Dobele">Dobele</option>
                    <option value="Jelgava">Jelgava</option>
                    <option value="Jekabpils">Jekabpils</option>
                    <option value="Kraslava">Kraslava</option>
                    <option value="Kuldiga">Kuldiga</option>
                    <option value="Kekava">Kekava</option>
                    <option value="Liepaja">Liepaja</option>
                    <option value="Limbazi">Limbazi</option>
                    <option value="Ludza">Ludza</option>
                    <option value="Madona">Madona</option>
                    <option value="Ogre">Ogre</option>
                    <option value="Preili">Preili</option>
                    <option value="Rezekne">Rezekne</option>
                    <option value="Riga">Riga</option>
                    <option value="Salaspils">Salaspils</option>
                    <option value="Saldus">Saldus</option>
                    <option value="Tukums">Tukums</option>
                    <option value="Talsi">Talsi</option>
                    <option value="Valka">Valka</option>
                    <option value="Valmiera">Valmiera</option>
                    <option value="Ventspils">Ventspils</option>
                </select>
                <button>Submit</button>
            </form>
            {{--            Name <input type="text" id="name" name="name" value="{{auth()->user()->name}}"><br>--}}

        </div>
    </div>
</x-app-layout>

