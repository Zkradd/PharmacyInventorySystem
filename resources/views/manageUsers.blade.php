
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-400">
            {{ __('Przyjmij do Magazynu') }}
        </h2>
    </x-slot>

    <div class="py-12">



        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('success'))
                <div class="mx-auto w-4/5 pb-10">
                    <div class="bg-green-500 tet-white font-bold rounded-t px-4 py-2">
                        Sukces!
                    </div>
                    <div class="border border-t-1 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
                        {{session()->get('success')}}
                    </div>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-800">

                <div class="p-6 border-b border-gray-200 dark:border-gray-800 text-gray-500 dark:text-gray-400">

                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                            data-tabs-toggle="#tab" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button
                                    class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 dark:border-blue-500"
                                    id="admins-button" data-tabs-target="#admins" type="button" role="tab"
                                    aria-controls="profile" aria-selected="false">Zarządzaj użytkownikami</button>
                            </li>

                        </ul>
                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="admins" role="tabpanel"
                             aria-labelledby="admins-button">
                            <div class="relative block w-80">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none max-w-xs">
                                    <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                    <span class="sr-only">Search icon</span>
                                </div>
                                <input type="text" data-dropdown-toggle="admin-search-results" id="admin-search" class="block p-2.5 pl-10 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" autocomplete="off" placeholder="Wyszukaj użytkownika...">
                                {{--                                    <button type="submit" id="search-category-button" name="category" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add</button>--}}
                            </div>
                            <div id="admin-search-results" class="hidden bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 max-w-xs mt-2 w-80">
                                <ul id="admin-results" class="py-1 text-sm text-gray-700 dark:text-gray-200"></ul>
                            </div>
                        </div>





                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        let user_id = {{Auth::id()}};
        let add_admin_url = "{{route('add_admin', 0)}}".slice(0, -1)
        let remove_admin_url = "{{route('remove_admin', 0)}}".slice(0, -1)


        let disableOnUnload = false



        function removeExtension(str){
            return str.replace(/\.[^/.]+$/, "")
        }



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $('#placeHolder').height($('#placeHolder').width() * (3/4))






        $(`#admin-search`).on('keyup', function(){
            let formData = new FormData()
            formData.append('_token', '{{csrf_token()}}')
            formData.append('str', $(`#admin-search`).val())
            $.ajax({
                url: '{{route('search_users')}}',
                data: formData,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data){
                    $(`#admin-results`).empty()
                    if(data !== null){
                        for(let user of data){
                            if(user.id === user_id){
                                $(`#admin-results`).append(`
                                    <li>
                                        <div class="flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <p class="block py-2 px-4">${user.name}<span class="font-bold"> (You)</span></p>
                                        </div>
                                    </li>
                                `)

                            } else if(user.admin){
                                $(`#admin-results`).append(`
                                    <li>
                                        <div class="flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <p class="block py-2 px-4">${user.name}</p>
                                            <a href="${remove_admin_url + user.id}" class="bg-red-600 hover:bg-red-500 text-white font-bold py-2 px-4 m-2 rounded inline-flex items-center">
                                                <span>{{__('Remove Admin Role')}}</span>
                                            </a>
                                        </div>
                                    </li>
                                `)
                            }
                            else{
                                $(`#admin-results`).append(`
                                    <li>
                                        <div class="flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <p class="block py-2 px-4">${user.name}</p>
                                            <a href="${add_admin_url + user.id}}" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 m-2 rounded inline-flex items-center">
                                                <span>{{__('Add Admin Role')}}</span>
                                            </a>
                                        </div>

                                    </li>
                                `)
                            }

                        }
                    }
                    $('#admin-search-results').addClass('hidden')
                    if($(`#admin-results`).children().length > 0){
                        $(`#admin-search-results`).removeClass('hidden')
                    }

                }
            })
        })

        function capitalize(string){
            return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase()
        }













    </script>
</x-app-layout>
