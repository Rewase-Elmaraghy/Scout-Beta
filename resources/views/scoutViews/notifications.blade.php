@extends('master')

@section('content')
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <div style="opacity: 0.9">
        <div class="row">

            <br>
            @for($i=0;$i < count($notifications);$i++)
                <div class="col-md-3">
                    <div class="img-thumbnail" style="margin:10px">
                        <label id="name" class="control-label" for="">{{$notifications[$i]->name}}
                            requests using {{$notifications[$i]->demand}} of
                            {{$notifications[$i]->category_name}} <br>
                            where available is {{$notifications[$i]->available}}
                        </label>

                        <div class="row" style="margin: 1px">
                            <form id="Accept" method="post" action="accept_notification">
                                <button id="Accept_button" class="btn btn-success X"
                                        @if($notifications[$i]->demand > $notifications[$i]->available)style="display: none"
                                    @endif>Accept
                                </button>
                                <input type="number" name="demand_id" value="{{$notifications[$i]->id}}"
                                       style="display:none;"/>
                                <input type="number" name="id" value="{{$id}}" style=" display:none;"/>
                                {!!csrf_field()!!}
                            </form>
                            &nbsp;
                            <form id="Reject" method="post" action="delete_notification">
                                <button id="Reject_button" class="btn btn-danger">Reject</button>
                                <input type="number" name="demand_id" value="{{$notifications[$i]->id}}"
                                       style="display:none;"/>
                                <input type="number" name="id" value="{{$id}}" style=" display:none;"/>
                                {!!csrf_field()!!}
                            </form>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <br> <br>

        <div class="row" @if(count($notifications) == 0) style="display: none" @endif>
            <div class="col-md-1"></div>
            <form id="Accept_all" method="post" action="accept_all_notification">
                <button id="Accept_all_button" class="btn btn-success"
                        @if($X == 0)style="display: none"
                    @endif>Accept All
                </button>
                <input type="number" name="id" value="{{$id}}" style=" display:none;"/>
                {!!csrf_field()!!}
            </form>
            &nbsp;
            <form id="Reject_all" method="post" action="delete_all_notification">
                <button id="Reject_all_button" class="btn btn-danger">Reject All</button>
                <input type="number" name="id" value="{{$id}}" style=" display:none;"/>
                {!!csrf_field()!!}
            </form>
        </div>
    </div>
@stop
