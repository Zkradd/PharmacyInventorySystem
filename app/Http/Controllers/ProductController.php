<?php

namespace App\Http\Controllers;
use App\Http\Resources\CategoryResource;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{
    public function magazyn()
    {
        $products= Product::all()->paginate(5);
        return view('magazyn',compact('products'));
    }


    public function addCategory(Request $request){

    }
    public function addItem(Request $request){
//        dd($request);
        $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required'],
            'quantity' => ['required'],
            'description' => ['required', 'string'],
        ]);

        $item = new Product();
        $item->name = $request->name;
        $item->price = $request->price;
        $item->quantity = $request->quantity;
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
        return redirect()->back()->with('success', 'Item successfully added');
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

     return redirect(route('magazyn'))->with('message', 'Product has been deleted');
    }

    public function searchProducts(Request $request){

    if($request->search){
        $searchProducts=Product::where('name', 'LIKE', '%'.$request->search.'%')->get();
        $searchCategories=Product::whereHas('categories', function(Builder $query)use($request){
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        })->get();
        $searchFinal=$searchProducts->merge($searchCategories);
        $searchFinal=$searchFinal->unique()->paginate(1);

        return response()

            ->cookie('search', $request->search, 5)
            ->view('productSearch', compact('searchFinal'));
    }
    else if($request->cookie('search'))
    {

    }
    else{
        return redirect()->back()->with('message','Empty Search');
    }



    }

    public function productUpdate(Request $request){
        $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required'],
            'quantity' => ['required'],
            'description' => ['required', 'string'],
        ]);
        $id = $request->id;
        $name = $request->name;
        $price = $request->price;
        $quantity = $request->quantity;
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
            'quantity'=>$quantity,
            'description'=>$description

        ]);
        return redirect()->back()->with('success', 'Item updated');
    }




}









