@extends('app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/assets/plugins/dropify/dist/css/dropify.min.css') }}">
@endsection
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Products</h3>
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
                    <table id="example23"
                           class="tablesaw table-striped table-hover table-bordered table tablesaw-columntoggle">
                        <thead>
                        <tr>
                            <th class="text-center">image</th>
                            <th class="text-center">name</th>
                            <th class="text-center">category</th>
                            <th class="text-center">actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $row)
                            <tr id="tr_{{$row->id}}">
                                <td class="text-center"><img src="{{$row->image}}" style="width: 100px;"></td>
                                <td class="text-center">{{$row->name}}</td>
                                <td class="text-center"> @if($row->Category) {{$row->Category->name}} @endif </td>
                                <td class="text-lg-center">
                                    <a class='btn btn-raised btn-warning btn-circle'
                                       href="{{url('products/'.$row->slug)}}"title="details" alt="default">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a class='btn btn-raised btn-info btn-circle'
                                       href="{{url('products/'.$row->id.'/edit')}}"
                                       data-editid="{{$row->id}}" id="edit" title="update" alt="default">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form method="post" id='delete-form-{{ $row->id }}'
                                          action="{{ route('products.destroy', ['product' => $row->id]) }}"
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
    <div id="create-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">add new product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    {{ Form::open( ['route'  => ['products.store'],'method'=>'post' , 'class'=>'form','files'=>true] ) }}
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="recipient-name"
                                   class="control-label">name</label>
                            {{ Form::text('name',null,["class"=>"form-control" ,"required"]) }}
                        </div>
                        <div class="col-lg-6">
                            <label for="recipient-name"
                                   class="control-label">category</label>
                            {{ Form::select('category_id', App\Models\Category::pluck('name','id'),null, ["class"=>"form-control"]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name"
                               class="control-label">description</label>
                        {{ Form::textArea('description',null,["class"=>"form-control" ,"required"]) }}
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                        <label for="recipient-name"
                               class="control-label">main image</label>
                            <input type="file" required name="image" id="input-file-now" class="dropify"/>
                        </div>
                        <div class="col-lg-8">
                            <label for="recipient-name"
                                   class="control-label">product images</label>
                            <input type="file" name="images[]"  id="input-file-now" class="dropify" multiple/>
                        </div>
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
@endsection
