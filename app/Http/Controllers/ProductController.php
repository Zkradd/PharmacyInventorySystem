<?php

namespace App\Http\Controllers;
use App\Http\Resources\CategoryResource;


use App\Models\ProductBatch;
use App\Models\Shelf;
use Illuminate\Bus\Batch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{
    public function magazyn()
    {
        $products= Product::withSum('batches', 'quantity')->get()->paginate(5);
        return view('magazyn',compact('products'));
    }

    public function widokMagazynu()
    {

        return view('widokMagazynu');
    }

    public function wydajZMagazynu()
    {

        return view('wydajZMagazynu');
    }



    public function addCategory(Request $request){

    }
    public function addProduct(Request $request){
//        dd($request);
        $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required'],
            'description' => ['required', 'string'],
        ]);

        $item = new Product();
        $item->name = $request->name;
        $item->price = $request->price;
        $item->description = $request->description;
        $item->save();
        if($request->input('images')){
            foreach($request->input('images') as $image){
                $photo = new Photo();
                $photo->uri = 'magazynphotos/' . $image;
                $item->photos()->save($photo);
            }
        }
        if($request->input('categories')){
            foreach($request->input('categories') as $category_name){
                $category = Category::firstOrCreate(
                    ['name' => $category_name]
                );
                $item->categories()->attach($category);
            }
        }
        $item->save();
        return redirect()->back()->with('success', 'Artykuł dodany pomyślnie!');
    }
    public function addPhoto(Request $request)
    {
        if($request->hasFile('image')){
            $image = $request->file('image');

            $filename = time() . "." .  $image->getClientOriginalExtension();

            Image::make($image)->save(public_path('magazynphotos/' . $filename));

            return response()->json([
                'filename' => $filename,
            ]);
        }
        return response('No input named "image"', 500);
    }

    public function deletePhoto(Request $request)
    {
        $this->deleteSinglePhoto($request->image);
        return response('Ok');
    }

    public function deleteMultiplePhotos(Request $req){
        $files = $req->input('image');
        foreach($files as $file){
            $this->deleteSinglePhoto($file);
        }
        return response('Ok');
    }

    private function deleteSinglePhoto(string $filename){
        if(Photo::where('uri', '=' ,$filename)->exists()){
            foreach(Photo::where('uri', '=', $filename) as $photo){
                $photo->delete();
            }
        }
        File::delete(public_path('magazynphotos/' . $filename));
    }

    public function searchCategories(Request $request){
        $validator = Validator::make($request->all(), [
            'str' => "required|string",
        ]);
        if($validator->fails()){
            return response()->json(null);
        }

        return response()->json(CategoryResource::collection(Category::whereLike('name', strval($request->str))->get()));

    }
    public function productDetail($id){
        $data=Product::find($id);

        return view('magazyndetails',['product'=>$data]);

    }



    public function productEdit($id){
        $data=Product::where('id', '=', $id)->first();
        return view('edit',compact('data'));
    }

    public function destroy($id){
     Product::destroy($id);

     return redirect(route('magazyn'))->with('message', 'Artykuł został usunięty');
    }

