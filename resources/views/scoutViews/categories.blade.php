@extends('master')

@section('content')
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <div style="opacity: 0.9">
        <form id="quantities" method="post" action="{{ url('/store') }}">
            <div class="row">
                <br>
                @foreach($categories as $category)
                    <div class="col-sm-3">
                        <div class="img-thumbnail card-body" style="margin:10px">
                            <img src="images/{{$category->image_name}}" style="width:100%;height: 300px">
                            <label id="name1" class="control-label"
                                   for="">Category: {{$category->category_name}}</label>
                            <br>
                            <label id="name" class="control-label" for="">Available: {{$category->available}}</label>
                            <br>
                            <input type="number" name="{{$category->id}}" value="{{$category->id}}"
                                   style=" display:none;"/>
                            <label id="Demand" class="control-label" for="Demand_Quantity">Demand: </label>
                            <input type="number" class="y" name="{{$category->id}}_quantity"
                                   min="1" max="{{$category->available}}" autofocus
                                   onkeypress="return isNumber(event)"/>
                            {!!csrf_field()!!}
                        </div>
                        <br>
                    </div>
                @endforeach
            </div>
            <br>
            <div class="col-sm-2"></div>
            <div class="col-sm-2">
                <button id="Send_Request" class="btn btn-primary" @if(count($categories)== 0)
                style="display: none"
                @endif>Send Request</button>
            </div>
            <br><br><br><br>

            <br><br>
        </form>
    </div>

    <script>
        function isNumber(event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode > 31 && (charCode != 46 && (charCode < 48 || charCode > 57)))
                return false;
            else true;
        }
    </script>

@stop
