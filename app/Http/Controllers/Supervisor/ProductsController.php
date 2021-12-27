<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::orderBy('created_at','desc')->paginate(10);
        $categories = Category::orderBy('created_at','desc')->get();
        return view('supervisor.products.index',compact('data','categories'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate(\request(),
            [
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'description' => 'required|string',
                'image' => 'required|mimes:jpeg,jpg,png|max:10000', // max 10000kb
            ]);
        $data['slug'] =  Str::slug($request->name);
        $product = Product::create($data);
        if($request->images){
            $image_data['product_id'] = $product->id;
            foreach ($request->images as $row){
                $image_data['image']  = $row;
                Product_image::create($image_data);
            }
        }
        Alert::success('added', 'product added successfully');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $data =  Product::where('slug',$id)->first();
        return view('supervisor.products.details',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        Alert::success('deleted', 'supervisor deleted successfully');
        return back();
    }

    public function multiple_delete(Request $request){

        $ids = $request->ids;
        Product::whereIn('id',explode(",",$ids))->delete();
        Alert::success('deleted', 'supervisors deleted successfully');
        return back();
//        return response()->json(['status'=>true,'message'=>"Category deleted successfully."]);
    }
}
