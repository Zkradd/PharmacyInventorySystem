<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight ">
            {{ __('Szczegóły produktu ') }}
        </h2>

    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-2">
            <a href="/magazyn" class="text-blue-700 ">
                <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="submit">
                    WRÓĆ
                </button></a>
            </div>
        </div>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('message'))
                <div class="mx-auto w-4/5 pb-10">
                    <div class="bg-red-500 tet-white font-bold rounded-t px-4 py-2">
                        Warning
                    </div>
                    <div class="border border-t-1 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                        {{session()->get('message')}}
                    </div>
                </div>


            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-800">

                <div class="p-6 border-b border-gray-200 dark:border-gray-800 text-gray-500 dark:text-gray-400 flex flex-wrap justify-around">

                    <div class="max-w-sm my-4 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 min-w-[40%] ">
                    @if(sizeof($product->photos)===1)
                        @foreach($product->photos as $photo)
                            <img class="max-w-md w-md" src="{{__(env('APP_URL') . '/' .$photo->uri)}}">
                        @endforeach
                        <script>
                            console.log({{$product}})
                        </script>
                    @elseif(sizeof($product->photos) > 1)
                        <div id="{{$product->id}}-carousel" class="relative max-w-sm mx-auto" data-carousel="static">
                            <!-- Carousel wrapper -->
                            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                @foreach($product->photos as $photo)
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        <span class="absolute text-2xl font-semibold text-white -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 sm:text-3xl dark:text-gray-800">First Slide</span>
                                        <img src="{{__(env('APP_URL') . '/' .$photo->uri)}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Slider indicators -->
                            <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                                @for($x = 0; $x < sizeof($product->photos); $x++)
                                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false"
                                            aria-label="Slide {{__($x + 1)}}"
                                            data-carousel-slide-to="{{__($x)}}"></button>
                                @endfor
                            </div>
                            <!-- Slider controls -->
                            <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-black/30 dark:bg-gray-800/30 group-hover:bg-black/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-black/30 dark:bg-gray-800/30 group-hover:bg-black/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>
                    @endif
                    </div>
                    <div class="p-5">
                        <a href="#">
                            <h5 class=" namedeletebtn mb-2 text-2xl font-bold tracking-tight text-gray-900 deletevaluename ">{{$product->name}}</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Cena: {{$product->price}}</p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Ilość sztuk: {{$product->quantity}}</p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Opis: {{$product->description}}</p>
                        <div class="mb-3">
                            @foreach($product->categories as $category)
                                <span
                                    class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">Kategoria: {{$category->name}}</span>
                            @endforeach
                        </div>


                    </div>
                    <div class="p-5">
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Actions:</p>

                        <a href="{{url('/magazyn/edit/'.$product->id) }}" class="text-blue-700">
                            <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="submit">
                                EDYTUJ
                            </button></a>

                        <form action="{{route('product.destroy', $product->id)}}" method="POST" class="pt-1">
                        @csrf
                            @method('DELETE')
                            <button   class=" deletebtn text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="submit">
                                USUŃ
                            </button>


{{--                            onclick="return confirm('Are you sure?')"--}}
                        </form>


                    </div>


                </div>
            </div>
        </div>
    </div>

</x-app-layout>




<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script type="text/javascript">

    $('.deletebtn').click(function(event){
        var form =  $(this).closest("form");
        var name = $('.namedeletebtn').text();
        event.preventDefault();
        swal({
            title: `Jesteś pewny, że chcesz usunąć ${name}?`,
            text: "Jeśli go usuniesz, pozbędziesz się go na zawsze.",
            icon: "warning",
            type: "warning",
            buttons: ["Anuluj","Usuń!"],
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tak, usuń!'
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
</script>

