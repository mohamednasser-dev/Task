@extends('app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/assets/plugins/dropify/dist/css/dropify.min.css') }}">
@endsection
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">supervisors</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">supervisors</li>
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
                            <th class="text-center">avatar</th>
                            <th class="text-center">user name</th>
                            <th class="text-center">phone</th>
                            <th class="text-center">email</th>
                            <th class="text-center">Block / Unblock</th>
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
                                <td class="text-center"><img src="{{$row->image}}" style="width: 100px;"></td>
                                <td class="text-center">{{$row->name}}</td>
                                <td class="text-center">{{$row->phone}}</td>
                                <td class="text-center">{{$row->email}}</td>
                                <td class="text-center">
                                    <div class="switch">
                                        <label>
                                            <input onchange="update_active(this)" value="{{ $row->id }}"
                                                   type="checkbox" <?php if ($row->status == 'Unblock') echo "checked";?> >
                                            <span class="lever switch-col-indigo"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-lg-center">
                                    <a class='btn btn-raised btn-success btn-circle'
                                       href="{{url('supervisors/'.$row->id.'/edit')}}"
                                       data-editid="{{$row->id}}" id="edit" title="update" alt="default">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form method="post" id='delete-form-{{ $row->id }}'
                                          action="{{ route('supervisors.destroy', ['supervisor' => $row->id]) }}"
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
@section('script')
    <!-- jQuery file upload -->
    <script src="{{ asset('/assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            // Basic
            $('.dropify').dropify();

            // Translated
            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove: 'Supprimer',
                    error: 'Désolé, le fichier trop volumineux'
                }
            });

            // Used events
            var drEvent = $('#input-file-events').dropify();

            drEvent.on('dropify.beforeClear', function (event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function (event, element) {
                alert('File deleted');
            });

            drEvent.on('dropify.errors', function (event, element) {
                console.log('Has Errors');
            });

            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function (e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        });
    </script>
{{--    script for change supervisor status [Block , unblock]--}}
    <script type="text/javascript">
        function update_active(el) {
            if (el.checked) {
                var status = 'Unblock';
            } else {
                var status = 'Block';
            }
            $.post('{{ route('supervisor.change_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    console.log('daaa = '.data);
                    toastr.success("status changed successfully");
                } else {
                    toastr.error("error hapend !");
                }
            });
        }
    </script>
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

