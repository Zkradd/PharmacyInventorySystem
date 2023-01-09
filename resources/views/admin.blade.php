
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-400">
            {{ __('Admin Panel') }}
        </h2>
    </x-slot>

    <div class="py-12">



        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('success'))
                <div class="mx-auto w-4/5 pb-10">
                    <div class="bg-green-500 tet-white font-bold rounded-t px-4 py-2">
                        Success!
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
                                    id="add-item-button" data-tabs-target="#add-item" type="button" role="tab"
                                    aria-controls="profile" aria-selected="true">Dodaj Produkt</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button
                                    class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 dark:border-blue-500"
                                    id="admins-button" data-tabs-target="#admins" type="button" role="tab"
                                    aria-controls="profile" aria-selected="false">Manage admins</button>
                            </li>

                        </ul>
                    </div>










                    <div id="tab">
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="add-item" role="tabpanel"
                             aria-labelledby="add-item-button">
                            <form id="addItemForm" class="max-w-lg" method="POST" action="{{route('magazyn_add_item')}}">
                                @csrf
                                <div class="relative mb-6">
                                    <input type="text" value="{{old('name')}}" name="name" id="item-name" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                    <label for="item-name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Name</label>
                                    @error('name')
                                    <div class ="alert alert-danger text-rose-700" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="relative  mb-6">
                                    <input type="text" value="{{old('price')}}" pattern="^\d*.?\d{0,2}$" name="price"   id="item-price" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                    <label for="item-price" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Price</label>
                                    @error('price')
                                    <div class ="alert alert-danger text-rose-700" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="relative  mb-6">
                                    <input type="text" value="{{old('quantity')}}" pattern="\d*" name="quantity" id="item-quantity" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                    <label for="quantity" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Quantity</label>
                                    @error('quantity')
                                    <div class ="alert alert-danger text-rose-700" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>


                                <div class="relative mb-6">
                                    <textarea id="item-description" name="description" cols="4" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "
                                              style="overflow: hidden"
                                              x-data="{ resize: () => { $el.style.height = '5px';
                                                let minHeight = 90;
                                                $el.style.height = ($el.scrollHeight < minHeight ? minHeight : $el.scrollHeight) + 'px' } }"
                                              x-init="resize()"
                                              @input="resize()">{{old('description')}}</textarea>
                                    <label for="item-description"  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Description</label>
                                    @error('description')
                                    <div class ="alert alert-danger text-rose-700" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div id="category-div" class="mt-2"></div>
                                <div class="mt-2">
                                    <div class="relative block w-56">
                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                            <span class="sr-only">Search icon</span>
                                        </div>
                                        <input type="text" data-dropdown-toggle="dropdown" id="search-category" class="block p-2.5 pl-10 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" autocomplete="off" placeholder="Add category..." value="{{old('category')}}">
{{--                                        <button type="submit" id="search-category-button" name="category" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add</button>--}}
                                    </div>
                                    <div id="dropdown" class="z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 max-w-xs">
                                        <ul id="search-category-results" class="py-1 text-sm text-gray-700 dark:text-gray-200"></ul>
                                    </div>


                                </div>
                            </br>

                                <div class="flex flex-wrap justify-between items-center max-w-2xl mt-2" id="photosDiv">
                                    <div id="placeHolder" class="w-5/6 h-36 sm:w-2/5 sm:h-40 mt-1 mb-3 cursor-pointer flex flex-col justify-center items-center rounded border-dashed border-2 border-indigo-600 text-gray-600 dark:text-blue-500">
                                        <h2>+</h2>
                                        <h3>Add photo</h3>
                                    </div>
                                </div>
                                <button id="addItemSubmit" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>

                            </form>
                            <form id="addPhotoForm">
                                @csrf
                                <input type="file" name="image" style="display: none;" id="photoAddInput">
                            </form>
                        </div>
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="admins" role="tabpanel"
                             aria-labelledby="admins-button">
                            <div class="relative block w-80">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none max-w-xs">
                                    <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                    <span class="sr-only">Search icon</span>
                                </div>
                                <input type="text" data-dropdown-toggle="admin-search-results" id="admin-search" class="block p-2.5 pl-10 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" autocomplete="off" placeholder="Search user...">
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
    </div>
    <script type="text/javascript">
        let user_id = {{Auth::id()}};
        let add_admin_url = "{{route('add_admin', 0)}}".slice(0, -1)
        let remove_admin_url = "{{route('remove_admin', 0)}}".slice(0, -1)


        let disableOnUnload = false

        $('#addItemSubmit').on('click', function () {
            disableOnUnload = true
        })

        function removeExtension(str){
            return str.replace(/\.[^/.]+$/, "")
        }


        function input(filename){
            return `<input type='hidden' id='input${removeExtension(filename)}' name='images[]' class='photoImg' value='${filename}'/>`
        }
        $(window).on('beforeunload', function(){
            if(!disableOnUnload){
                let images = [];
                let formData = new FormData();
                formData.append('_token', '{{csrf_token()}}')
                $('.photoImg').each(function(){
                    images.push($(this).val())
                    formData.append('image[]', $(this).val())
                })

                console.log(formData.getAll('image[]'))
                $.ajax({
                    url: '{{route('magazyn_delete_photos')}}',
                    data: formData,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    success: function (data){
                        console.log(data);
                    }
                })
            }
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $('#placeHolder').height($('#placeHolder').width() * (3/4))


        let categories = []
        function addCategory(str) {
            let text = str
            if (!categories.includes(text)) {
                categories.push(text)
                $(`#category-div`).append(`
                    <span id="${text}-badge" class="inline-flex items-center py-1 px-2 mr-2 text-sm font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-200 dark:text-blue-800">
                        ${text}
                        <button type="button" value="${text}" onclick="deleteCategory(this)" class="dismiss-button inline-flex items-center p-0.5 ml-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-300 dark:hover:text-blue-900" aria-label="Remove">
                          <svg class="w-3.5 h-3.5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                          <span class="sr-only">Remove badge</span>
                        </button>
                    </span>
                `)
                $(`#addItemForm`).append(`
                    <input id="category${text}" type="hidden" name="categories[]" value="${text}">
                `)
            }
        }

        function deleteCategory(e){
            $(e).parent().remove()
            $(e).parent().remove()
            let index = categories.indexOf($(e).val())
            $(`#category${$(e).val()}`).remove()
            categories.splice(index, 1)
        }

        function capitalize(string){
            return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase()
        }

        $('#search-category').on('keyup', function(){
            let formData = new FormData()
            let str = capitalize($(`#search-category`).val())
            formData.append('_token', '{{csrf_token()}}')
            formData.append('str', $(`#search-category`).val())
            $.ajax({
                url: '{{route('search_categories')}}',
                data: formData,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    $(`#search-category-results`).empty()
                    let addNewCategory = true
                    if(data !== null){
                        for(let category of data){
                            if(category.name === str)
                                addNewCategory = false
                            $(`#search-category-results`).append(`
                                <li>
                                    <p onclick="addCategory('${category.name}')" class="category cursor-pointer block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">${category.name}</p>
                                </li>
                            `)
                        }
                    }
                    if(addNewCategory){
                        $(`#search-category-results`).append(`
                                <li>
                                    <p onclick="addCategory('${str}')" id="addCategory" class="cursor-pointer block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Add '${str}' category</p>
                                </li>
                            `)
                    }
                }
            })
        })
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





        function deleteImg(filename){
            let formData = new FormData()
            formData.append('image', filename)
            formData.append('_token', '{{csrf_token()}}')
            $.ajax({
                url: '{{route('magazyn_delete_photo')}}',
                data: formData,
                type: 'POST',
                processData: false,
                contentType: false,
                success: function (data){
                    console.log('Deleted')
                    $(`#${removeExtension(filename)}`).remove()
                    $(`#input${removeExtension(filename)}`).remove()
                }
            })
        }

        $('#placeHolder').on('click', function(){
            $(`#photoAddInput`).trigger('click')
        })

        $(`#photoAddInput`).on('change', function(){
            let form = $(`#addPhotoForm`)[0]
            let formData = new FormData(form)
            $.ajax({
                url: '{{route('magazyn_add_photo')}}',
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function(data){
                    $(`#photosDiv`).append(`
                        <div x-data="{imgOpen: false}" class='relative w-5/6 sm:w-2/5 mt-1' id="${removeExtension(data.filename)}" @mouseover='imgOpen = true' @mouseover.away = 'imgOpen = false'>
                            <div x-show='imgOpen' onclick="deleteImg('${data.filename}')" le="width: 20px; height: 20px;  margin: 4px; cursor: pointer" class="cursor-pointer rounded absolute right-0 top-0 text-red-600 justify-center items-center">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <img src="/magazynphotos/${data.filename}">
                        </div>
                    `)
                    $(`#addItemForm`).append(input(data.filename))
                },
                error: function(data){
                    console.log(data)
                }
            })
        })








    </script>
</x-app-layout>
