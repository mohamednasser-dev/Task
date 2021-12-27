@extends('app')
@section('styles')
    {{--   for file upload--}}
    <link rel="stylesheet" href="{{ asset('/assets/plugins/dropify/dist/css/dropify.min.css') }}">
@endsection
@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">edit</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('supervisor.home')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('products.index')}}">Products</a></li>
                <li class="breadcrumb-item active">edit</li>
            </ol>
        </div>
    </div>
    {{--    content--}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::model($data, ['route' => ['products.update',$data->id] , 'method'=>'put' , 'files'=>true ]) !!}
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="recipient-name"
                                   class="control-label">name</label>
                            {{ Form::text('name',$data->name,["class"=>"form-control" ,"required"]) }}
                        </div>
                        <div class="col-lg-6">
                            <label for="recipient-name"
                                   class="control-label">category</label>
                            {{ Form::select('category_id', App\Models\Category::pluck('name','id'),$data->category_id, ["class"=>"form-control"]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name"
                               class="control-label">description</label>
                        {{ Form::textArea('description',$data->description,["class"=>"form-control" ,"required"]) }}
                    </div>
                    <div class="form-group row">
                        <h3>main images</h3>
                        <div class="col-lg-12">
                            <label for="recipient-name"
                                   class="control-label">main image</label>
                            <input type="file" data-default-file="{{$data->image}}" name="image" id="input-file-now"
                                   class="dropify"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <h3>product images</h3>
                        <div class="col-lg-12">
                            <label for="recipient-name"
                                   class="control-label">product images</label>
                            <input type="file" name="images[]" id="input-file-now" class="dropify" multiple/>
                        </div>
                    </div>
                    <div class="form-group row">
                        @if($data->Images)
                            @foreach($data->Images as $row)
                                <img style="width: 100px" src="{{$row->image}}">
                                <a href="{{route('product.image.delete',$row->id)}}"
                                   class="btn btn-danger btn-circle"><i class="fa fa-trash"></i> </a>
                            @endforeach
                        @endif
                    </div>
                    <div class="center">
                        {{ Form::submit( 'update' ,['class'=>'btn btn-info','style'=>'margin:10px']) }}
                    </div>
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

