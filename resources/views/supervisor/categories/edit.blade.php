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
            <h3 class="text-themecolor">edit</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('supervisor.home')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('categories.index')}}">Categories</a></li>
                <li class="breadcrumb-item active">edit</li>
            </ol>
        </div>
    </div>
{{--    content--}}
    <input type="hidden" value="{{$data->icon}}" id="txt_icon">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::model($data, ['route' => ['categories.update',$data->id] , 'method'=>'put' , 'files'=>true ]) !!}
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">name</label>
                        <div class="col-md-10">
                            {{ Form::text('name',$data->name,["class"=>"form-control" ,"required"]) }}
                        </div>
                    </div>
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input"
                               class="col-md-2 col-form-label">icon</label>
                            <div role="iconpicker" name="icon" data-iconset="lastest" data-iconset="fontawesome5" data-search-text="{{$data->icon}}" data-icon="{{$data->icon}}"></div>
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
    <!-- Bootstrap CDN For icon picker -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript"
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{{ asset('/iconPicker/dist/js/bootstrap-iconpicker.bundle.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            icon = $(this).data('txt_icon');
            $('input[name="icon"]').val(icon);
        });
    </script>
@endsection

