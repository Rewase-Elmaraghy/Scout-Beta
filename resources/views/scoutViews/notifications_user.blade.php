@extends('master')

@section('content')
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <div style="opacity: 0.9">
        <div class="row">

            <br>
            @for($i=0;$i < count($notifications);$i++)
                <div class="col-md-3">
                    <div class="img-thumbnail card" style="margin:10px;background:
                    @if($notifications[$i]->Accepted ==1)
                        #7bff71
                    @elseif($notifications[$i]->Accepted ==0)
                        Red
                    @elseif($notifications[$i]->Accepted ==2)
                        Grey
                    @else
                    @endif">
                        <form id="Accept_form" method="post" action="/store">
                            <label id="name" class="control-label" for=""> your request's status for
                                using {{$notifications[$i]->demand}} of
                                {{$notifications[$i]->category_name}} <br>
                                is :
                                <br>
                                @if($notifications[$i]->Accepted ==1)
                                    Accepted
                                @elseif($notifications[$i]->Accepted ==0)
                                    Refused
                                @elseif($notifications[$i]->Accepted ==2)
                                    Pending
                                @else
                                    Database is Compromised
                                @endif
                            </label>
                            <br>

                            {!!csrf_field()!!}
                            <a href="notifications_user/ack/{{$notifications[$i]->id}}" class="btn btn-primary"
                               style="display:
                               @if($notifications[$i]->Accepted ==2) none
                               @endif">OK</a>
                            <a href="notifications_user/cancel_request/{{$notifications[$i]->id}}"
                               class="btn btn-primary" style="display:
                            @if($notifications[$i]->Accepted !=2) none
                            @endif">Cancel Request</a>
                        </form>
                    </div>
                </div>

            @endfor
        </div>
    </div>

@stop
