@extends('app')
@section('styles')
    <!--For icon picker -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
    <link rel="stylesheet" href="{{ asset('/iconPicker/dist/css/bootstrap-iconpicker.min.css') }}"/>
@endsection
@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Categories</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('supervisor.home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Categories</li>
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

                    <div class="card-title">
                        {{--for display modal to create new supervisor ...--}}
                        <button alt="default" data-toggle="modal" data-target="#create-modal"
                                class="btn btn-success btn-bg">
                            <i class="fa fa-plus"></i>
                            add new
                        </button>
                        <button id="delete" class="btn btn-warning btn-bg">
                            <i class="fa fa-trash"></i>
                            Delete selected
                        </button>
                        <a href="{{route('categories.trashed')}}" style="float: right;" class="btn btn-danger btn-bg">
                            <i class="fa fa-trash"></i>
                            Trash
                        </a>
                    </div>
                    <br>
                    <table id="example23"
                           class="tablesaw table-striped table-hover table-bordered table tablesaw-columntoggle">
                        <thead>
                        <tr>
                            <th class="text-center">
                            </th>
                            <th class="text-center">icon</th>
                            <th class="text-center">name</th>
                            <th class="text-center">actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $row)
                            <tr id="tr_{{$row->id}}">
                                <td class="text-center">
                                    <div class="demo-checkbox">
                                        <input name="deleteBox" data-id="{{$row->id}}" type="checkbox"
                                               id="checkbox_{{$row->id}}" value="{{$row->id}}"
                                               class="filled-in chk-col-amber checkdelete">
                                        <label for="checkbox_{{$row->id}}"></label>
                                    </div>
                                </td>
                                <td class="text-center"><i class="{{$row->icon}}"></i></td>
                                <td class="text-center">{{$row->name}}</td>
                                <td class="text-lg-center">
                                    <a class='btn btn-raised btn-info btn-circle'
                                       href="{{url('categories/'.$row->id.'/edit')}}"
                                       data-editid="{{$row->id}}" id="edit" title="update" alt="default">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form method="post" id='delete-form-{{ $row->id }}'
                                          action="{{ route('categories.destroy', ['category' => $row->id]) }}"
                                          style='display: none;'>
                                        {{csrf_field()}}
                                        {{ method_field('DELETE') }}
                                    </form>
                                    <button title="delete" onclick="
                                        if(confirm('are you should to delete ?')){
                                        event.preventDefault();
                                        document.getElementById('delete-form-{{ $row->id }}').submit();
                                        }else {
                                        event.preventDefault();
                                        }" class='btn btn-warning btn-circle' href=" ">
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
                    <h4 class="modal-title">add new category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    {{ Form::open( ['route'  => ['categories.store'],'method'=>'post' , 'class'=>'form','files'=>true] ) }}
                    <div class="form-group">
                        <label for="recipient-name"
                               class="control-label">name</label>
                        {{ Form::text('name',null,["class"=>"form-control" ,"required"]) }}
                    </div>
                    <div class="form-group">
                        <label for="recipient-name"
                               class="control-label">icon</label>
                        <div role="iconpicker" name="icon"></div>
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
@section('script')
    {{--    script for multi delete rows of superviso--}}
    <script type="text/javascript">
        $("#delete").on("click", function () {
            var dataList = [];
            $(".checkdelete:checked").each(function (index) {
                dataList.push($(this).val())
            })
            if (dataList.length > 0) {
                swal({
                    title: "Are you sure to delete?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            var CSRF_TOKEN = '{{ csrf_token() }}';
                            $.ajax({
                                url: '{{route("categories.multiple_delete")}}',
                                type: "post",
                                data: {'id': dataList, _token: CSRF_TOKEN},
                                dataType: "JSON",
                                success: function (data) {
                                    if (data.message == "Success") {
                                        //success response ..
                                        //to remove selected row
                                        $('input[name="deleteBox"]:checkbox:checked').parents("tr").remove();
                                        swal("your selected categories has been deleted successfully!", {
                                            icon: "success",
                                        });
                                        // location.reload();
                                    } else {
                                        swal("something wrong!");
                                    }
                                },
                                fail: function (xhrerrorThrown) {
                                    swal("something wrong!");
                                }
                            });
                        } else {
                            swal("something wrong!");
                        }
                    });
            }
        });
    </script>

    <!-- Bootstrap CDN For icon picker -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript"
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{{ asset('/iconPicker/dist/js/bootstrap-iconpicker.bundle.min.js')}}"></script>
@endsection

