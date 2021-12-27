@extends('app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/assets/plugins/dropify/dist/css/dropify.min.css') }}">
@endsection
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">details</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('supervisor.home')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('products.index')}}">Products</a></li>
                <li class="breadcrumb-item active">details</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">

                            <img src="{{$data->image}}">
                            <br>
                            <br>
                            @if($data->Images)
                                @foreach($data->Images as $row)
                                    <img style="width: 100px" src="{{$row->image}}">
                                @endforeach
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-8 col-lg-9">
                                    <h3 class="box-title m-b-0">Name : </h3> {{$data->name}}
                                    <h3 class="box-title m-b-0">Category : </h3>
                                    <small> {{$data->Category->name}}</small>
                                    <br>
                                    <h3 class="box-title m-b-0">Details : </h3>
                                    <address>
                                        {{$data->description}}
                                        <br>
                                        <br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
