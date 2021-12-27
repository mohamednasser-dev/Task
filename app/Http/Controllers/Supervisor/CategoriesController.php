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
        Alert::success('added', 'supervisor added successfully');
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
        Category::findOrFail($id)->delete();
        Alert::success('deleted', 'supervisor deleted successfully');
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
