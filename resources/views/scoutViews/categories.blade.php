@extends('master')

@section('content')
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <div style="opacity: 0.9">
        <div class="row">

            <br>
            @foreach($categories as $category)
                <div class="col-sm-3">
                    <div class="img-thumbnail card-body" style="margin:10px">
                        <img src="images/{{$category->image_name}}" style="width:100%;height: 300px">
                        <label id="name" class="control-label" for="">Category: {{$category->category_name}}</label>
                        <br>
                        <a href="eachCategory/{{$category->id}}" class="btn btn-primary">Details</a>
                        {!!csrf_field()!!}
                    </div>
                </div>


            @endforeach
        </div>
    </div>

@stop
