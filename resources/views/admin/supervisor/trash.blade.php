@extends('app')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">supervisors Trash</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('supervisors.index')}}">supervisors</a></li>
                <li class="breadcrumb-item active">supervisors Trash</li>
            </ol>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="example23"
                           class="tablesaw table-striped table-hover table-bordered table tablesaw-columntoggle">
                        <thead>
                        <tr>
                            <th class="text-center">avatar</th>
                            <th class="text-center">user name</th>
                            <th class="text-center">phone</th>
                            <th class="text-center">email</th>
                            <th class="text-center">actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $row)
                            <tr id="tr_{{$row->id}}">
                                <td class="text-center"><img src="{{$row->image}}" style="width: 100px;"></td>
                                <td class="text-center">{{$row->name}}</td>
                                <td class="text-center">{{$row->phone}}</td>
                                <td class="text-center">{{$row->email}}</td>
                                <td class="text-lg-center">
                                    <a class='btn btn-raised btn-success btn-circle'
                                       href="{{route('supervisors.restore',$row->id)}}" title="restore" alt="default">
                                        <i class="fa fa-rotate-right"></i>
                                    </a>
                                    <form method="get" id='delete-form-{{ $row->id }}'
                                          action="{{ route('supervisors.terminate', $row->id) }}"
                                          style='display: none;'>
                                        {{csrf_field()}}
                                    </form>
                                    <button title="Terminate" onclick="
                                        if(confirm('are you should to final terminate supervisor?')){
                                            event.preventDefault();
                                            document.getElementById('delete-form-{{ $row->id }}').submit();
                                        }else {
                                            event.preventDefault();
                                        }" class='btn btn-danger btn-circle' href=" ">
                                        <i class="fa fa-trash" aria-hidden='true'></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </div>
    {{--    create new supervisor modal--}}
    <div id="create-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">add new supervisor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    {{ Form::open( ['route'  => ['supervisors.store'],'method'=>'post' , 'class'=>'form','files'=>true] ) }}
                    <div class="form-group">
                        <label for="recipient-name"
                               class="control-label">user name</label>
                        {{ Form::text('name',null,["class"=>"form-control" ,"required"]) }}
                    </div>
                    <div class="form-group">
                        <label for="recipient-name"
                               class="control-label">phone</label>
                        {{ Form::number('phone',null,["class"=>"form-control" ,"required"]) }}
                    </div>
                    <div class="form-group">
                        <label for="recipient-name"
                               class="control-label">email</label>
                        {{ Form::email('email',null,["class"=>"form-control" ,"required"]) }}
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                        <div style="color: red;" class="form-control-feedback">password should contain numbers,alphabets
                            and symbols
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">confirm password</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name"
                               class="control-label">avatar</label>
                        <input type="file" required name="image" id="input-file-now" class="dropify"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        close
                    </button>
                    {{ Form::submit( 'add' ,['class'=>'btn btn-info','style'=>'margin:10px']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
