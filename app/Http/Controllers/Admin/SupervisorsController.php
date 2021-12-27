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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    public function multiple_delete(Request $request){

        $ids = $request->ids;
        Supervisor::whereIn('id',explode(",",$ids))->delete();
        Alert::success('deleted', 'supervisors deleted successfully');
        return back();
//        return response()->json(['status'=>true,'message'=>"Category deleted successfully."]);
    }
}
