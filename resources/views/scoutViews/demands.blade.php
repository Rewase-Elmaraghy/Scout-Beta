@extends('master')

@section('content')
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <div style="opacity: 0.9">
        <div class="row">


            <br>
            @for($i=0;$i < count($demands);$i++)
                <div class="col-md-2">
                    <form id="user" method="post" action="notifications">
                        <div class="img-thumbnail" style="margin:10px">
                            <label id="name" class="control-label" for="">Requests from: {{$demands[$i]->name}}</label>
                            <input type="number" name="id" value="{{$demands[$i]->id}}"
                                   style=" display:none;"/>
                            <br>
                            {!!csrf_field()!!}
                            <button id="Send_demands" class="btn btn-primary">Explore</button>
                        </div>
                    </form>
                </div>

            @endfor
        </div>
    </div>
@stop
