@extends('app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/assets/plugins/dropify/dist/css/dropify.min.css') }}">
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
                    </div>
                    <br>
                    <button style="margin: 5px;" class="btn btn-danger btn-xs delete-all" data-url="">Delete All</button>
                    <table id="example23"
                           class="tablesaw table-striped table-hover table-bordered table tablesaw-columntoggle">
                        <thead>
                        <tr>
                            <th class="text-center" >
                                <div class="demo-checkbox">
                                    <input type="checkbox" id="check_all" class="filled-in">
                                    <label for="check_all"></label>
                                </div>
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
                                        <input data-id="{{$row->id}}" type="checkbox" id="checkbox_{{$row->id}}" class="filled-in">
                                        <label for="checkbox_{{$row->id}}"></label>
                                    </div>
                                </td>
                                <td class="text-center"><i class="fa {{$row->icon}}"></i></td>
                                <td class="text-center">{{$row->name}}</td>
                                <td class="text-center">{{$row->slug}}</td>
                                <td class="text-lg-center">
                                    <a class='btn btn-raised btn-success btn-circle'
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
                               class="control-label">slug</label>
                        {{ Form::text('slug',null,["class"=>"form-control" ,"required"]) }}
                    </div>
                    <select name="icon" class="form-control bs-select" required>
                        <option data-icon="fa fa-user">user</option>
                        <option data-icon="fa-circle icon-warning">Gold</option>
                        <option data-icon="fa-circle icon-default">Silver</option>
                        <option data-icon="fa-circle-o" selected="selected">Free</option>
                    </select>

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
        $(document).ready(function () {
            $('#check_all').on('click', function(e) {
                if($(this).is(':checked',true))
                {
                    $(".checkbox").prop('checked', true);
                } else {
                    $(".checkbox").prop('checked',false);
                }
            });
            $('.checkbox').on('click',function(){
                if($('.checkbox:checked').length == $('.checkbox').length){
                    $('#check_all').prop('checked',true);
                }else{
                    $('#check_all').prop('checked',false);
                }
            });
            $('.delete-all').on('click', function(e) {
                var idsArr = [];
                $(".checkbox:checked").each(function() {
                    idsArr.push($(this).attr('data-id'));
                });
                if(idsArr.length <=0)
                {
                    alert("Please select at least one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected supervisors?")){
                        var strIds = idsArr.join(",");
                        $.ajax({
                            url: "{{ route('supervisor.multiple_delete') }}",
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids='+strIds,
                            success: function (data) {
                                if (data['status']==true) {
                                    $(".checkbox:checked").each(function() {
                                        $(this).parents("tr").remove();
                                    });
                                    alert(data['message']);
                                } else {
                                    alert('Whoops Something went wrong!!');
                                }
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });
                    }
                }
            });
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                onConfirm: function (event, element) {
                    element.closest('form').submit();
                }
            });
        });
    </script>
@endsection

