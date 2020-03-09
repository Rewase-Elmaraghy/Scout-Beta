@extends('master')

@section('content')
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <div style="opacity: 0.9">
        <div class="row">


            <br>
            @for($i=0;$i < count($notifications);$i++)
                <div class="col-md-3">
                    <div class="img-thumbnail" style="margin:10px">
                        <form id="Accept_form" method="post" action="/store">
                            <label id="name" class="control-label" for="">{{$notifications[$i]->name}}
                                requests using {{$notifications[$i]->demand}} of
                                {{$notifications[$i]->category_name}} <br>
                                where available is {{$notifications[$i]->available}}
                            </label>
                            <br>
                            <a href="accept_notification/{{$notifications[$i]->id}}" class="btn btn-success">Accept</a>
                            {!!csrf_field()!!}
                            <a href="delete_notification/{{$notifications[$i]->id}}" class="btn btn-danger">Reject</a>
                        </form>
                    </div>
                </div>

            @endfor
        </div>
    </div>
@stop
