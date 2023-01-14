<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-400">
            {{ __('Profil Użytkownika') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                    Ustawienia użytkownika
                </div>

                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                        data-tabs-toggle="#accountTable" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 dark:border-blue-500"
                                id="name-tab" data-tabs-target="#name" type="button" role="tab"
                                aria-controls="profile" aria-selected="true">Zmień nazwę</button>
                        </li>

                    </ul>
                </div>
                <div id="accountTable">
                    <div class="p-4 rounded-lg dark:bg-gray-800" id="name" role="tabpanel"
                         aria-labelledby="name-tab">
                        <form method="post" action="{{route('change_name')}}">
                            @csrf
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="name-input">{{__('Nazwa')}}</label>
                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="name-input" name="name" type="text" placeholder="Username" value="{{Auth::user()->name}}">
                            </div>
                            <input type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" value="Change">
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
