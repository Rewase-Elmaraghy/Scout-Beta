@extends('master')

@section('content')
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <div style="opacity: 0.9">
        <div class="row">
            <div class="col-md-6">
                <div class="img-thumbnail" style="margin:10px;border-radius: 50%;border:#F0F0F0;alignment:center">
                    <img src="../images/{{$categories[0]->image_name}}" style="width:75%;height:75%;border-radius: 50%">
                    <form id="quantities" method="post" action="{{$categories[0]->id}}/store">
                        <br>
                        <label id="name" class="control-label"
                               for="">Category: {{$categories[0]->category_name}}</label>
                        <br>
                        <label id="available" class="control-label"
                               for="">Available: {{$categories[0]->available}}</label>

                        <input type="number" name="category_id" id="category_id" value="{{$categories[0]->id}}"
                               style="visibility:hidden;"/>
                        <br>
                        {!!csrf_field()!!}
                        <label id="Demand" class="control-label" for="Demand_Quantity">Demand: </label>
                        <input type="number" class="y" name="Demand_Quantity"
                               id="{{$categories[0]->category_name}}_quantity"
                               min="1" max="{{$categories[0]->available}}" autofocus
                               onkeypress="return isNumber(event)"/>
                        <br><br>
                        <button id="Send_Request" class="btn btn-primary">Send Request</button>
                    </form>
                </div>
            </div>
        </div>
        <br>
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
