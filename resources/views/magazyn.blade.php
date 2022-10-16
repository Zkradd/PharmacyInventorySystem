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

    @foreach($magazyn_items as $magazyn_items)
    <tr>
      <th scope="row">{{$magazyn_items->id}}</th>
      <td>{{$magazyn_items->name}}</td>
      <td>{{$magazyn_items->price}}</td>
      <td>{{$magazyn_items->quantity}}</td>
      <td>{{$magazyn_items->description}}</td>
     </tr>
    @endforeach
    
  </tbody>
</table>
</div>

</x-app-layout>


