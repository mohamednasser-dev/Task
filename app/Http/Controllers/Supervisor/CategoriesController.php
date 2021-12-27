<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::orderBy('created_at','desc')->paginate(10);
        return view('supervisor.categories.index',compact('data'));
    }
    public function trash()
    {
        $data = Category::orderBy('created_at','desc')->onlyTrashed()->paginate(10);
        return view('supervisor.categories.trash',compact('data'));
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
                'icon' => 'required|string|max:255',
            ]);
        //generate slug attribute ...
        $data['slug'] =  Str::slug($request->name);
        Category::create($data);
        Alert::success('added', 'category added successfully');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Category::where('slug',$id)->first();
        return view('supervisor.categories.edit',compact('data'));
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
        //this for if user enter edit page and not select icon ..to set default icon that inserted ...
        $selected_cat = Category::findOrFail($id);
        if($request->icon == null){

            $request['icon'] =  $selected_cat->icon;
        }
        $data = $this->validate(\request(),
            [
                'name' => 'required|string|max:255',
                'icon' => 'required|string|max:255',
            ]);
        //generate slug attribute ...
        $data['slug'] =  Str::slug($request->name);
        Category::findOrFail($id)->update($data);
        Alert::success('updated', 'category updated successfully');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        Alert::success('deleted', 'category deleted successfully');
        return back();
    }
    // multiple delete selected supervisores

    public function multiple_delete(Request $request){

        $ids = $request->ids;
        Category::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['message' => 'Success']);
    }


//    to restore deleted record
    public function restore($id)
    {
        Category::withTrashed()->findOrFail($id)->restore();
        Alert::success('restored', 'category restored successfully');
        return back();
    }
    //to final terminate record ...
    public function terminate($id)
    {
        Category::onlyTrashed()->findOrFail($id)->forceDelete();
        Alert::success('terminated', 'Category force deleted successfully');
        return back();
    }
}
