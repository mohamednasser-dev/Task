<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SupervisorDataTable;
use App\DataTables\SupervisorDataTableEditor;
use App\Http\Controllers\Controller;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SupervisorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Supervisor::orderBy('created_at','desc')->paginate(10);
        return view('admin.supervisor.index',compact('data'));
    }

    public function trash()
    {
        $data = Supervisor::orderBy('created_at','desc')->onlyTrashed()->paginate(10);
        return view('admin.supervisor.trash',compact('data'));
    }

    public function change_status(Request $request)
    {
        Supervisor::findorFail($request->id)->update(['status'=>$request->status]);
        return 1;
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
                'email' => 'required|unique:supervisors,email|email:rfc,dns',
                'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
                'phone' => 'required|unique:supervisors,phone',
                'image' => 'required|mimes:jpeg,jpg,png|max:10000' // max 10000kb
            ]);

        Supervisor::create($data);
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
        Supervisor::findOrFail($id)->delete();
        Alert::success('deleted', 'supervisor deleted successfully');
        return back();
    }

    // multiple delete selected supervisores
    public function multiple_delete(Request $request){
        try {
            Supervisor::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed']);
        }
        return response()->json(['message' => 'Success']);
    }

    //    to restore deleted record
    public function restore($id)
    {
        Supervisor::withTrashed()->findOrFail($id)->restore();
        Alert::success('restored', 'Supervisor restored successfully');
        return back();
    }
    //to final terminate record ...
    public function terminate($id)
    {
        Supervisor::onlyTrashed()->findOrFail($id)->forceDelete();

        Alert::success('terminated', 'Supervisor force deleted successfully');
        return back();
    }
}
