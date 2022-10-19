<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<x-app-layout>

<div class="container">
<h3>Produkty</h3>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Description</th>

    </tr>
  </thead>
  <tbody>

    @foreach($products as $item)
    <tr>
      <th scope="row">{{$item->id}}</th>
      <td>{{$item->name}}</td>
      <td>{{$item->price}}</td>
      <td>{{$item->quantity}}</td>
      <td>{{$item->description}}</td>
      @foreach($item->categories as $category)
      <td>{{$category->name}}</td>
      @endforeach
     </tr>
    @endforeach

  </tbody>
</table>
</div>

</x-app-layout>