public function searchProducts(Request $request){

    if($request->search){
        $searchPhrase = $request->search;

    } else if($request->session()->has('search')){
        $searchPhrase = $request->session()->get('search');

    } else{
        return redirect()->back()->with('message','Puste wyszukiwanie');
    }

    $searchProducts=Product::where('name', 'LIKE', '%'.$searchPhrase.'%')->get();
    $searchCategories=Product::whereHas('categories', function(Builder $query) use ($searchPhrase){
        $query->where('name', 'LIKE', '%'.$searchPhrase.'%');
    })->get();
    $searchFinal=$searchProducts->merge($searchCategories);
    $searchFinal=$searchFinal->unique()->paginate(10);

    $request->session()->put('search', $searchPhrase);

    return view('productSearch', compact('searchFinal'));
    }

    public function addBatch(Request $request){
        $request->validate([
            'product_id' => ['required', 'string'],
            'shelf_id' => ['required'],
            'quantity' => ['required'],
            'expiration_date' => ['required'],
        ]);

        try{
            $product = Product::findOrFail($request->product_id);
            $shelf = Shelf::findOrFail($request->shelf_id);
            $batch = new Batch();
            $batch->quantity = $request->quantity;
            $batch->expiration_date = $request->expiration_data;
            $shelf->batches()->associate($batch);
            $product->batches()->save($batch);
            return redirect()->back()->with('success', 'Batch added successfully');
        } catch (ModelNotFoundException $e){
            return redirect()->back()->with('error', $e->getMessage());
        }



    }

    public function editBatch(Request $request){
        $request->validate([
            'batch_id' => ['required'],
            'shelf_id' => ['required'],
            'quantity' => ['required'],
            'expiration_date' => ['required'],
        ]);

        try{
            $shelf = Shelf::findOrFail($request->shelf_id);
            $batch = ProductBatch::findOrFail($request->batch_id);
            $batch->shelf()->disassociate();
            $batch->quantity = $request->quantity;
            $batch->expiration_date = $request->expiration_data;
            $shelf->batches()->associate($batch);
            $batch->save();
            return redirect()->back()->with('success', 'Batch edited successfully');
        } catch (ModelNotFoundException $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteBatch(Request $request){
        $request->validate([
            'batch_id' => ['required'],
        ]);

        try{
            $batch = ProductBatch::findOrFail($request->batch_id);
            $batch->delete();
            return redirect()->back()->with('success', 'Batch deleted successfully');
        } catch (ModelNotFoundException $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function releaseFromMagazyn(Request $request){
        $request->validate([
            'product_id' => ['required'],
            'quantity' => ['required']
        ]);

        try{
            $quantityRemaining = $request->quantity;
            $product = Product::findOrFail($request->product_id);
            $batches = $product->batches()->orderBy('expiration_date', 'desc')->get();
            if($batches->sum('quantity') < $quantityRemaining){
                return redirect()->back()->with('error', 'Not enough in stock');
            }
            foreach($batches as $batch){
                if($batch->quantity <= $quantityRemaining){
                    $quantityRemaining -= $batch->quantity;
                    $batch->delete();
                } else{
                    $batch->quantity -= $quantityRemaining;
                    $batch->save();
                    break;
                }
            }
            return redirect()->back()->with('success', 'Batch deleted successfully');
        } catch (ModelNotFoundException $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function productUpdate(Request $request){
        $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required'],
            'description' => ['required', 'string'],
        ]);
        $id = $request->id;
        $name = $request->name;
        $price = $request->price;
        $description = $request->description;


        $product=Product::where('id', $id )->first();
        $product->categories()->detach();

        $currentPhotosFromForm=$request->oldPhotos;
        $PhotosToDelete=$product->photos;
        if(!is_null($currentPhotosFromForm))
        {
            $PhotosToDelete=$PhotosToDelete->reject(function($photo, $key) use ($currentPhotosFromForm) {

                if(in_array($photo->id, $currentPhotosFromForm)){
                    return true;
                };
                return false;
            });
        }


            foreach($PhotosToDelete as $photo){
                $this->deleteSinglePhoto($photo->uri);
                Photo::destroy($photo->id);

            }

        if($request->input('images')){
            foreach($request->input('images') as $image){
                $photo = new Photo();
                $photo->uri = 'magazynphotos/' . $image;
                $product->photos()->save($photo);
            }
        }
        if($request->input('categories')){
            foreach($request->input('categories') as $category_name){
                $category = Category::firstOrCreate(
                    ['name' => $category_name]
                );
                $product->categories()->attach($category);
            }
        }

        Product::where('id','=',$id)->update([
            'name'=>$name,
            'price'=>$price,
            'description'=>$description

        ]);
        return redirect()->back()->with('success', 'Artykuł zaktualizowany');
    }




}









